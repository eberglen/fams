<?php
if(isset($_POST['fac_id'])){
  include 'dbconn.inc.php';
  $fac_id = $_POST['fac_id'];

  $sql = "DELETE FROM faculty WHERE faculty_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location:../faculty_admin.php?error=sqlerror");
    exit();
  }
  else{

  mysqli_stmt_bind_param($stmt, "s", $fac_id);
  mysqli_stmt_execute($stmt);
  header("Location:../faculty_admin.php?success=delfac");
  exit();

  }
}
?>
