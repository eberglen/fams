<?php
if(!empty($_POST['faculty']) && !empty($_POST['t_start']) && !empty($_POST['t_end']) && !empty($_POST['acad_id']) && !empty($_POST['subject']) && !empty($_POST['room']) && isset($_POST['day'])){
  include 'dbconn.inc.php';
  $fid = $_POST['faculty'];
  $t_start = $_POST['t_start'];
  $t_end = $_POST['t_end'];
  $acad_id = $_POST['acad_id'];
  $subj = $_POST['subject'];
  $room = $_POST['room'];
  $day = $_POST['day'];
  $days = [];
  if (isset($day[0]))
    array_push($days,$day[0]);
  if (isset($day[1]))
    array_push($days,$day[1]);
  if (isset($day[2]))
    array_push($days,$day[2]);
  if (isset($day[3]))
    array_push($days,$day[3]);
  if (isset($day[4]))
    array_push($days,$day[4]);
  if (isset($day[5]))
    array_push($days,$day[5]);

  $query = "INSERT INTO schedule (faculty_id, t_start, t_end, subject, acad_yr_id, room)
            VALUES
            ($fid, '$t_start', '$t_end', '$subj', $acad_id, '$room');
            ";

  $values = '';
    foreach ($days as $day){
      $values .= "(LAST_INSERT_ID(),".$day."),";
    }
  $values = substr($values, 0, -1);
  $query .= "INSERT INTO schedule_days
              VALUES
              $values;";


  $result = mysqli_multi_query($conn, $query);
  if ($result){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> Records updated successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="wind_ref()">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  } else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning! </strong> SQL error.'.$query.'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  }
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
