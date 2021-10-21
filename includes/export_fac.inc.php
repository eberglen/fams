<?php
if(!empty($_POST['s_date']) && !empty($_POST['e_date']) && !empty($_POST['faculty'])){
  require 'dbconn.inc.php';
  $faculty = $_POST['faculty'];
  $dstart = $_POST['s_date'];
  $dend = $_POST['e_date'];


  $s = date("M d,Y", strtotime($dstart));
  $e = date("M d,Y", strtotime($dend));
  echo '
  <div class="row">
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered" id="facRectable" name="facRectable">
        <thead>
          <tr>
            <th colspan="8">Faculty Attendance ('.$s.' - '.$e.')</th>
          </tr>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Schedule</th>
            <th scope="col">Subject</th>
            <th scope="col">Room</th>
            <th scope="col">Recorded</th>
            <th scope="col">Checker</th>
            <th scope="col">Remarks</th>
          </tr>
        </thead>
        <tbody>
  ';

  $sql = 'SELECT first_name, last_name, TIME_FORMAT(t_start, "%h:%i %p") as t_start, TIME_FORMAT(t_end, "%h:%i %p") as t_end, subject, room, GROUP_CONCAT(day) as day, schedule.schedule_id as schedule_id
          FROM schedule, faculty, schedule_days
          WHERE schedule.faculty_id = faculty.faculty_id
          AND schedule.schedule_id = schedule_days.schedule_id
          AND faculty.faculty_id = '.$faculty.'
          GROUP BY schedule.schedule_id
          ORDER BY t_start
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

    $sql2 = "SELECT *
            FROM attendance
            WHERE schedule_id = $sid
            AND recorded >= '$dstart'
            AND recorded <= '$dend'
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
<button class="btn btn-info" id="btnExport" onclick="fnfacRec();"><i class="fas fa-file-export">Export</i></button>
  ';
}

else{
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Warning: </strong>Empty fields.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>';
}

?>
