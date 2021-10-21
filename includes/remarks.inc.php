<?php
if(isset($_POST['submit'])){
  session_start();
  $name = $_SESSION['name'];

  include 'dbconn.inc.php';
  $sid = $_POST['schedule_id'];
  $remarks = $_POST['remarks'];
  date_default_timezone_set("Asia/Hong_Kong");
  $recorded = date("Y-m-d H:i:s");

  $query = "INSERT INTO attendance (recorded, schedule_id, checker_name, remarks)
            VALUES
            ('$recorded',$sid,'$name','$remarks');";
  $result = $mysqlidb->sql_insert_update($query);
  if ($result){
    header("Location:../checker.php?success=recorded");
    exit();
  } else {
    header("Location:../checker.php?error=sqlerror");
    exit();
  }
}
?>
