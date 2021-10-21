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
   function create_user(){
     var r = confirm("Are you sure you want to create user?");
     if (r == true) {
       var name = document.getElementById("name").value;
       var uidUsers = document.getElementById("uidUsers").value;
       var pwd = document.getElementById("pwd").value;
       var pwd_rpt = document.getElementById("pwd_rpt").value;
       var position = document.getElementById("position").value;
         $.ajax({
           type: 'POST',
           url: 'includes/create_user.inc.php',
           data: { name: name, username: uidUsers, pwd: pwd, pwd_rpt: pwd_rpt, position: position },
           success:function(html){
             $('#cuser_status').html(html);
           }
         });
       }
   }
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
        <a class="nav-link text-danger" href="home_admin.php">Attendance</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="schedule_admin.php">Schedule</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="faculty_admin.php">Faculty</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="user_admin.php">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-danger" href="export_admin.php">Export</a>
      </li>
    </ul><br>
    <div class="row">
    <div class="col-md-4">
    <h3 align="center">Create User</h3><br>
      <div class="row">
        <div class="col-md-12">Name
          <input type="text" class="form-control" name="name" id="name" placeholder="Name">
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-6">Username
          <input type="text" class="form-control" placeholder="Username" name="uidUsers" id="uidUsers">
        </div>
        <div class="col-md-6">Position
          <select class="custom-select custom-select-md" name="position" id="position">
            <option selected disabled value="">Select Position</option>
            <option value="Admin">Admin</option>
            <option value="Checker">Checker</option>
            <option value="Dean">Dean</option>
          </select>
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-6">Password
          <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd">
        </div>
        <div class="col-md-6">Repeat Password
          <input type="password" class="form-control" placeholder="Repeat Password" name="pwd_rpt" id="pwd_rpt">
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-12" align="center">
          <button type="submit" class="btn btn-block btn-outline-danger waves-effect" onClick="create_user()">Create</button>
        </div>
      </div>
      <div name="cuser_status" id="cuser_status"></div><br><br>
    </div>
    <div class="col-md-8">
      <h3 align="center">Users</h3><br>
      <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Position</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>

            <?php
            $sql = "SELECT *
                    FROM users
                    ;";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
              $user_num = $row['user_num'];
              $username = $row['username'];
              $name = $row['name'];
              $position = $row['position'];

              echo '
                  <tr>
                    <th scope="row">'.$name.'</th>
                    <td>'.$position.'</td>
                    <td>'.$username.'</td>
                    <td><form action="includes/reset_pwd.inc.php" method="POST" onsubmit="return confirm(&quot Are you sure you want to reset password?&quot);">
                      <input type="hidden" name="idUsers" value="'.$user_num.'"></input>
                      <button type="submit" class="btn btn-default btn-sm">Reset</button>
                    </form></td>
                    <td><form action="includes/delete_user.inc.php" method="POST" onsubmit="return confirm(&quot Are you sure you want to delete user?&quot);">
                      <input type="hidden" name="idUsers" value="'.$user_num.'"></input>
                      <button type="submit" class="btn btn-danger px-3 waves-effect waves-light btn-sm"><i class="far fa-trash-alt"></i></button>
                    </form></td>
                  </tr>';
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
        if ($_GET['success'] == 'pwdreset'){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong>Passowrd has been set to <strong>sbu@2020</strong>.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>';
        }
        else if ($_GET['success'] == 'deluser'){
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong>User <strong>deleted</strong> successfully.
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
