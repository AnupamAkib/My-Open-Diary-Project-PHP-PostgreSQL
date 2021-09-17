<style>
  .sidebar{
    overflow-x: hidden;
    width:0px;
    height:100%;
    background: #000333;
    position: fixed;
    top:0px; left:0px;
    color: white;
    transition: 0.25s;
    box-shadow:0 0 6px rgba(0,0,0,1);
    z-index:100;
    padding-top:80px;
  }
  .sidebar a{
    text-decoration: none;
    color:white;
    padding:12px;
    padding-left:20px;
    display: block;
    font-size:large;
  }
  .sidebar a:hover{
    background: black;
    color:white;
    text-decoration: none;
    font-weight:bold;
  }
  .close_fullScreen{
    position:fixed;
    width:100%;
    height:100%;
    top:0px;
    left:0px;
    z-index:1;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
  }
  .content_title{
    position:fixed;
    top:0px;
    left:0px;
    padding: 9px 0px 9px 0px;
    background: darkblue;
    width:100%;
    z-index:200;
    color: white;
    box-shadow:0 0 8px rgba(0,0,0,0.7);
  }
  .menu_btn{
    background:transparent;
    font-size:27px;
    color:white;
    border:0px;
    padding: 10px 25px 10px 30px;
  }
</style>



<div class="sidebar" id="sidebar">
  <?php
  if(isset($_SESSION['admin_logged_in'])){
    //$_SESSION['admin_picture']
    ?>
    <center>
    <div>
      <div style="background-image: url('/uploads/<?php echo $_SESSION['admin_picture'] ?>'); background-size: 120px; background-repeat: no-repeat;width: 120px;height: 120px;border-radius: 50%;box-shadow: 0 0 7px rgba(0,0,0,0.4);">
    </div>
    <h3><?php echo $_SESSION['admin_email'] ?></h3><hr>
    </center>
    <a href='/admin/'><i class='fa fa-home' style='padding-right:5px;'></i> Dashboard</a>
    <a href='/admin/administration.php'><i class='fa fa-user' style='padding-right:5px;'></i> Administration</a>
    <a href='/admin/search_user.php'><i class='fa fa-search' style='padding-right:5px;'></i> Search User</a>
    <a href='/admin/user_activity.php'><i class='fa fa-tasks' style='padding-right:5px;'></i> User Activity</a>
    <a href='/admin/send_notification.php'><i class='fa fa-bell' style='padding-right:5px;'></i> Send Notification</a>
    <a href='/admin/system_settings.php'><i class='fa fa-cog' style='padding-right:5px;'></i> System Settings</a>
    <a href='/admin/index.php?logout=true'><i class='fa fa-sign-out' style='padding-right:5px;'></i> Logout</a>
    <hr style='border:1px solid gray'>
    <a href='/'><i class='fa fa-home' style='padding-right:5px;'></i> My Diary Home</a>
    <?php
  }
  else{
    echo "<a href='login.php'><i class='fa fa-sign-in' style='padding-right:5px;'></i> Login</a>";
  }
   ?>
</div>



<div class="close_fullScreen" id="close_fullScreen" onclick="closeSideBar()">
</div>

<script type="text/javascript">
  function openSideBar(){
    document.getElementById('sidebar').style.width='300px';
    document.getElementById('close_fullScreen').style.display='block';
  }
  function closeSideBar(){
    document.getElementById('sidebar').style.width='0px';
    document.getElementById('close_fullScreen').style.display='none';
  }
</script>


<div class="content_title">
  <table border=0 width='100%'>
    <tr>
      <td align='left' width='10'><button class='menu_btn' type="button" name="button" onclick="openSideBar()"><i class='fa fa-bars'></i></button></td>
      <td><font size='6' color='white' style='padding-left:20px'><?php if(isset($title_name)){echo $title_name;}else{echo "Admin Panel";} ?></font></td>
    </tr>
  </table>


</div>
