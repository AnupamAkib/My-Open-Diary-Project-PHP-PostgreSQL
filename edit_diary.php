<?php
include 'header.php';
if(isset($_SESSION['logged_in'])==false){
  $_SESSION['login_first'] = true;
  echo "<script>window.location.href='enter.php?action=login'</script>";
}
if(isset($_SESSION['large_title'])){
  unset($_SESSION['large_title']);
  echo "<script>msg('Story title is too large!', 'yellow')</script>";
}
if(isset($_GET['story'])){
  $id = $_GET['story'];
  $query = "SELECT * FROM diary WHERE id=$id";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  if(mysqli_num_rows($query_run)){
    while($row = mysqli_fetch_array($query_run)){
      $title = nl2br(htmlentities($row['title']));
      $description = $row['description'];
      $status = $row['status'];
      $auth_email = $row['author_email'];
      if(isset($_SESSION['email']) && $auth_email == $_SESSION['email']){
        //ok
        ?>
        <title>Edit | <?php echo $title ?></title>
        <h1 align='center'>Edit Diary</h1>
        <div class="post_container">
          <form action="" method="POST">
            <label for="">Story Title: (Max 110 char)</label><br>
            <input type="text" name="updated_title" value="<?php echo $title ?>" class="input_field" placeholder="Story Title" required/><br>
            <label for="">Description:</label><br>
            <textarea name="updated_description" class="textarea_field" placeholder="What is the story?" required><?php echo $description ?></textarea><br>
            <label for="">Visibility: </label><br>
            <select class="input_field" name="updated_status">
              <option value="Public" <?php if($status=='Public'){echo 'selected';} ?>>Public</option>
              <option value="Private"<?php if($status=='Private'){echo 'selected';} ?>>Private</option>
            </select><br>
            <input type="submit" name="submit_updated_story" value="UPDATE" class="my_button"/>
          </form>
        </div>
        <?php
        if(isset($_POST['submit_updated_story'])){
          $updated_title = mysqli_real_escape_string($connection, $_POST['updated_title']);
          if(strlen($updated_title) > 110){
            $_SESSION['large_title'] = true;
            echo "<script>window.location.href='?story=$id'</script>";
          }
          else{
            $updated_description = mysqli_real_escape_string($connection, $_POST['updated_description']);
            $updated_status = $_POST['updated_status'];
            $last_mod = date("M d, Y | h:i A");
            //echo $last_mod;
            $query1 = "
            UPDATE diary
            SET
            title = '$updated_title',
            description = '$updated_description',
            status = '$updated_status',
            last_update = '$last_mod'
            WHERE id = $id
            ";
            $query_run1 = mysqli_query($connection, $query1)or die("<script>msg('Opps! Something wrong','red')</script>");
            //echo $query_run;
            $_SESSION['story_updated'] = true;
            echo "<script>window.location.href='my_diary.php?action=view'</script>";
          }
        }
      }
      else{
        echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
        This is not your story</h1><font style='font-size:large'>
        <b>Sorry, you have no permission to edit this story as you are not the owner of its diary.</b></center><br>
        <h3>Reason: </h3>
        <ul>
        <li>Not your story</li>
        <li>You are not the owner</li>
        </ul></font>
        </div><br>";
        echo "<script>msg('You have no permission', 'red')</script>";
      }
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
else{
  echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
  404 Not Found!</h1><font style='font-size:large'>
  <b>Sorry, we have not found the story in our database.</b></center><br>
  <h3>Reason: </h3>
  <ul>
  <li>Their is no such story</li>
  <li>Invalid link</li>
  </ul></font>
  </div><br>";
  echo "<script>msg('Story Not Found', 'red')</script>";
}
 ?>
<?php include 'footer.php' ?>
