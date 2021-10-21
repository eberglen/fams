<?php
session_start();
if (isset($_SESSION['position'])){
  if ($_SESSION['position'] == 'Admin'){
include 'includes/dbconn.inc.php';
?>
<!doctype html>
<html lang="en">
<head>
  <title>Faculty Attendance Monitoring</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="mdbootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="mdbootstrap/css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="mdbootstrap/css/style.css" rel="stylesheet">
  <script type="text/javascript" src="mdbootstrap/js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="mdbootstrap/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="mdbootstrap/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="mdbootstrap/js/mdb.min.js"></script>
  <script type="text/javascript">
     $(document).ready(function(){
       $('#cur_num').on('change',function(){
         var curriculum_num = $(this).val();
         if(curriculum_num){
           $.ajax({
             type: 'POST',
             url: 'includes/load_attendance.inc.php',
             data: 'curriculum_num=' + curriculum_num,
             success:function(html){
               $('#attendance_table').html(html);
             }
           });
         }
       });
     });
   </script>
   <nav class="mb-1 navbar navbar-expand-lg navbar-dark danger-color-dark">
     <a class="navbar-brand" href="home_admin.php"><img src="includes/FAMS128.png" height="30" class="d-inline-block align-top"
       alt="mdb logo" >Faculty Attendance Monitoring</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
       <ul class="navbar-nav ml-auto">
         <li class="nav-item">
           <a class="nav-link waves-effect waves-light" href="account.php">
             <i class="fas fa-user-alt"></i> Account
           </a>
         </li>
         <li class="nav-item">
           <a class="nav-link waves-effect waves-light" href="includes/logout.inc.php">
             <i class="fas fa-sign-out-alt"></i> Logout</a>
         </li>
       </ul>
     </div>
   </nav>
</head>
<body>
<div class="container shadow mt-5 pt-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" href="home_admin.php">Attendance</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="schedule_admin.php">Schedule</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="faculty_admin.php">Faculty</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="user_admin.php">Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="export_admin.php">Export</a>
    </li>
  </ul><br>
  <?php
  if (isset($_GET['error'])){
    if ($_GET['error'] == 'sqlerror'){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ERROR. </strong>SQL error.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }
  else if (isset($_GET['success'])){
    if ($_GET['success'] == 'recorded'){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success! </strong>Attendance <strong>updated</strong>.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>';
    }
  }
  ?>
  <H1 align="center">Attendance Table</h1>
  <div class="col-md-12"><br>
      <select class="custom-select mr-sm-2" name="cur_num" id="cur_num">
        <option disabled selected>Select Academic Year...</option>
        <?php
        $sql = "SELECT * FROM acad_yr
                ;";
          $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
          $acad_id = $row['acad_yr_id'];
          $yr = $row['acad_yr'];
          $sem = $row['acad_sem'];
          echo '
          <option value="'.$acad_id.'">'.$yr.' '.$sem.'</option>
          ';
        }
        ?>
      </select>
    <div name="attendance_table" id="attendance_table"></div><br><br>
</div>

</body>
</html>
<?php
}
else if ($_SESSION['position'] == 'Checker'){
  header("Location:./checker.php");
  exit();
}
else if ($_SESSION['position'] == 'Dean'){
  header("Location:./dean.php");
  exit();
}
}
else{
header("Location:./index.php");
exit();
}

 ?>
