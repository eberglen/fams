<?php
include 'dbconn.inc.php';
if (!empty($_POST['fn']) && !empty($_POST['ln']) && !empty($_POST['email'])){
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $email = $_POST['email'];
  $query = "INSERT INTO faculty (first_name, last_name, email_add) VALUES ('$fn','$ln','$email');";
  $result = $mysqlidb->sql_insert_update($query);
  if ($result){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> Records updated successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onClick="wind_ref()">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  } else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning! </strong> SQL error.
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
