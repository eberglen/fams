<?php
if(isset($_POST['idUsers'])){
  include 'dbconn.inc.php';
  $idUsers = $_POST['idUsers'];

  $sql = "DELETE FROM users WHERE user_num = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location:../user_admin.php?error=sqlerror");
    exit();
  }
  else{

  mysqli_stmt_bind_param($stmt, "s", $idUsers);
  mysqli_stmt_execute($stmt);
  header("Location:../user_admin.php?success=deluser");
  exit();

  }
}
?>
