<?php
//echo "view my story\n";
$email = $_SESSION['email'];
//echo $email;
$query = "SELECT * FROM diary WHERE author_email='$email' ORDER BY id DESC";
$query_run = mysqli_query($connection, $query)or die("<script>msg('Opps! Something wrong','red')</script>");
?>
<title>View My Stories</title>
<div class="container" style="border:5px solid #e8e8e8">
<?php
if(mysqli_num_rows($query_run)){
  ?>
  <table class='table table-striped table-hover' border=0>
    <tr>
      <th>Story Name</th>
      <th style='text-align: center'>Visibility</th>
      <th style='text-align: center'>Actions</th>
    </tr>
  <?php
  while($row = mysqli_fetch_array($query_run)){
    $status = $row['status'];
    ?>
      <tr>
        <td width='75%'>
          <a href="diary.php?story=<?php echo $row['id'] ?>" style="font-weight:bold"><?php echo nl2br(htmlentities($row['title'])); ?></a><br>
          <i class="fa fa-clock-o" style='color: #3d3d3d'></i> <?php echo $row['dateAndTime'] ?>
        </td>
        <td align='center'>
          <i class="<?php if($status=='Public'){echo 'fa fa-globe';}else echo 'fa fa-lock'; ?>" style='color: #3d3d3d'></i> <?php echo $status ?>
        </td>
        <td align='right'>
          <div class="btn-group">
            <button type='button' onclick=window.location.href='edit_diary.php?story=<?php echo $row['id'] ?>' class='btn btn-default'>Edit</button>
            <button type='button' onclick=window.location.href='delete.php?story=<?php echo $row['id'] ?>' class='btn btn-primary'>Delete</button>
          </div>
        </td>
      </tr>
    <?php
  }
  ?>
</table>
  <?php
}
else{
  echo "<br><br><center><i class='fa fa-frown-o' style='font-size:55px; color:gray;'></i><h1 align='center'>No stories</h1><p>Please create some story. Your stories will appear here.</p></center><br>";
  //echo "<script>msg('Please create some stories', '')</script>";
}
 ?>
</div>
