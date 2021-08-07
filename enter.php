<?php
include 'header.php';
if(isset($_SESSION['logged_in'])){
  echo "<script>window.location.href='index.php'</script>";
}
 ?>
 <center>
   <div class="container">
     <h1>Open your diary</h1>
     <p>Login to open your diary. It is easy to create a new account if you have not opened your personal diary yet.</p>
     <br>
   </div>
    <div class="action_btn_container">
      <button id='first_btn' type="button" onclick="window.location.href='enter.php?action=login'" class='action_button' style="float: left;"><i class='fa fa-sign-in'></i> Log in</button>
      <button id='second_btn' type="button" onclick="window.location.href='enter.php?action=register'" class='action_button' style='float: right'><i class='fa fa-user-plus'></i> Create Account</button>
      <br><br><br><br>
    </div>
</center>

<?php
  if(isset($_GET['action']) && $_GET['action']=='login'){
    echo "<script>active_btn_effect('first')</script>";
  }
  else if(isset($_GET['action']) && $_GET['action']=='register'){
    echo "<script>active_btn_effect('second')</script>";
  }
  //echo $_GET['action'];
  //unset($_SESSION['logged_in']);
  if(isset($_GET['action'])){
    $act = $_GET['action'];
    if($act == 'login'){
      include 'login.php';
    }
    elseif ($act == 'register') {
      include 'register.php';
    }
    else{
      echo "<script>msg('404 Not found!', 'red')</script>";
    }
  }
 ?>
<?php include 'footer.php' ?>
