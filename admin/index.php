<?php
include 'header.php';
include 'db.php';
include 'user.php';
include 'check_login.php';

login_required();

unset($_SESSION['logged_in']);
unset($_SESSION['email']);
unset($_SESSION['view_as_admin']);

$conn = new connection("info");

function count_content_box($title, $cnt, $color){
  ?>
  <div class="boxx" style='background-color:<?php echo $color ?>'>
    <font size='5'><?php echo $title ?></font><br>
    <font style='font-size:50px; font-weight:bold'><?php echo $cnt ?></font>
  </div>
  <?php
}
?>
<center>
<div class="container">
<h1>Dashboard</h1><hr>
<?php
count_content_box('Total Story', $conn->getTotalStory(), 'darkgreen');
count_content_box('Total Public Story', $conn->getTotalPublicStory(), '#6600ba');
count_content_box('Total Private Story', $conn->getTotalPrivateStory(), 'darkblue');
count_content_box('Total User', $conn->getTotalUser(), '#c40017');

include 'all_user.php';

 ?>

</div>
</center>
<!--
<form class="" action="" method="post">
  <input type="submit" name="logout" value="LOG OUT" class="btn btn-default">
</form>-->
<?php include 'footer.php' ?>
