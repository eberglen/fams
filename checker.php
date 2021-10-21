<?php
session_start();
if (isset($_SESSION['position'])){
  if ($_SESSION['position'] == 'Checker'){


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
  <nav class="mb-1 navbar navbar-expand-lg navbar-dark danger-color-dark">
    <a class="navbar-brand" href="checker.php"><img src="includes/FAMS128.png" height="30" class="d-inline-block align-top"
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
  <h1 align="center"><span class="text-success"><i class="fas fa-check">Present</i></span> <span class="text-warning"><i class="far fa-clock">Late</i></span> <span class="text-danger"><i class="fas fa-times">Absent</i></h1></span>
  <?php
  date_default_timezone_set("Asia/Hong_Kong");
  $date_today = date("M d, Y");
  $day = date("l");

  switch ($day) {
      case "Monday":
          $day = 'M';
          break;
      case "Tuesday":
          $day = 'T';
          break;
      case "Wednesday":
          $day = 'W';
          break;
      case "Thursday":
          $day = 'TH';
          break;
      case "Friday":
          $day = 'F';
          break;
      case "Saturday":
          $day = 'S';
          break;
      default:
          echo "ERROR";
  }
  $sql = "SELECT MAX(acad_yr_id) as max
          FROM acad_yr
          ;";
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)) {
    $max = $row['max'];
  }
  $sql = "SELECT first_name, last_name, TIME_FORMAT(t_start, '%h:%i %p') as t_start, TIME_FORMAT(t_end, '%h:%i %p') as t_end, subject, room, GROUP_CONCAT(day) as day, room, schedule.schedule_id as schedule_id
          FROM schedule, faculty, schedule_days
          WHERE schedule.faculty_id = faculty.faculty_id
          AND schedule.schedule_id = schedule_days.schedule_id
          AND acad_yr_id = $max
          AND day = '$day'
          GROUP BY t_start
          ;";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) > 0){
    echo '
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Schedules</th>
    ';
    while($row = mysqli_fetch_assoc($result)) {
      $t_start = $row['t_start'];
      echo '
      <th scope="col">'.$t_start.'</th>
      ';



    }
    echo '
    </tr>
  </thead>
  </table>
  </div>
    ';
  }

  if(isset($_GET['error'])){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning! </strong> SQL error.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  }
  else if(isset($_GET['success'])){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> Records updated successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
  }

  $timetoday = date("H:i:s");
  $sql = "SELECT first_name, last_name, TIME_FORMAT(t_start, '%h:%i %p') as t_start, TIME_FORMAT(t_end, '%h:%i %p') as t_end, subject, room, GROUP_CONCAT(day) as day, room, schedule.schedule_id as schedule_id
          FROM schedule, faculty, schedule_days
          WHERE schedule.faculty_id = faculty.faculty_id
          AND schedule.schedule_id = schedule_days.schedule_id
          AND acad_yr_id = $max
          AND day = '$day'
          AND t_start <= '$timetoday'
          AND t_end >= '$timetoday'
          GROUP BY schedule.schedule_id
          ORDER BY room
          ;";
  $result = mysqli_query($conn, $sql);
  echo '
  <div class="row animated fadeIn faster">
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Schedule</th>
            <th scope="col">Date</th>
            <th scope="col">Subject</th>
            <th scope="col">Room</th>
            <th scope="col" colspan="3">Remarks</th>
          </tr>
        </thead>
        <tbody>
  ';
  while($row = mysqli_fetch_assoc($result)) {
    $fn = $row['first_name'];
    $ln = $row['last_name'];
    $start = $row['t_start'];
    $end = $row['t_end'];
    $subject = $row['subject'];
    $room = $row['room'];
    $day = $row['day'];
    $sid = $row['schedule_id'];

    echo '
    <tr>
      <th scope="row">'.$ln.'</th>
      <td>'.$fn.'</td>
      <td>'.$start.'-'.$end.' ('.$day.')</td>
      <td>'.$date_today.'</td>
      <td>'.$subject.'</td>
      <td>'.$room.'</td>
      ';
      $sql2 = " SELECT remarks
                FROM attendance
                WHERE schedule_id = $sid
                AND recorded = '$date_today'
              ;";
      $result2 = mysqli_query($conn, $sql2);
      if (mysqli_num_rows($result2) > 0) {
        while($row2 = mysqli_fetch_assoc($result2)){
          $remarks = $row2['remarks'];
          switch ($remarks) {
              case "Present":
                  echo '<td colspan="3"><p class="text-success">Present</p></td>';
                  break;
              case "Late":
                  echo '<td colspan="3"><p class="text-warning">Late</p></td>';
                  break;
              case "Absent":
                  echo '<td colspan="3"><p class="text-danger">Absent</p></td>';
                  break;
              default:
                  echo '<td colspan="3"><p class="text-primary">Leave</p></td>';
          }
        }
      }
      else{
        echo '
        <td>
        <form action="includes/remarks.inc.php" method="POST" onsubmit="return confirm(&quot Faculty is present?&quot);">
          <input type="hidden" name="schedule_id" value="'.$sid.'">
          <input type="hidden" name="remarks" value="Present">
          <button type="submit" name="submit" class="btn btn-success px-3 waves-effect waves-light btn-sm"><i class="fas fa-check"></i></button>
        </form>
        </td>
        <td>
        <form action="includes/remarks.inc.php" method="POST" onsubmit="return confirm(&quot Faculty is late?&quot);">
          <input type="hidden" name="schedule_id" value="'.$sid.'">
          <input type="hidden" name="remarks" value="Late">
          <button type="submit" name="submit" class="btn btn-warning px-3 waves-effect waves-light btn-sm"><i class="far fa-clock"></i></button>
        </form>
        </td>
        <td>
        <form action="includes/remarks.inc.php" method="POST" onsubmit="return confirm(&quot Faculty is absent?&quot);">
          <input type="hidden" name="schedule_id" value="'.$sid.'">
          <input type="hidden" name="remarks" value="Absent">
          <button type="submit" name="submit" class="btn btn-danger px-3 waves-effect waves-light btn-sm"><i class="fas fa-times"></i></button>
        </form>
        </td>

        ';
      }

    echo'
    </tr>
    ';


  }
  echo '
  </tbody>
</table>
</div>

</div>
</div>
  ';
  ?>
</div>
</body>
</html>
<?php
}
else if ($_SESSION['position'] == 'Admin'){
  header("Location:./home_admin.php");
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
