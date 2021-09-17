<?php
include 'header.php';

$sett = settings::getInstance();

if($sett -> getProtectStory()){
  echo "<script type='text/javascript' src='killcopy.js'></script>";
}

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
  $query = "SELECT * FROM diary WHERE id=$1";
  $query_run = pg_prepare($connection, "", $query);
  $query_run = pg_execute($connection, "", array($id))or die("<script>msg('Opps! Something wrong','red')</script>");

  if(pg_num_rows($query_run)){
    while($row = pg_fetch_array($query_run)){
      $title = nl2br(htmlentities($row['title']));
      if(isset($_SESSION['logged_in'])){
        $act = new activity($_SESSION['email']);
        $act -> setActivity("User viewed story <a href='/diary.php?story=$id'>$title</a>");
      }
      else{
        $act = new activity('Someone');
        $act -> setActivity("Someone viewed story <a href='/diary.php?story=$id'>$title</a>");
      }
      $author_email = $row['author_email'];
      $date_time = $row['dateandtime'];
      $views = $row['views'];
      $author_name = 'null';
      $author_pic = 'null';
      $author_fname = '';
      $description = nl2br(htmlentities($row['description']));
      $status = $row['status'];
      $last_modified = $row['last_update'];

      $query1 = "SELECT * from profile where email = $1";
      $query_run1 = pg_prepare($connection, "", $query1);
      $query_run1 = pg_execute($connection, "", array($author_email))or die("<script>msg('Opps! Something wrong','red')</script>");
      while($data = pg_fetch_array($query_run1)){
        $author_name = nl2br(htmlentities($data['name']));
        $author_fname = nl2br(htmlentities($data['fname']));
        $tmp = $data['picture'];
        $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
        if(file_exists($tmp)){
          $author_pic = $data['picture'];
        }
        else{
          $author_pic = "default_picture.jpg";
        }
      }
      if($status=='Public' || ($status=='Private' && isset($_SESSION['email']) && $author_email==$_SESSION['email'])){
        ?>
        <title>Story | <?php echo $title ?></title>
        <div class="container">
          <div class="diary_post">
            <a id='copy' class='view_post_title' href="<?php echo 'diary.php?story='.$id ?>"><?php echo $title ?></a><br>
            <table border=0 style='margin-top:10px'>
              <tr>
                <td><div style="background-image: url('uploads/<?php echo $author_pic ?>')" class='pp'></div></td>
                <td><div style='float: left; padding-left:5px;'><a style='color: #333333; font-weight:bold' href='view_profile.php?email=<?php echo $author_email ?>'><b><?php echo $author_name ?></b></a></div><br></td>
              </tr>
              <tr>
                <td><i class="fa fa-clock-o" style='font-size:28px; color: #3d3d3d'></i></td>
                <td><span style='padding-left:5px;'><?php echo $date_time ?></span></td>
              </tr>
              <tr>
                <td><i class="<?php if($status=='Public'){echo 'fa fa-globe';}else echo 'fa fa-lock'; ?>" style='font-size:27px; color: #3d3d3d'></i></td>
                <td><span style='padding-left:5px;'><?php echo $status ?></span></td>
              </tr>
              <?php
              if($sett->getDisplayTotalView()){
                ?>
                <tr>
                  <td><i class="fa fa-eye" style='font-size:25px; color: #3d3d3d'></i></td>
                  <td><span style='padding-left:5px;'><?php echo $views; if($views<=1){echo " view";}else{echo " views";} ?></span></td>
                </tr>
                <?php
              }
               ?>
            </table>

            <br>
            <?php
            if($status=="Public"){
              ?>
              <button class='btn btn-primary' onclick="window.location.href='http://www.facebook.com/sharer.php?u=https://<?php echo $_SERVER['SERVER_NAME'] ?>/diary.php?story=<?php echo $id ?>'"><i class='fa fa-facebook-official'></i> Share</button>
              <?php
            }

            $domain_name = "";

             ?>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

            <button class='btn btn-default' onclick="window.print()"><i class='fa fa-print'></i> Print</button>
            <button class='btn btn-default' onclick="copyToClipboard('#copy')"><i class='fa fa-copy'></i> Copy Link</button>

            <script type="text/javascript">
            function copyToClipboard(element){
              //alert(element);
              var $temp = $("<input>");
              $("body").append($temp);
              $temp.val("https://<?php echo $_SERVER['SERVER_NAME'] ?>/"+$(element).attr("href")).select();
              document.execCommand("copy");
              $temp.remove();
              msg('Link copied', '');
            }
            </script>



            <hr style='border:1px solid gray'>
            <p style='font-size:large'><?php echo $description ?>
            <br><br><span style='float:right;'><b>- <i><?php echo $author_fname ?> <?php if($last_modified!='null') echo "(Last modified: $last_modified)" ?></i></b></span><br><br></p>
          </div>
        </div>

        <?php
        //increment view for this story
        if(!isset($_SESSION['cnt'.$id])){
          $sql = "SELECT views from diary where id=$1";
          $q = pg_prepare($connection, "", $sql);
          $q = pg_execute($connection, "", array($id))or die("<script>msg('Opps! Something wrong','red')</script>");
          $row = pg_fetch_array($q);
          $view_cnt = $row['views'] + 1;

          $sql = "UPDATE diary SET views=$view_cnt where id=$1";
          $q = pg_prepare($connection, "", $sql);
          $q = pg_execute($connection, "", array($id))or die("<script>msg('Opps! Something wrong','red')</script>");
          $_SESSION['cnt'.$id] = true;
        }


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
    <li>The story is deleted by the diary owner or the admin</li>
    </ul></font>
    </div><br>";
    echo "<script>msg('404 Not Found','red')</script>";
  }
}
 ?>
<?php include 'footer.php' ?>
