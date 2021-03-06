<?php
  //include 'header.php';
  if(isset($_SESSION['logged_in'])==false){
    $_SESSION['login_first'] = true;
    echo "<script>window.location.href='enter.php?action=login'</script>";
  }
  //echo $_SESSION['user_pp'];
 ?>
<title>Change Password | <?php echo $first_name ?></title>
 <div class="post_container">
   <center>
     <div class='profile_pic' style="background-image: url('uploads/<?php echo $_SESSION['user_pp'] ?>'); background-size: 200px; background-repeat: no-repeat;"></div>
     <h1><?php echo nl2br(htmlentities($_SESSION['user_name'])) ?></h1>
   </center>
   <form action="" method="POST">
     <label for="">Current Password:</label><br>
     <input type="password" name="old_pass" value="" placeholder="Current Password" class='input_field' required>
     <label for="">New Password:</label><br>
     <input type="password" name="new_pass" value="" placeholder="New Password" class='input_field' required>
     <label for="">Re-enter New Password:</label><br>
     <input type="password" name="new_pass_again" value="" placeholder="Re-write the password" class='input_field' required>
     <input type="submit" name="change_password_btn" value="CHANGE PASSWORD" class='my_button' id='target_btn'>
   </form>
 </div>
<?php
if(isset($_POST['change_password_btn'])){
  $cur_pass = $_POST['old_pass'];
  $new_pass = $_POST['new_pass'];
  $new_pass_again = $_POST['new_pass_again'];
  $now_pass = $_SESSION['user_password'];
  $user_email = $_SESSION['email'];

  if($cur_pass == $now_pass){
    if($new_pass == $new_pass_again){
      //change
      if(check_password($new_pass)){
        $query = "update profile set pass=$1 where email=$2";
        $query_run = pg_prepare($connection, "", $query);
        $query_run = pg_execute($connection, "", array($new_pass, $user_email))or die("<script>msg('Opps! Something wrong','red')</script>");
        $_SESSION['user_password'] = $new_pass;
        echo "<script>msg('Password changed successfully', 'green')</script>";
        $act = new activity($_SESSION['email']);
        $act->setActivity("User changed password");
      }
    }
    else{
      echo "<script>msg('Password did not match', 'red')</script>";
    }
  }
  else{
    echo "<script>msg('Please enter correct password','red')</script>";
  }
}
 ?>
