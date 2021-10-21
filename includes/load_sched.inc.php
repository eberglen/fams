<?php
if (isset($_POST['curriculum_num'])){
  include 'dbconn.inc.php';
  $acad_yr_id = $_POST['curriculum_num'];

  echo '
  <div class="row animated fadeIn faster">
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Schedule</th>
            <th scope="col">Subject</th>
            <th scope="col">Room</th>
            <th scope="col">Delete</th>
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

    echo '
    <tr>
      <th scope="row">'.$ln.'</th>
      <td>'.$fn.'</td>
      <td>'.$start.'-'.$end.' ('.$day.')</td>
      <td>'.$subject.'</td>
      <td>'.$room.'</td>
      <td><form action="includes/delete_sched.inc.php" method="POST" onsubmit="return confirm(&quot Are you sure you want to delete schedule?&quot);">
        <input type="hidden" name="sid" value="'.$sid.'"></input>
        <button type="submit" class="btn btn-danger px-3 waves-effect waves-light btn-sm"><i class="far fa-trash-alt"></i></button>
      </form></td>
    </tr>
    ';

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
