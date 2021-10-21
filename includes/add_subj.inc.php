<?php
if (isset($_POST['subj'])){
  include 'dbconn.inc.php';
  $subj = $_POST['subj'];

  $sql = "INSERT INTO subjects (subject)
          VALUES ('$subj')
          ;";
  $result = mysqli_query($conn, $sql);
  if ($result){
    header("Location:../schedule_admin.php?success=subjadded");
    exit();
  }
  else{
    header("Location:../schedule_admin.php?error=sqlerrorSUBJ");
    exit();
  }
}
 ?>
