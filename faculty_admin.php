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
    function wind_ref(){
      window.location.reload();
    }
  </script>
  <script type="text/javascript">
  //$('#sched_table').load(document.URL +  ' #sched_table');
  function add_fac(){
    var r = confirm("Are you sure you want to add faculty?");
    if (r == true) {
      var fn = document.getElementById("fn").value;
      var ln = document.getElementById("ln").value;
      var email = document.getElementById("email").value;
        $.ajax({
          type: 'POST',
          url: 'includes/add_fac.inc.php',
          data: { fn: fn, ln: ln , email: email},
          success:function(html){
            $('#add_fac_status').html(html);
          }
        });
      }
    }
  </script>
</head>
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
<body>
<div class="container shadow mt-5 pt-3">
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link text-danger" href="home_admin.php">Attendance</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="schedule_admin.php">Schedule</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="faculty_admin.php">Faculty</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="user_admin.php">Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link text-danger" href="export_admin.php">Export</a>
    </li>
  </ul>
  <div class="row animated fadeIn faster">
    <div class="col-md-4"><br>
      <h2 align="center">Add Faculty</h2><br>
      <div class="form-row mb-4">
          <div class="col">
              <!-- First name -->
              <input type="text" id="fn" class="form-control" placeholder="First name">
          </div>
          <div class="col">
              <!-- Last name -->
              <input type="text" id="ln" class="form-control" placeholder="Last name">
          </div>
      </div>


      <!-- E-mail -->
      <input type="email" id="email" class="form-control mb-4" placeholder="E-mail">
      <button type="button" class="btn btn-block btn-outline-danger waves-effect" onClick="add_fac();">Add</button><br>
      <div id="add_fac_status" name="add_fac_status"></div>
    </div>
    <div class="col-md-8"><br>
      <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">E-mail Address</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM faculty
                  ;";
            $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)) {
            $fac_id = $row['faculty_id'];
            $fn = $row['first_name'];
            $ln = $row['last_name'];
            $email = $row['email_add'];
            echo '
            <tr>
              <th scope="row">'.$fn.'</th>
              <td>'.$ln.'</td>
              <td>'.$email.'</td>
              <td><form action="includes/delete_fac.inc.php" method="POST" onsubmit="return confirm(&quot Are you sure you want to delete faculty? NOTE: Schedule and attendance of this faculty will also be DELETED. &quot);">
                <input type="hidden" name="fac_id" value="'.$fac_id.'"></input>
                <button type="submit" class="btn btn-danger px-3 waves-effect waves-light btn-sm"><i class="far fa-trash-alt"></i></button>
              </form></td>
            </tr>
            ';
          }
          ?>
        </tbody>
      </table>
    </div>
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
        if ($_GET['success'] == 'delfac'){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong>Faculty <strong>deleted</strong> successfully.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
        }
      }
      ?>

    </div>
  </div>
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
