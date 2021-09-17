<?php
if(isset($_SESSION['large_title'])){
  unset($_SESSION['large_title']);
  echo "<script>msg('Story title is too large!', 'yellow')</script>";
}
 ?>
<title>Create New Story</title>
 <div class="post_container">
   <form action="" method="POST">
     <label for="">Story Title: (Max 110 char)</label><br>
     <input type="text" name="title" value="<?php if(isset($_POST['title'])) echo $_POST['title'] ?>" class="input_field" placeholder="Story Title" required/><br>
     <label for="">Description:</label><br>
     <textarea name="description" class="textarea_field" placeholder="What is the story?" required><?php if(isset($_POST['description'])) echo $_POST['description'] ?></textarea><br>
     <label for="">Visibility: </label><br>
     <select class="input_field" name="status">
       <option value="Public" <?php if(isset($_POST['status']) && $_POST['status']=='Public') echo 'selected' ?>>Public</option>
       <option value="Private"<?php if(isset($_POST['status']) && $_POST['status']=='Private') echo 'selected' ?>>Private</option>
     </select><br>
     <input type="submit" name="new_story" value="CREATE STORY" class="my_button" id='target_btn'/>
   </form>
 </div>

<?php
if(isset($_POST['new_story'])){
  $title = $_POST['title'];
  if(strlen($title) > 110){
    //$_SESSION['large_title'] = true;
    //echo "<script>window.location.href='?action=create'</script>";
    echo "<script>msg('Story title is too large!', 'yellow')</script>";
  }
  else{
    echo "<script> disable_btn('target_btn') </script>";
    $description = $_POST['description'];
    $status = $_POST['status'];
    $date_time = date("M d, Y | h:i A");
    $author_email = $_SESSION['email'];

    $query = "SELECT MAX(id) as max_id FROM diary";
    $query_run = pg_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
    $id = 0;
    while($row = pg_fetch_array($query_run)){
      $id = $row['max_id'];
    }
    $id++;
    //echo $id;

    $query = "
    INSERT INTO diary(id, title, description, dateAndTime, author_email, status, last_update)
    VALUES
    ($1, $2, $3, $4, $5, $6, 'null');
    ";
    $query_run = pg_prepare($connection, "", $query);
    $query_run = pg_execute($connection, "", array($id, $title, $description, $date_time, $author_email, $status))or die("<script>msg('Opps! Something wrong','red')</script>");

    $_SESSION['new_story_added'] = true;
    echo "<script>window.location.href='my_diary.php?action=view'</script>";
  }
}


 ?>
