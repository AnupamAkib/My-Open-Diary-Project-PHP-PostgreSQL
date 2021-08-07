<head>
  <title>Profile | <?php echo $_SESSION['user_name'] ?></title>
</head>
<?php
if(isset($_SESSION['logged_in'])==false){
  $_SESSION['login_first'] = true;
  echo "<script>window.location.href='enter.php?action=login'</script>";
}

 ?>
 <!--
<form method = "POST" action="" style='margin:0px 35% 0px 35%'>
  <label for="srch">Search by Email: </label>
  <input value='mirakib25@gmail.com' class='input_field' type="text" name="email" id="srch" value="" placeholder="Enter Email" required/>
  <input class='btn' type="submit" name="submit" value="SEARCH"/>
</form>
-->

<?php
include "upload.php";
//echo $_POST['email'];
if(isset($_POST['update'])==false){
  $email = $_SESSION['email'];
  $query = "SELECT * FROM profile WHERE email = '$email'";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  //echo $query;
  if(mysqli_num_rows($query_run)){ //check if result found. if result found the mysqli_num_rows will return true;
    while($row = mysqli_fetch_array($query_run)){
      $_SESSION['email'] = $row['email'];
      ?>

      <div class='post_container'>
        <center><div onclick='change_pp()' class='profile_pic' style="background-image: url('uploads/<?php echo $row['picture'] ?>'); background-size: 200px; background-repeat: no-repeat;">
          <span title='Edit profile picture' class='edit_pic' id='edit_pic'><i class="fa fa-edit"></i></span>
        </div>
        <font id='upload_image'></font>
        </center>

        <h1 align='center'><?php echo nl2br(htmlentities($row['name'])) ?></h1>

        <form action='' method='POST'>
          <label for="fname">First Name: </label><br>
          <input class='input_field' id="fname" type="text" name="fname" value="<?php echo nl2br(htmlentities($row['fname'])) ?>"><br>

          <label for="lname">Last Name: </label><br>
          <input class='input_field' id="lname" type="text" name="lname" value="<?php echo nl2br(htmlentities($row['lname'])) ?>"><br>

          <label for="email">Email: </label><br>
          <input class='input_field' id="email" type="email" name="email" value="<?php echo nl2br(htmlentities($row['email'])) ?>" disabled><br>

          <label for="bday">Birthday: </label><br>
          <input class='input_field' id="bday" type="date" name="bday" value="<?php echo $row['birthday'] ?>"><br>

          <label for="gender">Gender: </label><br>
          <select class='input_field' name='gender' id="gender">
            <option value="Male" <?php if($row['gender']=='Male'){echo 'selected';} ?> >Male</option>
            <option value="Female" <?php if($row['gender']=='Female'){echo 'selected';} ?> >Female</option>
            <option value="Other" <?php if($row['gender']=='Other'){echo 'selected';} ?> >Other</option>
          </select><br>

          <label for="phn">Phone Number: </label><br>
          <input class='input_field' id="phn" type="text" name="phn" value="<?php echo nl2br(htmlentities($row['phone'])) ?>" placeholder="Phone Number"><br>

          <label for="address">Address: </label><br>
          <input class='input_field' id="address" type="text" name="address" value="<?php echo nl2br(htmlentities($row['address'])) ?>" placeholder="Enter Address"><br>

          <input class='my_button' name='update' type='submit' value='UPDATE PROFILE'/>
        </form>
      </div>
      <?php

    }
  }
  else{ //mysqli_num_rows() is 0, that means no result found
    echo "<script>msg('Data not found!', 'red')</script>";
    unset($_SESSION['logged_in']);
    $_SESSION['logged_out'] = true;
    echo "<script>window.location.href='enter.php?action=register'</script>";
  }
}

if(isset($_POST['update'])){
  unset($_POST['update']);
  $fname = mysqli_real_escape_string($connection, ucwords($_POST['fname']));
  $lname = mysqli_real_escape_string($connection, ucwords($_POST['lname']));
  $name = $fname.' '.$lname;
  $email = $_SESSION['email'];
  $sex = $_POST['gender'];
  $bday = $_POST['bday'];
  $phone = mysqli_real_escape_string($connection, $_POST['phn']);
  $address = mysqli_real_escape_string($connection, ucwords($_POST['address']));


  $query = "
    UPDATE profile
    SET
    fname='$fname',
    lname = '$lname',
    name = '$name',
    email= '$email',
    birthday= '$bday',
    gender= '$sex',
    phone= '$phone',
    address = '$address'
    WHERE email='$email';
  ";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  if($query_run){
    $query1 = "SELECT * FROM profile WHERE email = '$email'"; //print the updated result
    $query_run1 = mysqli_query($connection, $query1)or die("<script>msg('Opps! Something wrong','red')</script>");

    if(mysqli_num_rows($query_run1)){ //check if result found. if result found the mysqli_num_rows will return true;
      while($row = mysqli_fetch_array($query_run1)){
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_first_name'] = $row['fname'];
        $_SESSION['user_last_name'] = $row['lname'];
        $_SESSION['user_pp'] = $row['picture'];
        ?>

        <script>
          window.msg("Data successfully updated", "green");
        </script>

        <div class='post_container'>
          <center><div onclick='change_pp()' class='profile_pic' style="background-image: url('uploads/<?php echo $row['picture'] ?>'); background-size: 200px; background-repeat: no-repeat;">
            <span title='Edit profile picture' class='edit_pic' id='edit_pic'><i class="fa fa-edit"></i></span>
          </div>
          <font id='upload_image'></font>
          </center>

          <h1 align='center'><?php echo nl2br(htmlentities($row['name'])) ?></h1>

          <form action='' method='POST'>
            <label for="fname">First Name: </label><br>
            <input class='input_field' id="fname" type="text" name="fname" value="<?php echo nl2br(htmlentities($row['fname'])) ?>"><br>

            <label for="lname">Last Name: </label><br>
            <input class='input_field' id="lname" type="text" name="lname" value="<?php echo nl2br(htmlentities($row['lname'])) ?>"><br>

            <label for="email">Email: </label><br>
            <input class='input_field' id="email" type="email" name="email" value="<?php echo nl2br(htmlentities($row['email'])) ?>" disabled><br>

            <label for="bday">Birthday: </label><br>
            <input class='input_field' id="bday" type="date" name="bday" value="<?php echo $row['birthday'] ?>"><br>

            <label for="gender">Gender: </label><br>
            <select class='input_field' name='gender' id="gender">
              <option value="Male" <?php if($row['gender']=='Male'){echo 'selected';} ?> >Male</option>
              <option value="Female" <?php if($row['gender']=='Female'){echo 'selected';} ?> >Female</option>
              <option value="Other" <?php if($row['gender']=='Other'){echo 'selected';} ?> >Other</option>
            </select><br>

            <label for="phn">Phone Number: </label><br>
            <input class='input_field' id="phn" type="text" name="phn" value="<?php echo nl2br(htmlentities($row['phone'])) ?>" placeholder="Phone Number"><br>

            <label for="address">Address: </label><br>
            <input class='input_field' id="address" type="text" name="address" value="<?php echo nl2br(htmlentities($row['address'])) ?>" placeholder="Enter Address"><br>

            <input class='my_button' name='update' type='submit' value='UPDATE PROFILE'/>
          </form>
        </div>

    <?php
      }
    }
  }
  else{
    echo "<script>msg('Data not updated', 'red');</script>";
  }
}
?>
