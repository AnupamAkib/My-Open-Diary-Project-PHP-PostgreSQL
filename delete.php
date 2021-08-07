<?php
include 'header.php';
if(isset($_SESSION['logged_in'])==false){
  $_SESSION['login_first'] = true;
  echo "<script>window.location.href='enter.php?action=login'</script>";
}
if(isset($_GET['story'])==false || $_GET['story']==''){
  echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
  404 Not Found!</h1><font style='font-size:large'>
  <b>Sorry, we have not found the story in our database.</b></center><br>
  <h3>Reason: </h3>
  <ul>
  <li>Their is no such story</li>
  <li>Invalid link</li>
  <li>Action Misspelling</li>
  </ul></font>
  </div><br>";
  echo "<script>msg('404 not found', 'red')</script>";
}
else{
  $id = $_GET['story'];
  $author_email='';
  $title='null';
  $date_time='null';
  $query = "SELECT * FROM diary WHERE id = $id";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  if(mysqli_num_rows($query_run)){
    while($row = mysqli_fetch_array($query_run)){
      $title = nl2br(htmlentities($row['title']));
      $author_email = $row['author_email'];
      $date_time = $row['dateAndTime'];
    }
    if($author_email == $_SESSION['email']){
      ?>
      <title>Delete | <?php echo $title ?></title>
      <h1 align='center'>Delete Story</h1>
      <div class="post_container">
        <h1>Are you sure you want to delete the following story PERMANENTLY?</h1><hr style='border:1px solid gray'>
        <label for="">Story title:</label><br>
        <font size='5' color='darkblue'><b><a href='diary.php?story=<?php echo $id ?>'><?php echo $title ?></a></b></font><br>
        <label for="">Date of creation:</label><br>
        <span><?php echo $date_time ?></span><br><br>
        <form method='POST'><input type="submit" name="yes" class="btn btn-danger btn-lg" value='YES, Delete'/>
        <a type="button" name="no" class="btn btn-default btn-lg" href="my_diary.php?action=view">NO, Go back</a>
      </form>
      </div>
      <?php
      if(isset($_POST['yes'])){
        $query = "DELETE FROM diary WHERE id=$id";
        $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
        $_SESSION['story_deleted'] = true;
        echo "<script>window.location.href='my_diary.php?action=view'</script>";
      }
    }
    else{
      echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
      This is not your story</h1><font style='font-size:large'>
      <b>Sorry, you have no permission to delete this story as you are not the owner of its diary.</b></center><br>
      <h3>Reason: </h3>
      <ul>
      <li>Not your story</li>
      <li>You are not the owner</li>
      </ul></font>
      </div><br>";
      echo "<script>msg('You have no permission', 'red')</script>";
    }
  }
  else{
    echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
    404 Not Found!</h1><font style='font-size:large'>
    <b>Sorry, we have not found the story in our database.</b></center><br>
    <h3>Reason: </h3>
    <ul>
    <li>Their is no such story</li>
    </ul></font>
    </div><br>";
    echo "<script>msg('404 Not Found', 'red')</script>";
  }

}


 ?>
<?php include 'footer.php' ?>
