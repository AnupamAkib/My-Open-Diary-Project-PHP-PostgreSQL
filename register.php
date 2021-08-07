<?php
//include 'header.php';
if(isset($_SESSION['logged_in'])){
  //echo getcwd();
  echo "<script> window.location.href='profile.php'; </script>";
}
?>
<title>My Open Diary | Register</title>
<!--<h1 align='center'>Create New Account</h1>-->
<div class="post_container">
  <form action="" method="post">
    <label for="">First Name:</label><br>
    <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname'] ?>" placeholder="First Name" class='input_field' required/><br>
    <label for="">Last Name:</label><br>
    <input type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname'] ?>" placeholder="Last Name" class='input_field' required/><br>
    <label for="">Email:</label><br>
    <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>" placeholder="Email" class='input_field' required/><br>
    <label for="">Birth Date:</label><br>
    <input type="date" name="birthday" value="<?php if(isset($_POST['birthday'])) echo $_POST['birthday'] ?>" placeholder="Date of Birth" class='input_field' required/><br>
    <label for="">Gender:</label><br>
    <select class='input_field' name='gender' required>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select><br>
    <label for="">Password:</label><br>
    <input type="password" name="pass" value="" placeholder="Password" class='input_field' required/><br>
    <label for="">Re-write Password:</label><br>
    <input type="password" name="pass_again" value="" placeholder="Re-write Password" class='input_field' required/><br>

    <input type="submit" name="register" value="CREATE ACCOUNT" class='my_button'/>
  </form>
</div>

<?php
if(isset($_POST['register'])){
  $fname = mysqli_real_escape_string($connection, ucwords($_POST['fname']));
  $lname = mysqli_real_escape_string($connection, ucwords($_POST['lname']));
  $name = $fname." ".$lname;
  $email = mysqli_real_escape_string($connection, $_POST['email']);
  $birthday = $_POST['birthday'];
  $gender = $_POST['gender'];
  $pass = mysqli_real_escape_string($connection, $_POST['pass']);
  $pass_again = mysqli_real_escape_string($connection, $_POST['pass_again']);

  $query = "select * from profile where email = '$email'";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  if(mysqli_num_rows($query_run)){
    echo "<script>msg('The email is already exists', 'red')</script>";
  }
  elseif($pass==$pass_again){
    if(check_password($pass)){
      $query = "
        insert into profile(fname, lname, name, email, birthday, gender, pass, phone, address, picture)
        values
        ('$fname', '$lname', '$name', '$email', '$birthday', '$gender', '$pass', '+880', '', 'default_picture.jpg');
      ";
      $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
      $_SESSION['new_account_created'] = true;
      $_SESSION['logged_in'] = true;
      $_SESSION['email'] = $email;
      $_SESSION['user_name'] = $name;
      $_SESSION['user_first_name'] = $fname;
      $_SESSION['user_last_name'] = $lname;
      $_SESSION['user_pp'] = 'default_picture.jpg';
      $_SESSION['user_password'] = $pass;
      //echo $query;
      echo "<script>window.location.href='index.php';</script>";
    }
  }
  else{
    echo "<script>msg('Password did not match', 'red')</script>";
  }

}

 ?>
