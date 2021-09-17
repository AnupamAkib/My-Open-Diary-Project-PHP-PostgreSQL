<?php
class settings{
  //used singleton design pattern
  private $create_new_account;
  private $user_activity;
  private $protect_stories;
  private $display_total_views;

  private static $singleton_obj = null;

  private function __construct(){
    include('database_login.php');
    $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $sql = "SELECT * from setting";
    $query_run = pg_query($connection, $sql);
    $row = pg_fetch_array($query_run);
    $this -> create_new_account = $row['new_account_registration'];
    $this -> user_activity = $row['user_activity'];
    $this -> protect_stories = $row['protect_stories'];
    $this -> display_total_views = $row['display_total_views'];
  }

  public static function getInstance(){
    if(self::$singleton_obj == null){
      self::$singleton_obj = new settings();
    }
    return self::$singleton_obj;
  }

  function getRegistrationSetting(){
    return $this -> create_new_account;
  }
  function getTakingUserActivity(){
    return $this -> user_activity;
  }
  function getProtectStory(){
    return $this -> protect_stories;
  }
  function getDisplayTotalView(){
    return $this -> display_total_views;
  }


  function setRegistrationSetting($create_new_account){
    $this -> create_new_account = $create_new_account;
  }
  function setTakingUserActivity($user_activity){
    $this -> user_activity = $user_activity;
  }
  function setProtectStory($protect_stories){
    $this -> protect_stories = $protect_stories;
  }
  function setDisplayTotalView($display_total_views){
    $this -> display_total_views = $display_total_views;
  }

  function update(){
    $registration = $this -> create_new_account;
    $activity = $this -> user_activity;
    $protect = $this -> protect_stories;
    $views = $this -> display_total_views;
    include('database_login.php');
    $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $sql = "UPDATE setting SET new_account_registration=$registration, user_activity=$activity, protect_stories=$protect, display_total_views=$views";
    $query_run = pg_query($connection, $sql);
  }
}
 ?>
