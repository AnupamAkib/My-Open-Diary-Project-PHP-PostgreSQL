<?php
include 'header.php';
include 'check_login.php';
include 'user.php';
login_required();

unset($_SESSION['logged_in']);
unset($_SESSION['email']);
unset($_SESSION['view_as_admin']);

if(isset($_SESSION['admin_added_successful'])){
  echo "<script>msg('Admin Added', 'green')</script>";
  unset($_SESSION['admin_added_successful']);
}
if(isset($_SESSION['admin_removed_successful'])){
  echo "<script>msg('Admin Removed', 'green')</script>";
  unset($_SESSION['admin_removed_successful']);
}
 ?>
 <div class="container">
<font size="6">Admins</font>
<button type="button" name="button" class='btn btn-success btn-lg' data-target="#myModal" data-toggle="modal" style='float:right'>Add Admin</button>

<table class='table table-hover' style='font-size:large'>
  <tr>
    <th>Admin Name</th>
    <th>Role</th>
    <th>Action</th>
  </tr>
  <?php
  include('database_login.php');
  $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
  $sql = "SELECT email from admin";
  $query_run = pg_query($connection, $sql);
  $cnt=0;
  while($row = pg_fetch_array($query_run)){
    $admn = new admin($row['email']);
    $admin_pic = $admn->getPicture();
    $tmp = $admn->getPicture();
    $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
    if(file_exists($tmp)){
      $admin_pic = $admn->getPicture();
    }
    else{
      $admin_pic = "default_picture.jpg";
    }
    ?>
    <tr>
      <td>
        <div>
          <div style="margin-right:7px;background-image: url('/uploads/<?php echo $admin_pic ?>'); background-size: 25px;background-repeat: no-repeat;width: 25px;height: 25px;border-radius: 50%;float:left;background-color: #d0d0d0;"></div>
          <a href="search_user.php?email=<?php echo $admn->getAdminEmail() ?>"><?php echo $admn->getAdminName() ?></a>
        </div>
      </td>
      <td>
        <?php echo $admn->getRole() ?>
      </td>
      <td>

        <form class="" action="" method="post">
          <input type="submit" id="target_btn_<?php echo $cnt ?>" name="remove_admin<?php echo $cnt ?>" class='btn btn-primary' value='Remove' <?php if($admn->getRole()=="Super Admin"){echo "disabled";} ?>>
        </form>

        <?php
        $tmp = 'remove_admin'.$cnt;
        if(isset($_POST[$tmp])){
          echo "<script> disable_btn('target_btn_$cnt') </script>";
          $admn->remove();
          $_SESSION['admin_removed_successful'] = true;
          echo "<script>window.location.href='administration.php'</script>";
        }
         ?>
      </td>
    </tr>
    <?php
    $cnt++;
  }
   ?>
</table>
 </div>


<!-- Modal for Add Admins -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Admin</h4>
      </div>
      <div class="modal-body">
        <p>Enter an email address: <b>(Email must be an user first)</b></p>
        <form class="" action="" method="post">
        <input type="email" name="email" value="" class='form-control' placeholder="Enter Email" required><br>
        <input type="submit" name="add_submit" value="ADD as Admin" class='btn btn-success'>
        </form>
        <?php
        if(isset($_POST['add_submit'])){
          $email = $_POST['email'];
          $usr = new user($email);
          if($usr->isExist() && $usr->getSuspension()==0){
            $admn = new admin($email);
            if($admn->isAdminFound()){
              //echo $admn->isAdminFound();
              //leo@gmail.com
              echo "<script>msg('This user is already admin', '')</script>";
              //echo "<script>msg(xdgxfg ".$admn->getAdminName().", '')</script>";
            }
            else{
              $admn -> add();
              $_SESSION['admin_added_successful'] = true;
              echo "<script>window.location.href='administration.php'</script>";
            }
          }
          else{
            echo "<script>msg('User not found', 'red')</script>";
          }
        }
         ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php include 'footer.php' ?>
