<?php
session_start();
date_default_timezone_set("Asia/Dhaka");
include 'sidebar.php';

if(isset($title_name)){
  echo "<title>$title_name</title>";
}
else{
  echo "<title>Admin Panel</title>";
}


 ?>
 <br><br><br><br>
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
