<?php
class activity{
  private $email, $activity_text, $time_now;
  function __construct($email){
    $this->email = $email;
    $this->time_now = date("M d, Y | h:i A");
  }
  function getEmail(){
    return $this -> email;
  }
  function getActivity(){
    return $this -> activity_text;
  }
  function getTime(){
    return $this -> time_now;
  }
  function setActivity($actvt){
    $setting = settings::getInstance();
    if($setting->getTakingUserActivity()){
      $this->activity_text = $actvt;
      include('admin/database_login.php');
      $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
      $mx = "SELECT MAX(id) from user_activity";
      $q = pg_query($connection, $mx);
      $r = pg_fetch_array($q);
      $id = $r[0]+1;
      $em = $this -> getEmail();
      $act = $this -> getActivity();
      $tm = $this -> getTime();
      //echo $id;
      $sql = "INSERT into user_activity VALUES($1, $2, $3, $4);";
      $query_run = pg_prepare($connection, "", $sql);
      $query_run = pg_execute($connection, "", array($em, $act, $tm, $id))or die("<script>msg('Opps! Something wrong','red')</script>");
    }
  }
  function viewActivity(){
    include('database_login.php');
    $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this -> getEmail();
    $sql = "SELECT * FROM user_activity where email=$1 order by id DESC";
    $q = pg_prepare($connection, "", $sql);
    $q = pg_execute($connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");

    if(pg_num_rows($q)){
      ?>
      <font size='6'>All user activity of <b><?php echo $this->getEmail() ?></b></font><br>
      <button type="button" name="button" class='btn btn-danger' data-target="#myModal" data-toggle="modal">Clear Activity</button>
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Clear Activity</h4>
            </div>
            <div class="modal-body">
              <h3>Are you sure you want to clear all activity of <b><?php echo $this->getEmail() ?></b>?</h3>
              <form class="" method="post">
                <input type="submit" name="clear_activity" value="CLEAR" class='btn btn-danger'>
              </form>
              <?php
              if(isset($_POST['clear_activity'])){
                $_em = $this->getEmail();
                $sql = "DELETE from user_activity where email=$1";
                $r = pg_prepare($connection, "", $sql);
                $r = pg_execute($connection, "", array($_em))or die("<script>msg('Opps! Something wrong','red')</script>");
                $_SESSION['clear_user_activity'] = true;
                echo "<script>window.location.href='/admin/user_activity.php'</script>";
              }
               ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>

      <br><br>
      <div class="table-responsive fixed-table-body">
      <table class='table table-hover'>
        <tr>
          <th>Time & Date</th>
          <th>Activity</th>
        </tr>
      <?php
      while($row = pg_fetch_array($q)){
        ?>
        <tr>
          <td width="25%"><?php echo $row['time_now'] ?></td>
          <td><?php echo "<b>".$row['activity']."</b>" ?></td>
        </tr>
        <?php
      }
      ?>
    </table></div>
      <?php
    }
    else{
      echo "<center><h1 style='color:red'>No activity found</h1></center>";
    }
  }
}
 ?>
