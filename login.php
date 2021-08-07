<head>
  <title>My Open Diary | Login</title>
</head>
<?php
//include "header.php";
if(isset($_SESSION['logged_in'])){
  //echo getcwd();
  echo "<script> window.location.href='profile.php'; </script>";
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
    <form action="" method="POST">
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input  class="input_field_login" type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" placeholder="Email" required/>
      </div>
      <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input  class="input_field_login" type="password" name="password" value="" placeholder="Password" required/>
      </div>
      <input type="submit" name="login_btn" value="LOGIN" class='my_button'/>
    </form>
  </div>
</body>

<?php
if(isset($_POST['login_btn'])){
  $user_email = mysqli_real_escape_string($connection, $_POST['email']);
  $pass = mysqli_real_escape_string($connection, $_POST['password']);
  $query = "SELECT * from profile where email='$user_email' and pass='$pass'";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");

  if(mysqli_num_rows($query_run)){
    //echo "<script>msg('Logged in successfully','green')</script>";
    while($row = mysqli_fetch_array($query_run)){
      $_SESSION['user_name'] = $row['name'];
      $_SESSION['user_first_name'] = $row['fname'];
      $_SESSION['user_last_name'] = $row['lname'];
      $_SESSION['user_pp'] = $row['picture'];
      $_SESSION['user_password'] = $row['pass'];
    }
    $_SESSION['logged_in'] = true;
    $_SESSION['logged_in_flag'] = true;
    $_SESSION['email'] = $user_email;
    echo "<script>window.location.href='my_diary.php?action=view'</script>";
  }
  else{
    echo "<script>msg('Incorrect email or password','red')</script>";
  }
}
//mirakib25@gmail.com
?>
