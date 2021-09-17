<?php
class notification{
  //singleton design pattern
  private $notice, $flag;
  private static $singleton_obj = null;

  private function __construct(){
    include "database_login.php";
    $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");

    $sql = "SELECT * from notification";
    $q = pg_query($connection, $sql);
    $row = pg_fetch_array($q);
    $this -> notice = $row[0];
    $this -> flag = $row[1];
  }

  public static function getInstance(){
    if(self::$singleton_obj == null){
      self::$singleton_obj = new notification();
    }
    return self::$singleton_obj;
  }

  public function getNotice(){
    return $this -> notice;
  }
  public function setNotice($notice){
    $this -> notice = $notice;
  }
  public function getNoticeFlag(){
    return $this -> flag;
  }
  public function setNoticeFlag($flag){
    $this -> flag = $flag;
  }

  public function update(){
    $conn_string = "host=ec2-18-235-45-217.compute-1.amazonaws.com port=5432 dbname=ddn865lov6362s user=jritwupgvioezj password=0e9c39cdd7df700da0e1536caf670ebfb8586f47b46ee8fcd300eed8b964580c";
    $connection = pg_connect($conn_string);

    $fg = $this -> getNoticeFlag();
    $note = nl2br($this -> getNotice());

    $sql = "UPDATE notification SET notics = $1, display = $2";
    $q = pg_prepare($connection, "", $sql);
    $q = pg_execute($connection, "", array($note, $fg))or die("<script>msg('Opps! Something wrong','red')</script>");
  }
}
 ?>
