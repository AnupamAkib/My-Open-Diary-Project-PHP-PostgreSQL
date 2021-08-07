<?php
include 'header.php';
if(!isset($_GET['story']) || $_GET['story']==''){
  echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
  Opps! Something went wrong!</h1><font style='font-size:large'>
  <b>Sorry, something went wrong. Please check the link again.</b></center><br>
  <h3>Reason: </h3>
  <ul>
  <li>Misspelling action</li>
  <li>Invalid link</li>
  <li>Story ID is not a number</li>
  </ul></font>
  </div><br>";
  echo "<script>msg('404 Not Found','red')</script>";
}
else{
  $id = $_GET['story'];
  //echo $id;
  $query = "SELECT * FROM diary WHERE id=$id";
  $query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
  if(mysqli_num_rows($query_run)){
    while($row = mysqli_fetch_array($query_run)){
      $title = nl2br(htmlentities($row['title']));
      $author_email = $row['author_email'];
      $date_time = $row['dateAndTime'];
      $author_name = 'null';
      $author_pic = 'null';
      $author_fname = '';
      $description = nl2br(htmlentities($row['description']));
      $status = $row['status'];
      $last_modified = $row['last_update'];

      $query1 = "SELECT * from profile where email = '$author_email'";
      $query_run1 = mysqli_query($connection, $query1)or die("<script>msg('Opps! Something wrong','red')</script>");
      while($data = mysqli_fetch_array($query_run1)){
        $author_name = nl2br(htmlentities($data['name']));
        $author_fname = nl2br(htmlentities($data['fname']));
        $author_pic = $data['picture'];
      }
      if($status=='Public' || ($status=='Private' && isset($_SESSION['email']) && $author_email==$_SESSION['email'])){
        ?>
        <title>Story | <?php echo $title ?></title>
        <div class="container">
          <div class="diary_post">
            <a class='view_post_title' href="<?php echo 'diary.php?story='.$id ?>"><?php echo $title ?></a><br>
            <table border=0 style='margin-top:10px'>
              <tr>
                <td><div style="background-image: url('uploads/<?php echo $author_pic ?>')" class='pp'></div></td>
                <td><div style='float: left; padding-left:5px;'><a style='color: #333333; font-weight:bold' href='view_profile.php?email=<?php echo $author_email ?>'><b><?php echo $author_name ?></b></a></div><br></td>
              </tr>
              <tr>
                <td><i class="fa fa-clock-o" style='font-size:29px; color: #3d3d3d'></i></td>
                <td><span style='padding-left:5px;'><?php echo $date_time ?></span></td>
              </tr>
              <tr>
                <td><i class="<?php if($status=='Public'){echo 'fa fa-globe';}else echo 'fa fa-lock'; ?>" style='font-size:28px; color: #3d3d3d'></i></td>
                <td><span style='padding-left:5px;'><?php echo $status ?></span></td>
              </tr>
            </table>
            <hr style='border:1px solid gray'>
            <p style='font-size:large'><?php echo $description ?>
            <br><br><span style='float:right;'><b>- <i><?php echo $author_fname ?> <?php if($last_modified!='null') echo "(Last modified: $last_modified)" ?></i></b></span><br><br></p>
          </div>
        </div>

        <?php
        if(isset($_SESSION['email']) && $author_email == $_SESSION['email']){
          echo "<div class='instant_edit' title='Edit this story'><center>
            <a href='edit_diary.php?story=$id'><i class='fa fa-pencil'></i></a></center>
          </div>";
        }
      }
      else{
        echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
        This story is private</h1><font style='font-size:large'>
        <b>Sorry, since the story has been set private by the owner, we can not give you access to view it.</b></center><br>
        <h3>Reason: </h3>
        <ul>
        <li>Private story</li>
        <li>You are not the owner of the diary</li>
        </ul></font>
        </div><br>";
        echo "<script>msg('Sorry, this story is not public','red')</script>";
      }
    }
  }
  else{
    echo "<div class='post_container'><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>
    404 Not Found!</h1><font style='font-size:large'>
    <b>Sorry, we have not found the story in our database.</b></center><br>
    <h3>Reason: </h3>
    <ul>
    <li>Maybe their is no such story</li>
    <li>The story is deleted by the diary owner</li>
    </ul></font>
    </div><br>";
    echo "<script>msg('404 Not Found','red')</script>";
  }
}
 ?>
<?php include 'footer.php' ?>
