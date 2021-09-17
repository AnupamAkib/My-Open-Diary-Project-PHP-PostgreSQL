<?php
include 'header.php';
if(isset($_SESSION['new_account_created'])){
  unset($_SESSION['new_account_created']);
  echo "<script>
    msg('Account successfully created', 'green');
  </script>";
  $act = new activity($_SESSION['email']);
  $act -> setActivity("User created an account");
}
if(isset($_GET['page'])==false or $_GET['page']==0){
  $_GET['page'] = 1;
}
$page = $_GET['page'];
 ?>

<title>My Open Diary | Home</title>



<div class="container">
  <h1>Public Stories
    <span style='float:right; color:darkblue; background:#e3e3e3; padding:0px 11px 0px 11px; border:3px ridge darkblue; opacity:0.7; border-radius:0%;box-shadow: 0 0 4px rgba(0,0,0,0.3);'><?php echo $page ?></span>
  </h1>


  <hr style='border:1px solid gray'>


<?php
//echo $page;
$cnt = 0;
$start = ($page-1) * 7;
$end = $page * 7;
$post_flag = false;
$query = "SELECT * FROM diary WHERE status = 'Public' ORDER BY id DESC";
$query_run = pg_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
if(pg_num_rows($query_run)){
  while($row = pg_fetch_array($query_run)){
    $cnt++;
    if($cnt > $start && $cnt <= $end){
      $post_flag = true;
      $id = $row['id'];
      $title = $row['title'];
      $author_email = $row['author_email'];
      $date_time = $row['dateandtime'];
      $author_name = 'null';
      $author_pic = 'null';

      $query1 = "SELECT * from profile where email = $1";
      $query_run1 = pg_prepare($connection, "", $query1);
      $query_run1 = pg_execute($connection, "", array($author_email))or die("<script>msg('Opps! Something wrong','red')</script>");

      while($data = pg_fetch_array($query_run1)){
        $author_name = nl2br(htmlentities($data['name']));

        $tmp = $data['picture'];
        $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
        if(file_exists($tmp)){
          $author_pic = $data['picture'];
        }
        else{
          $author_pic = "default_picture.jpg";
        }
      }
      ?>
      <div class="diary_post">
        <a class='post_title' href="<?php echo 'diary.php?story='.$id ?>"><?php echo nl2br(htmlentities($row['title'])); ?></a>
        <table border=0 style='margin-top:5px;'>
          <tr>
            <td><div style="background-image: url('uploads/<?php echo $author_pic ?>')" class='pp'></div></td>
            <td><div style='float: left; padding-left:5px;'><a style='color: #333333; font-weight:bold' href='view_profile.php?email=<?php echo $author_email ?>'><?php echo $author_name ?></a></div><br></td>
          </tr>
          <tr>
            <td><i class="fa fa-clock-o" style='font-size:30px; color: #3d3d3d'></i></td>
            <td><span style='padding-left:5px;'><?php echo $date_time ?></span></td>
          </tr>
        </table>
      </div>
      <?php
    }

  }
}
else{
  echo "<br><br><center><i class='fa fa-frown-o' style='font-size:60px; color:gray;'></i><h1 align='center'>No Public Stories Found</h1></center><br>";
}

$next = $page+1;
$prev = $page-1;
if($post_flag==false and $page!=1){
  echo "<center><div class='post_container'><h1 align='center'>Page is Empty!</h1></div><br><a href='?page=1' class='btn btn-default btn-lg'>Go to First Page</a></center>";
}
else{
 ?>
<center>
  <br>
  <font style='font-size:large;'>
    Page <?php echo $page ?> of <?php echo ceil($cnt/7)+0 ?><br>
  </font>
  <div class="btn-group">
    <button class='btn btn-primary btn-lg' type="button" onclick="window.location.href='?page=<?php echo $prev ?>'" <?php if($page==1) echo "disabled" ?>><i class='fa fa-arrow-left'></i> Prev</button>
    <button class='btn btn-primary btn-lg' type="button" onclick="window.location.href='?page=<?php echo $next ?>'" <?php if($end >= $cnt) echo "disabled" ?>>Next <i class='fa fa-arrow-right'></i></button>
  </div>
</center><br>
<?php
}
 ?>
</div>
<?php include 'footer.php' ?>
