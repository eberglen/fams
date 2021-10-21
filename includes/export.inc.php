<?php
if (!empty($_POST['date'])){
  include 'dbconn.inc.php';
  $date = $_POST['date'];
  $year_today = date("Y");
  $year_last = date("Y",strtotime("-1 year"));
  switch ($date) {
    case "1":
        $s_date = $year_last.'-12-26';
        $e_date = $year_today.'-01-10';
        break;
    case "2":
        $s_date = $year_today.'-01-11';
        $e_date = $year_today.'-01-25';
        break;
    case "3":
        $s_date = $year_today.'-01-26';
        $e_date = $year_today.'-02-10';
        break;
    case "4":
        $s_date = $year_today.'-02-11';
        $e_date = $year_today.'-02-25';
        break;

    case "5":
        $s_date = $year_today.'-02-26';
        $e_date = $year_today.'-03-10';
        break;

    case "6":
        $s_date = $year_today.'-03-11';
        $e_date = $year_today.'-03-25';
        break;

    case "7":
        $s_date = $year_today.'-03-26';
        $e_date = $year_today.'-04-10';
        break;

    case "8":
        $s_date = $year_today.'-04-11';
        $e_date = $year_today.'-04-25';
        break;

    case "9":
        $s_date = $year_today.'-04-26';
        $e_date = $year_today.'-05-10';
        break;

    case "10":
        $s_date = $year_today.'-05-11';
        $e_date = $year_today.'-05-25';
        break;

    case "11":
        $s_date = $year_today.'-05-26';
        $e_date = $year_today.'-06-10';
        break;

    case "12":
        $s_date = $year_today.'-06-11';
        $e_date = $year_today.'-06-25';
        break;

    case "13":
        $s_date = $year_today.'-06-26';
        $e_date = $year_today.'-07-10';
        break;

    case "14":
        $s_date = $year_today.'-07-11';
        $e_date = $year_today.'-07-25';
        break;

    case "15":
        $s_date = $year_today.'-07-26';
        $e_date = $year_today.'-08-10';
        break;

    case "16":
        $s_date = $year_today.'-08-11';
        $e_date = $year_today.'-08-25';
        break;

    case "17":
        $s_date = $year_today.'-08-26';
        $e_date = $year_today.'-09-10';
        break;

    case "18":
        $s_date = $year_today.'-09-11';
        $e_date = $year_today.'-09-25';
        break;

    case "19":
        $s_date = $year_today.'-09-26';
        $e_date = $year_today.'-10-10';
        break;

    case "20":
        $s_date = $year_today.'-10-11';
        $e_date = $year_today.'-10-25';
        break;
    case "21":
        $s_date = $year_today.'-10-26';
        $e_date = $year_today.'-11-10';
        break;

    case "22":
        $s_date = $year_today.'-11-11';
        $e_date = $year_today.'-11-25';
        break;

    case "23":
        $s_date = $year_today.'-11-26';
        $e_date = $year_today.'-12-10';
        break;

    case "24":
        $s_date = $year_today.'-12-11';
        $e_date = $year_today.'-12-25';
        break;


    default:
        echo "Error";
}

  $s = date("M d,Y", strtotime($s_date));
  $e = date("M d,Y", strtotime($e_date));

  echo '
  <div class="row">
    <div class="col-md-12"><br>
    <div class="table-responsive">
      <table class="table table-bordered" id="exportTable" name="exportTable">
        <thead>
          <tr>
            <th colspan="6">Attendance Report ('.$s.' - '.$e.')</th>
          </tr>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Present</th>
            <th scope="col">Late</th>
            <th scope="col">Absent</th>
            <th scope="col">Leave</th>
          </tr>
        </thead>
        <tbody>
  ';

  $sql = "SELECT *
          FROM faculty
          ;";
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)) {
    $fid = $row['faculty_id'];
    $fn = $row['first_name'];
    $ln = $row['last_name'];
    $sql2 = "SELECT count(*) as present
             FROM attendance, schedule, faculty
             WHERE attendance.schedule_id = schedule.schedule_id
             AND schedule.faculty_id = faculty.faculty_id
             AND faculty.faculty_id = $fid
             AND remarks = 'Present'
             AND recorded >= '$s_date'
             AND recorded <= '$e_date'
            ;";
    $result2 = mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
      $present = $row2['present'];
    }
    $sql2 = "SELECT count(*) as late
             FROM attendance, schedule, faculty
             WHERE attendance.schedule_id = schedule.schedule_id
             AND schedule.faculty_id = faculty.faculty_id
             AND faculty.faculty_id = $fid
             AND remarks = 'Late'
             AND recorded >= '$s_date'
             AND recorded <= '$e_date'
            ;";
    $result2 = mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
      $late = $row2['late'];
    }
    $sql2 = "SELECT count(*) as absent
             FROM attendance, schedule, faculty
             WHERE attendance.schedule_id = schedule.schedule_id
             AND schedule.faculty_id = faculty.faculty_id
             AND faculty.faculty_id = $fid
             AND remarks = 'Absent'
             AND recorded >= '$s_date'
             AND recorded <= '$e_date'
            ;";
    $result2 = mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
      $absent = $row2['absent'];
    }
    $sql2 = "SELECT count(*) as leaves
             FROM attendance, schedule, faculty
             WHERE attendance.schedule_id = schedule.schedule_id
             AND schedule.faculty_id = faculty.faculty_id
             AND faculty.faculty_id = $fid
             AND remarks = 'Leave'
             AND recorded >= '$s_date'
             AND recorded <= '$e_date'
            ;";
    $result2 = mysqli_query($conn, $sql2);
    while($row2 = mysqli_fetch_assoc($result2)) {
      $leave = $row2['leaves'];
    }
    echo '
    <tr>
      <td>'.$ln.'</td>
      <td>'.$fn.'</td>
      <td>'.$present.'</td>
      <td>'.$late.'</td>
      <td>'.$absent.'</td>
      <td>'.$leave.'</td>
    </tr>
    ';
  }
  echo '
  </tbody>
</table>
</div>
<button class="btn btn-info" id="btnExport" onclick="fnExcelReport();"><i class="fas fa-file-export">Export</i></button>
</div>
</div>
  ';
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
