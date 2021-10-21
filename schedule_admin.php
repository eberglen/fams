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
  function add_sy(){
    var r = confirm("Are you sure you want to add the following?");
    if (r == true) {
      var sy = document.getElementById("sy").value;
      var sem = document.getElementById("sem").value;
        $.ajax({
          type: 'POST',
          url: 'includes/add_sy.inc.php',
          data: { sy: sy, sem: sem },
          success:function(html){
            $('#add_sy_status').html(html);
          }
        });
      }
    }
  </script>
  <script type="text/javascript">
  //$('#sched_table').load(document.URL +  ' #sched_table');
  function add_sched(){
    var r = confirm("Are you sure you want to add the following?");
      if (r == true) {
      var favorite = [];
      var faculty = document.getElementById("faculty").value;
      var t_start = document.getElementById("t_start").value;
      var t_end = document.getElementById("t_end").value;
      var acad_id = document.getElementById("acad_id").value;
      var subject = document.getElementById("subject").value;
      var room = document.getElementById("room").value;
      $.each($("input[name='day']:checked"), function(){
          favorite.push($(this).val());
      });
        $.ajax({
          type: 'POST',
          url: 'includes/add_sched.inc.php',
          data: { day: favorite, faculty: faculty, t_start: t_start, t_end: t_end, acad_id: acad_id, subject: subject, room: room },
          async: false,
          success:function(html){
            $('#add_sched_status').html(html);
          }
        });

    }
  }
</script>
<script type="text/javascript">
   $(document).ready(function(){
     $('#cur_num').on('change',function(){
       var curriculum_num = $(this).val();
       if(curriculum_num){
         $.ajax({
           type: 'POST',
           url: 'includes/load_sched.inc.php',
           data: 'curriculum_num=' + curriculum_num,
           success:function(html){
             $('#sched_table').html(html);
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
      <a class="nav-link text-danger" href="home_admin.php">Attendance</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="schedule_admin.php">Schedule</a>
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
  </ul>
  <div class="row animated fadeIn faster">
    <div class="col-md-3"><br>
      <h3 align="center">Add School Year/Semester</h3><br>
      <div class="row">
        <div class="col-md-12">School Year
          <input type="text" class="form-control" placeholder="2018-2019" name="sy" id="sy">
        </div>
      </div><br>
      <div class="row">
        <div class="col-md-12">Semester
          <input type="text" class="form-control" placeholder="1st Semester" name="sem" id="sem">
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-outline-danger waves-effect" onClick="add_sy()">Add</button>
        </div>
      </div>
      <div name="add_sy_status" id="add_sy_status"><br><br></div>
      <hr>
      <h3 align="center">Add Subjects</h3><br>
      <div class="row">
        <div class="col-md-12">Subject
          <form action="includes/add_subj.inc.php" method="POST" onsubmit="return confirm(&quot Are you sure you want to add subject?&quot);">
          <input type="text" class="form-control" placeholder="ICT01" name="subj" id="subj">
        </div>
      </div><br>
      <br>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-outline-danger waves-effect">Add</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-9"><br><br><br><br><br><br>
      <h2 align="center">Add Schedule</h2><br>
      <div class="form-row mb-4">
          <div class="col">
            Faculty Name
            <select class="form-control" name="faculty" id="faculty">
              <option selected disabled>Select Faculty</option>
               <?php
               $sql = "SELECT * FROM faculty
                       ;";
                 $result = mysqli_query($conn, $sql);
               while($row = mysqli_fetch_assoc($result)) {
                 $fid = $row['faculty_id'];
                 $fn = $row['first_name'];
                 $ln = $row['last_name'];
                 $email = $row['email_add'];
                 echo '
                 <option value="'.$fid.'">'.$fn.' '.$ln.'</option>
                 ';
               }
               ?>
             </select>
          </div>
          <div class="col">
              Time Start
              <input type="time" class="form-control" name="t_start" id="t_start">
          </div>
          <div class="col">
              Time End
              <input type="time" class="form-control" name="t_end" id="t_end">
          </div>
      </div>
      <div class="form-row mb-4">
          <div class="col">
            School Year/Semester
            <select class="form-control" name="acad_id" id="acad_id">
              <option selected disabled>Select School Year/Semester</option>
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
          </div>
          <div class="col">
              Subject
              <select class="form-control" name="subject" id="subject">
                <option selected disabled>Select Subject</option>
                <?php
                $sql = "SELECT * FROM subjects
                        ;";
                  $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                  $subj = $row['subject'];
                  echo '
                  <option value="'.$subj.'">'.$subj.'</option>
                  ';
                }
                ?>
              </select>
          </div>
          <div class="col">
              Room
              <input type="text" class="form-control" name="room" id="room" placeholder="Room">
          </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;M&quot;" name="day" id="M">
            <label class="custom-control-label" for="M">Monday</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;T&quot;" name="day" id="T">
            <label class="custom-control-label" for="T">Tuesday</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;W&quot;" name="day" id="W">
            <label class="custom-control-label" for="W">Wednesday</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;TH&quot;" name="day" id="TH">
            <label class="custom-control-label" for="TH">Thursday</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;F&quot;" name="day" id="F">
            <label class="custom-control-label" for="F">Friday</label>
          </div>
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" value="&quot;S&quot;" name="day" id="S">
            <label class="custom-control-label" for="S">Saturday</label>
          </div>
        </div>
      </div>
      <div align="center">
        <button type="button" class="btn btn-outline-danger waves-effect" onClick="add_sched();">Add</button><br>
      </div>
      <div name="add_sched_status" id="add_sched_status"></div>
    </div>
  </div>
  <H1 align="center">Schedule Table</h1>
  <div class="col-md-12"><br>
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
      if ($_GET['success'] == 'delsched'){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>Schedule has been <strong>deleted</strong>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
      }
    }
    ?>
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
    <div name="sched_table" id="sched_table"></div><br><br>
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
