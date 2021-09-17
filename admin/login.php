<?php
include 'header.php';
include 'db.php';
include 'admin.php';
include 'check_login.php';

if(isset($_SESSION['admin_logged_in'])){
  echo "<script>window.location.href='/admin/'</script>";
}
if(isset($_SESSION['incorrect_login_info'])){
  unset($_SESSION['incorrect_login_info']);
  echo "<script>msg('Incorrect login information', 'red')</script>";
}
unset($_SESSION['view_as_admin']);
 ?>
<div class="post_container" style="background:#f0f0f0">
 <div class="admin_login_panel_container">
   <h1>Admin Panel</h1><br>
   <form class="" action="" method="post" autocomplete="off">
     <input list="ad_email" class='admin_login_textbox' type="email" name="email" value="<?php if(isset($_SESSION['temp_login_email'])){echo $_SESSION['temp_login_email'];} ?>" placeholder="Admin Email" required><br>
     <input class='admin_login_textbox' type="password" name="password" value="" placeholder="Password" required><br>
     <input type="submit" name="submit" value="LOGIN" class="btn btn-primary btn-lg" id='target_btn'>
     <datalist id="ad_email">
       <option value="mirakib25@gmail.com">
       <option value="anupam35-2640@diu.edu.bd">
     </datalist>
   </form>
 </div>
</div>

<?php
if(isset($_POST['submit'])){
  echo "<script> disable_btn('target_btn') </script>";
  $email = nl2br(htmlentities($_POST['email']));
  $pass = nl2br(htmlentities($_POST['password']));
  $admn = new admin($email);
  if($admn -> isAdminFound()){
    if($admn -> getPassword() == $pass){
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_logged_in_first'] = true;
      $_SESSION['admin_email'] = $admn->getAdminEmail();
      $_SESSION['admin_picture'] = $admn->getPicture();
      echo "<script>window.location.href='/admin/'</script>";
    }
    else{
      $_SESSION['incorrect_login_info'] = true;
      $_SESSION['temp_login_email'] = $_POST['email'];
      echo "<script>window.location.href='login.php'</script>";
    }
  }
  else{
    $_SESSION['incorrect_login_info'] = true;
    $_SESSION['temp_login_email'] = $_POST['email'];
    echo "<script>window.location.href='login.php'</script>";
  }
}
 ?>
