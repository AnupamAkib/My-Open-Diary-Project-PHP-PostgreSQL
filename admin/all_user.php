<h1 style='color:white'>All Users</h1>
<div class="table-responsive fixed-table-body" style='float:none'>
<table class='table table-hover' style='font-size:large'>
  <tr style='background:whitesmoke'>
    <th>Name of User</th><th>Email</th><th><center>Account Status</center></th>
    <?php if(isset($_SESSION['admin_email']) && $_SESSION['admin_email']=="mirakib25@gmail.com"){echo "<th><center>Delete Account</center></th>";} ?>
  </tr>
<?php
if(isset($_SESSION['user_deleted_success'])){
  echo "<script>msg('User deleted successfully', 'green')</script>";
  unset($_SESSION['user_deleted_success']);
}
include('database_login.php');
$connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
$sql = "SELECT * from profile order by name ASC";
$query_run = pg_query($connection, $sql);
$cnt=0;
while($row = pg_fetch_array($query_run)){
  $tmp = $row['picture'];
  $pic='';
  $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
  if(file_exists($tmp)){
    $pic = $row['picture'];
  }
  else{
    $pic = "default_picture.jpg";
  }
  ?>
  <tr>
    <td>
      <div>
        <div style="margin-right:7px;background-image: url('/uploads/<?php echo $pic ?>'); background-size: 25px;background-repeat: no-repeat;width: 25px;height: 25px;border-radius: 50%;float:left;background-color: #d0d0d0;"></div>
        <a href="/admin/search_user.php?email=<?php echo nl2br(htmlentities($row['email'])) ?>"><?php echo nl2br(htmlentities($row['name'])) ?></a>
      </div>
    </td>
    <td><?php echo nl2br(htmlentities($row['email'])) ?></td>
    <td align='center'><?php if($row['suspention']){echo "<font color='red'>Suspended</font>";}else{echo "<font color='green'>Active</font>";} ?></td>
    <?php
    if(isset($_SESSION['admin_email']) && $_SESSION['admin_email']=="mirakib25@gmail.com"){
      //view action button
      ?>
      <td align='center'>
        <button type="button" name="button" class="btn btn-default" data-target="#myModal_<?php echo $cnt ?>" data-toggle="modal" <?php if($row['email']=="mirakib25@gmail.com"){echo "disabled";} ?>>Delete</button>
      </td>
      <!-- Modal for delete user -->
      <div id="myModal_<?php echo $cnt ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Delete User</h4>
            </div>
            <div class="modal-body">
              <?php
               //echo $row['email']
               $del_em = $row['email'];
               $del_name = $row['name'];
               echo "Are you sure you want to delete all the data of <b>$del_em</b> including profile information, stories and adminship (if has)?<br>";
               echo "<font size='5'>User '<b>$del_name</b>' will be removed. Press 'Delete' to continue.</font>";
               ?>
               <form class="" method="post">
                 <input type="submit" name="delete_user_btn_<?php echo $cnt ?>" value="Delete" class='btn btn-danger' id='target_btn_<?php echo $cnt ?>'>
               </form>
               <?php
               if(isset($_POST['delete_user_btn_'.$cnt])){
                 echo "<script> disable_btn('target_btn_$cnt') </script>";
                 $sql = "DELETE from profile where email=$1";
                 $q = pg_prepare($connection, "", $sql);
                 $q = pg_execute($connection, "", array($del_em))or die("<script>msg('Opps! Something wrong','red')</script>");

                 $sql = "DELETE from diary where author_email=$1";
                 $q = pg_prepare($connection, "", $sql);
                 $q = pg_execute($connection, "", array($del_em))or die("<script>msg('Opps! Something wrong','red')</script>");

                 $sql = "DELETE from admin where email=$1";
                 $q = pg_prepare($connection, "", $sql);
                 $q = pg_execute($connection, "", array($del_em))or die("<script>msg('Opps! Something wrong','red')</script>");

                 $_SESSION['user_deleted_success'] = true;
                 echo "<script>window.location.href='/admin/'</script>";
               }
              ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
      <?php
      $cnt++;
    }
     ?>
  </tr>
  <?php
}

 ?>
</table>






</div>
