<?php
if (isset($_POST['curriculum_num'])){
  include 'dbconn.inc.php';
  $acad_yr_id = $_POST['curriculum_num'];

  echo '
  <div class="row">
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered table-responsive-md">
        <thead>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Schedule</th>
            <th scope="col">Subject</th>
            <th scope="col">Room</th>
            <th scope="col">Recorded</th>
            <th scope="col">Checker</th>
            <th scope="col">Remarks</th>
            <th scope="col">Edit</th>
          </tr>
        </thead>
        <tbody>
  ';

  $sql = 'SELECT first_name, last_name, TIME_FORMAT(t_start, "%h:%i %p") as t_start, TIME_FORMAT(t_end, "%h:%i %p") as t_end, subject, room, GROUP_CONCAT(day) as day, schedule.schedule_id as schedule_id
          FROM schedule, faculty, schedule_days
          WHERE schedule.faculty_id = faculty.faculty_id
          AND schedule.schedule_id = schedule_days.schedule_id
          AND acad_yr_id = '.$acad_yr_id.'
          GROUP BY schedule.schedule_id
          ORDER BY last_name
          ;';
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)) {
    $fn = $row['first_name'];
    $ln = $row['last_name'];
    $start = $row['t_start'];
    $end = $row['t_end'];
    $subject = $row['subject'];
    $room = $row['room'];
    $day = $row['day'];
    $sid = $row['schedule_id'];

    $sql2 = "SELECT * FROM attendance WHERE schedule_id = $sid
            ;";
    $result2 = mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
      $recorded = $row2['recorded'];
      $remarks = $row2['remarks'];
      $atten_num = $row2['attendance_num'];
      $checker = $row2['checker_name'];
      echo '
      <tr>
        <th scope="row">'.$ln.'</th>
        <td>'.$fn.'</td>
        <td>'.$start.'-'.$end.' ('.$day.')</td>
        <td>'.$subject.'</td>
        <td>'.$room.'</td>
        <td>'.$recorded.'</td>
        <td>'.$checker.'</td>
        <td>'.$remarks.'</td>
        <td>
          <a href="" class="btn btn-primary btn-rounded mb-4 btn-sm" data-toggle="modal" data-target="#AV'.$sid.'E"><i class="far fa-edit"></i></a>

          <form action="includes/edit_remarks.inc.php" method="POST">
                    <div class="modal fade" id="AV'.$sid.'E" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header text-center">
                            <h4 class="modal-title w-100 font-weight-bold">Edit Remarks</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body mx-3">
                          Remarks
                            <div class="md-form mb-5" name="remarks">
                              <select class="form-control mb-4" name="remarks">
                              <option selected disabled>Select Remark</option>
                              <option value="Present" class="text-success">Present</option>
                              <option value="Late" class="text-warning">Late</option>
                              <option value="Absent" class="text-danger">Absent</option>
                              <option value="Leave" class="text-primary">Leave</option>
                              </select>
                            </div>
                            <input type="hidden" id="anum" name="anum" value="'.$atten_num.'">
                          </div>
                          <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-default">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
            </form>
        </td>
      </tr>
      ';
    }


  }
  echo '
  </tbody>
</table>
</div>
</div>
</div>
  ';
}

?>
