<?php
include 'header.php';

if(isset($_GET['email'])){
  $em = $_GET['email'];
  $query = "
  SELECT * FROM profile WHERE email=$1;
  ";
  $query_run = pg_prepare($connection, "", $query);
  $query_run = pg_execute($connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");

  if(pg_num_rows($query_run)){
    while($row = pg_fetch_array($query_run)){
      $name = nl2br(htmlentities($row['name']));
      echo "<title>$name's Profile</title>";
      if(isset($_SESSION['logged_in'])){
        $act = new activity($_SESSION['email']);
        $act -> setActivity("User visited <a href='/view_profile.php?email=$em'>$name</a>'s profile");
      }
      else{
        $act = new activity('Someone');
        $act -> setActivity("Someone visited <a href='/view_profile.php?email=$em'>$name</a>'s profile");
      }
      $bday = nl2br(htmlentities($row['birthday']));
      $gender = nl2br(htmlentities($row['gender']));
      $pic = nl2br(htmlentities($row['picture']));
      $tmp = $row['picture'];
      $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
      if(file_exists($tmp)){
        $pic = $row['picture'];
      }
      else{
        $pic = "default_picture.jpg";
      }
      $public_post = 0;
      $private_post = 0;
      $query1 = "
      SELECT * FROM diary WHERE author_email = $1
      ";
      $query_run1 = pg_prepare($connection, "", $query1);
      $query_run1 = pg_execute($connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
      while($row = pg_fetch_array($query_run1)){
        $visi = $row['status'];
        if($visi == 'Public'){
          $public_post++;
        }
        else{
          $private_post++;
        }
      }

      ?>
      <div class="post_container">
        <center>
          <div class='profile_pic' style="background-image: url('uploads/<?php echo $pic ?>'); background-size: 200px; background-repeat: no-repeat;">
          </div>
          <h1 align='center'><?php echo nl2br(htmlentities($name)) ?></h1>
          <?php
          if(isset($_SESSION['logged_in']) && isset($_SESSION['email']) && $_SESSION['email']==$_GET['email']){
            echo "<a href='profile.php?action=edit+profile'>Edit your profile</a>";
          }
           ?>
          <hr style='border:1px solid gray'>

        </center>
        <font style='font-size:large;'>
        <div style="background:whitesmoke; padding:20px">
        <b>Email:</b> <?php echo $em ?><br>
        <b>Birthday:</b> <?php echo $bday ?><br>
        <b>Gender:</b> <?php echo $gender; if($gender=='Male'){echo " <i class='fa fa-mars'></i>";}elseif($gender=='Female'){echo " <i class='fa fa-venus'></i>";}else{echo " <i class='fa fa-intersex'></i>";} ?><br>
        </div>

        <div style='float:left; width:50%; border-right:1px solid gray; margin-top:15px'>
          <center>
            <font style='font-size:62px; font-weight:bold'><?php echo $public_post ?></font>
            <br><font style='font-size: 20px'>Public Story</font>
          </center>
        </div>
        <div style='float:right; width:50%; border-left:1px solid gray; margin-top:15px'>
          <center>
            <font style='font-size:62px; font-weight:bold'><?php echo $private_post ?></font>
            <br><font style='font-size: 20px;'>Private Story</font>
          </center>
        </div>
      </font>
      <br><br><br><br><br><br><br><br>
      <?php
      if($public_post>0) echo "<h2>Public Stories</h2><hr style='border:1px solid gray'><table class='table table-hover'><tr><th>Title</th><th>Date</th></tr>";

      $query1 = "
      SELECT id, title, dateAndTime, status FROM diary WHERE author_email = $1 ORDER BY id DESC
      ";
      $query_run1 = pg_prepare($connection, "", $query1);
      $query_run1 = pg_execute($connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
      while($row = pg_fetch_array($query_run1)){
        $visi = $row['status'];
        if($visi == 'Public'){
          ?>
          <tr>
            <td width='70%'><a href='diary.php?story=<?php echo $row['id'] ?>'><?php echo nl2br(htmlentities($row['title'])) ?></a></td>
            <td><?php echo $row['dateandtime'] ?></td>
          </tr>
          <?php
        }
      }
       ?>
     </table>
      </div>
      <?php


    }
  }
  else{
    echo "<title>Not found</title>";
    echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
    User doesn't exist</h1><font style='font-size:large'>
    <b>Sorry, the no user found for email $em. Please check the email and try again.</b></center><br>
    <h3>Reason: </h3>
    <ul>
    <li>You provided wrong email</li>
    <li>Profile is deleted by admin</li>
    </ul></font>
    </div><br>";
    echo "<script>msg('User Not Found','red')</script>";
  }
}
else{
  echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
  Invalid Request</h1><font style='font-size:large'>
  <b>Sorry, the link you have provided is invalid.</b></center><br>
  <h3>Reason: </h3>
  <ul>
  <li>Invalid link</li>
  </ul></font>
  </div><br>";
  echo "<script>msg('Invalid Request','red')</script>";
}
 ?>
 <?php include 'footer.php' ?>
