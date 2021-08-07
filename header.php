<?php
session_start();
include "connect_db.php";
date_default_timezone_set("Asia/Dhaka");
if(isset($_GET['logout'])){
  unset($_SESSION['logged_in']);
  unset($_SESSION['email']);
  unset($_SESSION['user_name']);
  $_SESSION['logged_out'] = true;
}
$temp='';
if(isset($_SESSION['prev_link'])==false){
  $_SESSION['prev_link'] = '/';
}
$prev_link = $_SESSION['prev_link'];
 ?>


<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#00034f"/>
<!-- default theme -->
<link rel='stylesheet' href='style.css'/>
<script type='text/javascript' src='script.js'></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Atma&family=Fira+Sans&family=Open+Sans&display=swap" rel="stylesheet">

<meta name="description" content="My Open Diary is an online diary where you can publish your stories either in private or in public.">
<meta name="keywords" content="Online diary, free online diary, open diary, my diary">
<meta name="author" content="Mir Anupam Hossain Akib">
<meta property="og:image" content="og-img.png"/>



<span id='tmp'></span>
<?php
function check_password($pwd){ //can not countain ' and $ (minimun length 6)
  if(strlen($pwd)<6){
    echo "<script>msg('Password must be at least 6 characters', 'red')</script>";
    return false;
  }
  for($i=0; $i<strlen($pwd); $i++){
    if($pwd[$i]=='\'' || $pwd[$i]=='$'){
      echo "<script>msg('Invalid character found in password', 'red')</script>";
      return false;
    }
  }
  return true;
}
 ?>

 <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
 <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



 <nav class="navbar navbar-inverse" style="background: linear-gradient(to left, #00034f, #000580); background-color: #00034f; border-color: #00034f; padding: 7px 0px 7px 0px; position:fixed; top:0; left:0; width:100%; z-index:2">
   <div class="container-fluid">
     <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="background: #000482; border-color: #000482">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="/" style='color:whitesmoke'><b>My Open Diary</b></a>
     </div>
     <div class="collapse navbar-collapse" id="myNavbar">
       <ul class="nav navbar-nav">
         <li><a href="/">Home</a></li>
         <li><a href="/about.php">About</a></li>
         <li><a href="mailto: mirakib25@gmail.com">Feedback</a></li>
       </ul>






       <ul class="nav navbar-nav navbar-right">

         <li>
         <form method='GET' action="<?php echo $_SESSION['prev_link'] ?>"><button type='submit' value='Dark' id='theme' style='color:#e5e5e5; margin-top:11px; background:transparent; border:1px solid #e5e5e5; border-radius:5px; margin-left:15px' title='Change Theme' name='theme'><i class="fa fa-moon-o"></i> Dark Mode</button></form>
        </li>

         <?php
         if(isset($_SESSION['logged_in'])){
           $email = $_SESSION['email'];
           $query = "SELECT * from profile where email = '$email'";
           $query_run = mysqli_query($connection, $query);
           while($row = mysqli_fetch_array($query_run)){
             $first_name = $row['fname'];
             $name = $row['name'];
             $pic = $row['picture'];
           }
           ?>




           <li><a href="/my_diary.php?action=view">View My Story</a></li>
           <li><a href="/my_diary.php?action=create">Create Story</a></li>
           <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo nl2br(htmlentities($name)) ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">

              <li><a href="/profile.php?action=edit+profile"><b><?php echo $email ?></b></a></li>
              <li><a href="/profile.php?action=edit+profile">My Profile</a></li>
              <li><a href="/profile.php?logout=true">Log Out</a></li>
            </ul>
          </li>
           <?php
         }
         else{
           echo "<li><a href='/enter.php?action=register'><span class='glyphicon glyphicon-user'></span> Create Account</a></li>
           <li><a href='/enter.php?action=login'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
         }
          ?>
       </ul>
     </div>
   </div>
 </nav>
 <br><br><br><br>
<?php
if(isset($_GET['theme'])){
  $_SESSION['theme'] = $_GET['theme'];
  unset($_GET['theme']);
  echo "<script>window.location.href='$prev_link'</script>";
}
if(isset($_SESSION['theme'])){
  if($_SESSION['theme']=='Lite'){
    //Lite <i class="fa fa-moon-o"></i>
    echo "
    <script>
    document.getElementById('theme').value='Dark';
    document.getElementById('theme').innerHTML='<i class=\"fa fa-moon-o\"></i> Dark Mode';
    </script>
    <link rel='stylesheet' href='/style.css'/>
    <script type='text/javascript' src='/script.js'></script>
    ";
  }
  else{
    echo "
    <script>
    document.getElementById('theme').value='Lite';
    document.getElementById('theme').innerHTML='<i class=\"fa fa-sun-o\"></i> Light Mode';
    </script>
    <link rel='stylesheet' href='/style_dark.css'/>
    <script type='text/javascript' src='/script_dark.js'></script>
    ";
  }
}
$now_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['prev_link'] = $now_link;
$prev_link = $_SESSION['prev_link'];
 ?>
