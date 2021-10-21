<?php
session_start();
if (isset($_SESSION['position'])){
  if ($_SESSION['position'] == 'Dean'){
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
    function fac_rec(){
        var s_date = document.getElementById("s_dates").value;
        var e_date = document.getElementById("e_dates").value;
        var faculty = document.getElementById("faculty").value;
          $.ajax({
            type: 'POST',
            url: 'includes/export_fac.inc.php',
            data: { s_date: s_date, e_date: e_date, faculty: faculty },
            success:function(html){
              $('#faculty_table').html(html);
            }
          });
    }
  </script>
  <script type="text/javascript">
    function att_rec(){
        var s_date = document.getElementById("s_date").value;
        var e_date = document.getElementById("e_date").value;
          $.ajax({
            type: 'POST',
            url: 'includes/export.inc.php',
            data: { s_date: s_date, e_date: e_date },
            success:function(html){
              $('#attendance_table').html(html);
            }
          });
    }
  </script>
  <script>
  function fnExcelReport()
{
  var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
  var textRange; var j=0;
  tab = document.getElementById('exportTable'); // id of table

  for(j = 0 ; j < tab.rows.length ; j++)
  {
      tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
      //tab_text=tab_text+"</tr>";
  }

  tab_text=tab_text+"</table>";
  tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
  tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
  tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");

  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
  {
      txtArea1.document.open("txt/html","replace");
      txtArea1.document.write(tab_text);
      txtArea1.document.close();
      txtArea1.focus();
      sa=txtArea1.document.execCommand("SaveAs",true,"attendance report.xlsx");
  }
  else                 //other browser not tested on IE 11
      sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

  return (sa);
}
  </script>
  <script>
  function fnfacRec()
{
  var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
  var textRange; var j=0;
  tab = document.getElementById('facRectable'); // id of table

  for(j = 0 ; j < tab.rows.length ; j++)
  {
      tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
      //tab_text=tab_text+"</tr>";
  }

  tab_text=tab_text+"</table>";
  tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
  tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
  tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

  var ua = window.navigator.userAgent;
  var msie = ua.indexOf("MSIE ");

  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
  {
      txtArea2.document.open("txt/html","replace");
      txtArea2.document.write(tab_text);
      txtArea2.document.close();
      txtArea2.focus();
      sa=txtArea2.document.execCommand("SaveAs",true,"faculty report.xlsx");
  }
  else                 //other browser not tested on IE 11
      sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

  return (sa);
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
  <H1 align="center">Attendance Record</h1>

  <div class="row">
    <div class="col-md-3">Date
      <select class="form-control" name="date" id="date">
        <option selected disabled>Select Date</option>
        <option value="">January 10 - February 25</option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
        <option value=""></option>
      </select>
    </div>
    <div class="col-md-3"><br>
      <button type="submit" class="btn btn-block btn-outline-danger waves-effect btn-sm" onClick="att_rec()">Show</button>
    </div>
  </div>
  <div name="attendance_table" id="attendance_table"></div><br><br>
  <!--<hr>
  <H1 align="center">Faculty Record</h1>

  <div class="row">
    <div class="col-md-3">Start Date
      <input type="date" class="form-control" name="s_dates" id="s_dates">
    </div>
    <div class="col-md-3">End Date
      <input type="date" class="form-control" name="e_dates" id="e_dates">
    </div>
    <div class="col-md-3"><br>
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
    <div class="col-md-3"><br>
      <button type="submit" class="btn btn-block btn-outline-danger waves-effect btn-sm" onClick="fac_rec()">Show</button>
    </div>
  </div>-->
  <div name="faculty_table" id="faculty_table"></div><br><br>
  <iframe id="txtArea1" style="display:none"></iframe>
  <iframe id="txtArea2" style="display:none"></iframe>
</body>
</html>
<?php
}
else if ($_SESSION['position'] == 'Checker'){
  header("Location:./checker.php");
  exit();
}
else if ($_SESSION['position'] == 'Admin'){
  header("Location:./home_admin.php");
  exit();
}
}
else{
header("Location:./index.php");
exit();
}

 ?>
