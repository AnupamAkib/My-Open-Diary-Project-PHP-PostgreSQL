<head>
  <title>My Open Diary | Login</title>
</head>
<?php
//include "header.php";
if(isset($_SESSION['logged_in'])){
  //echo getcwd();
  echo "<script> window.location.href='profile.php'; </script>";
}
if(isset($_SESSION['incorrect_login'])){
  unset($_SESSION['incorrect_login']);
  echo "<script>msg('Incorrect Email or Password','red')</script>";
}
if(isset($_SESSION['user_suspension_flag'])){
  echo "<script>msg('Sorry, this user is suspended','red')</script>";
  unset($_SESSION['user_suspension_flag']);
}
if(isset($_SESSION['login_first'])){
  echo "<script>msg('You must login first','red')</script>";
  unset($_SESSION['login_first']);
}
if(isset($_SESSION['logged_out'])){
  echo "<script>msg('You have been logged out','red')</script>";
  unset($_SESSION['logged_out']);
}
?>

<body>
  <div class="post_container">
    <form action="" method="POST" autocomplete="off">
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input list="ad_email" class="input_field_login" type="email" name="email" value="<?php if(isset($_SESSION['temp_login_email'])) echo $_SESSION['temp_login_email'] ?>" placeholder="Email" required/>
      </div>
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input  class="input_field_login" type="password" name="password" value="" placeholder="Password" required/>
      </div>
      <datalist id="ad_email">
        <option value="mirakib25@gmail.com">
        <option value="anupam35-2640@diu.edu.bd">
      </datalist>
      <input type="submit" name="login_btn" value="LOGIN" class='my_button' id='target_btn'/>
    </form>
    <center>
      <a href="/admin/" style='font-size:large'>Go to Admin Panel login page</a>
    </center>
  </div>
</body>

<?php
if(isset($_POST['login_btn'])){
  echo "<script> disable_btn('target_btn') </script>";
  //$user_email = pg_escape_string($connection, $_POST['email']);
  //$pass = pg_escape_string($connection, $_POST['password']);
  $query = "SELECT * from profile where email=$1 and pass=$2";
  //$query_run = pg_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  $query_run = pg_prepare($connection, "", $query);
  $query_run = pg_execute($connection, "", array($_POST["email"], $_POST["password"]))or die("<script>msg('Opps! Something wrong','red')</script>");

  if(pg_num_rows($query_run)){
    //echo "<script>msg('Logged in successfully','green')</script>";
    while($row = pg_fetch_array($query_run)){
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_first_name'] = $row['fname'];
      $_SESSION['user_last_name'] = $row['lname'];
      $_SESSION['user_pp'] = $row['picture'];
      $_SESSION['user_password'] = $row['pass'];
      $_SESSION['user_suspension'] = $row['suspention'];
    }
    if($_SESSION['user_suspension']){
      $_SESSION['user_suspension_flag'] = true;
      echo "<script>window.location.href='enter.php?action=login'</script>";
    }
    else{
      $_SESSION['logged_in'] = true;
      $_SESSION['logged_in_flag'] = true;
      $_SESSION['email'] = $_POST["email"];
      echo "<script>window.location.href='my_diary.php?action=view'</script>";
    }
  }
  else{
    $_SESSION['incorrect_login'] = $_POST['email'];
    $_SESSION['temp_login_email'] = $_POST['email'];
    echo "<script>window.location.href='enter.php?action=login'</script>";
  }
}
//mirakib25@gmail.com
?>
