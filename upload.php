<?php
//date_default_timezone_set('Asia/Dhaka');
if(isset($_POST['submit_pp'])){

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//mirakib25@gmail.com
//echo "<h1>$target_dir</h1>";

// Check if file already exists
if (file_exists($target_file)) {
    echo "<script>msg('Picture already exist. Select another', 'red');</script>";
    $uploadOk = 0;

}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 2000000) { //max 2MB
    echo "<script>msg('File is too large', 'red');</script>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "<script>msg('Select an image (jpg, jpeg, png)', 'red');</script>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $pic_filename = $_FILES['fileToUpload']['name'];
        //echo basename($pic_filename);
        $email = $_SESSION['email'];
        $query = "SELECT picture from profile WHERE email=$1";
        $query_run = pg_prepare($connection, "", $query);
        $query_run = pg_execute($connection, "", array($email))or die("<script>msg('Opps! Something wrong','red')</script>");
        $prev_file='';
        while($row = pg_fetch_array($query_run)){
          $prev_file = 'uploads/'.$row['picture'];
        }
        $_SESSION['user_pp'] = $pic_filename;

        $query = "UPDATE profile SET picture=$1 WHERE email=$2";
        $query_run = pg_prepare($connection, "", $query);
        $query_run = pg_execute($connection, "", array($pic_filename, $email))or die("<script>msg('Opps! Something wrong','red')</script>");
        echo "<script>msg('Profile picture updated!', 'green');</script>";
        $act = new activity($_SESSION['email']);
        $act->setActivity("User updated profile picture");
        if($prev_file != 'uploads/default_picture.jpg'){
          //$tmp = $row['picture'];
          $tmp = $_SERVER['DOCUMENT_ROOT'] . '/' . $prev_file;
          //echo $tmp;
          if(file_exists($tmp)){
            unlink($prev_file);
          }
        }
    } else {
        echo "<script>msg('Profile picture not updated', 'red');</script>";
    }
}
}
?>
