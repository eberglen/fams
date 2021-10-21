<?php
if(isset($_POST['anum']) && isset($_POST['remarks'])){
  include 'dbconn.inc.php';
  $atten_num = $_POST['anum'];
  $remarks = $_POST['remarks'];

  $query = "UPDATE attendance
            SET remarks = '$remarks'
            WHERE attendance_num = $atten_num
          ;";
  $result = $mysqlidb->sql_insert_update($query);
  if ($result){
    header("Location:../home_admin.php?success=recorded");
    exit();
  } else {
    header("Location:../home_admin.php?error=sqlerror");
    exit();
  }
}
else{
  header("Location:../home_admin.php?error=emptyfields");
  exit();
}

 ?>
