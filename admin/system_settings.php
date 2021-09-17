<?php
$title_name = "Settings";
include 'header.php';
include 'settings.php';
include 'check_login.php';
login_required();
unset($_SESSION['logged_in']);
unset($_SESSION['email']);
unset($_SESSION['view_as_admin']);

if(isset($_SESSION['setting_updated'])){
  echo "<script>msg('Settings has been saved', 'green')</script>";
  unset($_SESSION['setting_updated']);
}

$setting = settings::getInstance();
 ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



<div class="container" style='font-size:19'>
  <br>
  <h1 align='center'>System Settings</h1><hr>
  <form class="" action="" method="post" style='background:#f0f0f0; padding:15px; margin:10px'>
    <div class="form-check form-switch" style='margin-bottom:11px'>
      <input style='outline:none' class="form-check-input" type="checkbox" id="a1" name="new_account_registration" value="1" <?php if($setting->getRegistrationSetting()){echo "checked";} ?>>
      <label for="a1"> User can create new account</label><br>
    </div>

    <div class="form-check form-switch" style='margin-bottom:11px'>
      <input style='outline:none' class="form-check-input" type="checkbox" id="a2" name="user_activity" value="1" <?php if($setting->getTakingUserActivity()){echo "checked";} ?>>
      <label for="a2"> Collect user activity</label><br>
    </div>


    <div class="form-check form-switch" style='margin-bottom:11px'>
      <input style='outline:none' class="form-check-input" type="checkbox" id="a4" name="display_total_views" value="1" <?php if($setting->getDisplayTotalView()){echo "checked";} ?>>
      <label for="a4"> Display total views in a story</label><br>
    </div>

    <div class="form-check form-switch" style='margin-bottom:20px'>
      <input style='outline:none' class="form-check-input" type="checkbox" id="a3" name="protect_stories" value="1" <?php if($setting->getProtectStory()){echo "checked";} ?>>
      <label for="a3"> Protect stories from copying</label><br>
    </div>



    <input type="submit" name='submit' value="Save Settings" class='btn btn-primary btn-lg' style='font-size:20' id='target_btn'>
  </form>
  <?php
    if(isset($_POST['submit'])){
      echo "<script> disable_btn('target_btn') </script>";
      $flag = 0;
      if(isset($_POST['new_account_registration'])) $flag = 1;
      $setting -> setRegistrationSetting($flag);

      $flag = 0;
      if(isset($_POST['user_activity'])) $flag = 1;
      $setting -> setTakingUserActivity($flag);

      $flag = 0;
      if(isset($_POST['protect_stories'])) $flag = 1;
      $setting -> setProtectStory($flag);

      $flag = 0;
      if(isset($_POST['display_total_views'])) $flag = 1;
      $setting -> setDisplayTotalView($flag);

      $setting -> update();

      $_SESSION['setting_updated'] = true;

      echo "<script>window.location.href='/admin/system_settings.php'</script>";
    }
   ?>
</div>
<?php include 'footer.php' ?>
