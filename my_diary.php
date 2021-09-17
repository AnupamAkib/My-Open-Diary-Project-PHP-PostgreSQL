<?php
include 'header.php';
if(isset($_SESSION['logged_in'])==false){
  $_SESSION['login_first'] = true;
  echo "<script>window.location.href='enter.php?action=login'</script>";
}
if(isset($_SESSION['story_updated'])){
  echo "<script>msg('Story updated successfully', 'green')</script>";
  unset($_SESSION['story_updated']);
  $act = new activity($_SESSION['email']);
  $act->setActivity("User edited a story");
}
if(isset($_SESSION['logged_in_flag'])){
  echo "<script>
    msg('Successfully logged in', 'green');
  </script>";
  unset($_SESSION['logged_in_flag']);

  $act = new activity($_SESSION['email']);
  $act->setActivity("Logged in to the system.");

}
if(isset($_SESSION['new_story_added'])){
  echo "<script>msg('Story created successfully', 'green')</script>";
  unset($_SESSION['new_story_added']);
  $act = new activity($_SESSION['email']);
  $act->setActivity("User created a story");
}
if(isset($_SESSION['story_deleted'])){
  unset($_SESSION['story_deleted']);
  echo "<script>msg('Story deleted', 'green')</script>";
  $act = new activity($_SESSION['email']);
  $act->setActivity("User deleted a story");
}
?>
<center>
  <div class="container">
    <h1>Welcome to your diary</h1>
    <p>This is your personal diary. You can write you stories here. Your stories will be safe and you can access them anytime by logging in to your account.</p>
    <br>
  </div>
   <div class="action_btn_container">
     <button id='first_btn' type="button" onclick="window.location.href='my_diary.php?action=view'" class='action_button' style="float: left;"><i class='fa fa-eye'></i> View My Stories</button>
     <button id='second_btn' type="button" onclick="window.location.href='my_diary.php?action=create'" class='action_button' style='float: right'><i class='fa fa-plus'></i> Create New Story</button>
     <br><br><br>
   </div>
</center>
<!--
<button type="button" name="" onclick="window.location.href='my_diary.php?action=view'">View My Story</button>
<button type="button" name="" onclick="window.location.href='my_diary.php?action=create'">Create New Story</button>
-->
<?php
if(isset($_GET['action']) && $_GET['action']=='view'){
  echo "<script>active_btn_effect('first')</script>";
}
else if(isset($_GET['action']) && $_GET['action']=='create'){
  echo "<script>active_btn_effect('second')</script>";
}
if(isset($_GET['action'])){
  if($_GET['action']=='view'){
    include 'view_my_story.php';
  }
  elseif($_GET['action']=='create'){
    include 'create_story.php';
  }
  else{
    echo "<script>msg('404 Not Found', 'red')</script>";
  }
}
else{
  echo "<script>msg('404 Not Found', 'red')</script>";
}
 ?>
<?php include 'footer.php' ?>
