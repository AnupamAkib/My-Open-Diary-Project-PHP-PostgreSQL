<?php
if(isset($_GET['logout'])){
  adminLogout();
}
if(isset($_SESSION['admin_logout'])){
  unset($_SESSION['admin_logout']);
  echo "<script>msg('You have been logged out', 'red')</script>";
}
function login_required(){
  if(!isset($_SESSION['admin_logged_in'])){
    //header('Location: login.php');
    echo "<script>window.location.href='login.php'</script>";
  }
}

if(isset($_SESSION['admin_logged_in_first'])){
  unset($_SESSION['admin_logged_in_first']);
  echo "<script>msg('Login Successful', 'green')</script>";
}
function adminLogout(){
  unset($_SESSION['admin_logged_in']);
  unset($_SESSION['admin_email']);
  $_SESSION['admin_logout'] = true;
  //header('Location: login.php');
  echo "<script>window.location.href='login.php'</script>";
}
 ?>
