<?php
$title_name = "User Activity";
include 'header.php';
include 'check_login.php';
include 'user.php';
include 'activity.php';

login_required();

unset($_SESSION['logged_in']);
unset($_SESSION['email']);
unset($_SESSION['view_as_admin']);

if(isset($_SESSION['clear_user_activity'])){
  echo "<script>msg('Activities cleared of an user', 'green')</script>";
  unset($_SESSION['clear_user_activity']);
}
if(isset($_SESSION['clear_all_user_activity'])){
  echo "<script>msg('Activities cleared successfully', 'green')</script>";
  unset($_SESSION['clear_all_user_activity']);
}
?>
<div class="container">
<form class="" action="" method="get">
  <center>
    <div class="btn-group">
      <input list="all_email" class='btn btn-default' type="text" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" placeholder="Enter User Email" required/>
      <button type="submit" class='btn btn-primary'>View Activity</button>
      <datalist id="all_email">
        <?php
        include('database_login.php');
        $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
        $query = "SELECT email FROM profile order by email ASC";
        $query_run = pg_query($connection, $query);
        while($row = pg_fetch_array($query_run)){
          $eml = $row['email'];
          echo "<option value=$eml>";
        }
         ?>
      </datalist>
   </div>
</center>
</form>

<?php
if(isset($_GET['email'])){
  $act = new activity($_GET['email']);
  $act -> viewActivity();
}
else{
  include('database_login.php');
  $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
  $sql = "SELECT * from user_activity order by id DESC";
  $qr = pg_query($connection, $sql);
  $cnt=0;
  if(pg_num_rows($qr)){
    ?>
    <font size='6'>Last 25 user activity</font>
    <button type="button" name="button" class='btn btn-danger' style='float:right' data-target="#myModal" data-toggle="modal">Clear All Activity</button>

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Clear All Activity</h4>
          </div>
          <div class="modal-body">
            <h3>Are you sure you want to clear <b>all activity of all user</b>?</h3>
            <form class="" method="post">
              <input type="submit" name="clear_all_activity" value="CLEAR ALL" class='btn btn-danger' id='target_btn'>
            </form>
            <?php
            if(isset($_POST['clear_all_activity'])){
              echo "<script> disable_btn('target_btn') </script>";
              $sql = "DELETE from user_activity";
              $r = pg_query($connection, $sql);
              $_SESSION['clear_all_user_activity'] = true;
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
    while($row = pg_fetch_array($qr)){
      if($cnt==25) break;
      ?>
      <tr>
        <td width="25%"><?php echo $row['time_now'] ?></td>
        <td><?php echo "<b><a href=\"user_activity.php?email=".$row['email']."\">".$row['email']."</a> : ".$row['activity']."</a></b>" ?></td>
      </tr>
      <?php
      $cnt++;
    }
    ?>
  </table></div>
    <?php
  }
  else{
    echo "<center><h1 style='color:red'>No activity found</h1></center>";
  }
}
 ?>
</div>


<?php include "footer.php" ?>
