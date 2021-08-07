<?php
include 'header.php';
if(isset($_SESSION['logged_in'])==false){
  $_SESSION['login_first'] = true;
  echo "<script>window.location.href='enter.php?action=login'</script>";
}
else{
 ?>

 <center>
   <div class="container">
     <h1>Your Profile</h1>
     <p>This is your profile. Edit your information, change your profile picture and do other changes when you need. You profile picture and name will be visible publicly.</p>
     <br>
   </div>
    <div class="action_btn_container">
      <button id='first_btn' type="button" onclick="window.location.href='profile.php?action=edit+profile'" class='action_button' style="float: left;"><i class='fa fa-pencil'></i> Edit Profile</button>
      <button id='second_btn' type="button" onclick="window.location.href='profile.php?action=change+password'" class='action_button' style='float: right'><i class='fa fa-key'></i> Change Password</button>
      <br><br><br><br>
    </div>
</center>

 <!--
 <button type="button" name="" onclick="window.location.href='profile.php?action=edit+profile'">Edit Profile</button>
 <button type="button" name="" onclick="window.location.href='profile.php?action=change+password'">Change Password</button>
-->
<?php
  if(isset($_GET['action']) && $_GET['action']=='edit profile'){
    echo "<script>active_btn_effect('first')</script>";
  }
  else if(isset($_GET['action']) && $_GET['action']=='change password'){
    echo "<script>active_btn_effect('second')</script>";
  }
  //echo $_GET['action'];
  //unset($_SESSION['logged_in']);
  if(isset($_GET['action'])){
    $act = $_GET['action'];
    if($act == 'edit profile'){
      include 'update_profile_info.php';
    }
    elseif ($act == 'change password') {
      include 'change_pass.php';
    }
    else{
      echo "<script>msg('404 Not found!', 'red')</script>";
    }
  }
}
 ?>
<?php include 'footer.php' ?>
