<?php
class connection{
  private $database_name;
  private $sql_query;
  private $connection;
  function __construct($database_name){
    $this->database_name = $database_name;
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    if($this->connection){
      //echo "Database Connected<hr>";
      //echo "<script>msg('database connected', 'green')</script>";
    }
    else{
      echo "<script>msg('Opps! Database not connected', 'red')</script>";
      exit("<meta name='viewport' content='width=device-width, initial-scale=1.0'><meta name='theme-color' content='#00034f'/>
      <div style='position:fixed; top:0px; padding-top:0px; width:100%; height:100%; background:whitesmoke; text-align:center; margin-left:-8px; font-family:arial;'><div style='font-size: large; background:darkblue; color: white; font-weight:bold; padding: 17px 0px 17px 0px'>
      My Open Diary</div><center><img src='not_connected.png' width='150px'></center>
      <div style='padding:10px;'><h2>Unable to connect database</h2>We are sorry. The system could not be connected with the database this time. Please reload this page or try again later.
      <br>
      </div></div>");
    }
  }
  public function sql($query){
    $this->sql_query = $query;
  }
  public function getSql(){
    return $this->sql_query;
  }
  public function query_run(){
    $q = pg_query($this->connection, $this->getSql())or die("<script>msg('Opps! Something wrong','red')</script>");
    return $q;
  }
  public function close(){
    pg_close($this->connection);
  }


  function getTotalStory(){
    $this->sql("SELECT count(id) from diary");
    $run = $this->query_run();
    $row = pg_fetch_array($run);
    return $row[0];
  }

  function getTotalPrivateStory(){
    $this->sql("SELECT count(id) from diary where status='Private'");
    $run = $this->query_run();
    $row = pg_fetch_array($run);
    return $row[0];
  }

  function getTotalPublicStory(){
    $this->sql("SELECT count(id) from diary where status='Public'");
    $run = $this->query_run();
    $row = pg_fetch_array($run);
    return $row[0];
  }

  function getTotalUser(){
    $this->sql("SELECT count(email) from profile");
    $run = $this->query_run();
    $row = pg_fetch_array($run);
    return $row[0];
  }
}

?>
