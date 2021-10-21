<?php
class mysqlidbh{
  private $servername;
  private $username;
  private $password;
  private $database;

  public function connect(){
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->database = "fams";

    $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    return $conn;
  }
  public function sql_insert_update($query){
    //$conn = mysqli_connect("localhost", "root", "", "SCHEMAZ");
    $conn = $this->connect();
    $this->query = $query;
    $data = '';
    $result = mysqli_query($conn, $this->query);
    return $result;
  }
}
#$query = "SELECT COUNT(*) as 'count' from schedule;";
#$rowname = 'count';
$mysqlidb = new mysqlidbh;
$conn = $mysqlidb->connect();
 ?>
