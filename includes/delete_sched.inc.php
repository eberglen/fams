<?php
if(isset($_POST['sid'])){
  include 'dbconn.inc.php';
  $sid = $_POST['sid'];

  $sql = "DELETE
          FROM schedule
          WHERE schedule_id = $sid;
          DELETE
          FROM schedule_days
          WHERE schedule_id = $sid;
          ";
  $result = mysqli_multi_query($conn, $sql);
  if ($result){
    header("Location:../schedule_admin.php?success=delsched");
    exit();
  }
  else{
    header("Location:../schedule_admin.php?error=sqlerror");
    exit();
  }
}
 ?>
