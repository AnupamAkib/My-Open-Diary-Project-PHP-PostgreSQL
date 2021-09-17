<?php
$title_name = "Notification";
include 'header.php';
include 'notification.php';
include 'check_login.php';

login_required();

unset($_SESSION['logged_in']);
unset($_SESSION['email']);
unset($_SESSION['view_as_admin']);

if(isset($_SESSION['notification_saved'])){
  echo "<script>msg('Notification settings saved', 'green')</script>";
  unset($_SESSION['notification_saved']);
}

$notice = notification::getInstance();
 ?>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


<div class="container" style='font-size:20'><br>
  <center>
    <font style='font-size:27; font-weight:bold;'>Send Notification</font><br>
    <font>Send notification to all user. Notofication will be displayed when you toggle the switch. You can use plain text or HTML content for writing a notification</font>
  </center><br>
  <form method="post" style='background:#f0f0f0; padding:15px; margin:10px'>
    Write Notification:<br>
    <textarea name="notification_msg" rows="8" id='editor' placeholder="Write something for notification" class='form-control' style='font-size:large; margin-bottom:12px;'><?php echo $notice->getNotice() ?></textarea>
    <div class="form-check form-switch" style='margin-bottom:15px'>
      <input style='outline:none' class="form-check-input" type="checkbox" id="txt" name="is_display_notice" value="1" <?php if($notice->getNoticeFlag()){echo "checked";} ?>>
      <label for="txt"> Show Notification to user</label><br>
    </div>
    <center>
    <button type="submit" name="save_notice" class='btn btn-primary' style='font-size:25px; padding:5px 20px' id='target_btn'>SAVE</button>
    <button type="button" class='btn btn-secondary' style='font-size:25px; padding:5px 20px' onclick="preview()">Preview</button>
    </center>
  </form><br>

  <div id='preview' style='border:2px solid #f0f0f0;'><font style='color:gray; padding:15px; display:block'>Your Notification preview will appear here after you click on 'Preview'</font></div>
</div>

<script type="text/javascript">
  function preview(){
    var content = document.getElementById('editor').value;
    document.getElementById('preview').innerHTML = "<div class='alert alert-warning alert-dismissible' style='font-size:19'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>"+content+"</div>";
    document.getElementById('preview').style.border = 0;
  }
</script>

<?php
if(isset($_POST['save_notice'])){
  echo "<script> disable_btn('target_btn') </script>";
  $txt = $_POST['notification_msg'];
  $flag = 0;
  if(isset($_POST['is_display_notice'])) $flag = 1;
  $notice -> setNotice($txt);
  $notice -> setNoticeFlag($flag);
  $notice -> update();
  $_SESSION['notification_saved'] = true;
  echo "<script>window.location.href='/admin/send_notification.php'</script>";
}
 ?>

<?php include 'footer.php' ?>
