<?php
//echo $_POST['update'];
// Create connection
$connection = mysqli_connect("remotemysql.com", "Norpxv8Pp5", "GTrjPjE18M");
//select database
$db = mysqli_select_db($connection, "Norpxv8Pp5");

if($connection){
  //echo "Database Connected<hr>";
  //echo "<script>msg('database connected', 'green')</script>";
}
else{
  echo "<script>msg('Opps! Database not connected', 'red')</script>";
  exit("<meta name='viewport' content='width=device-width, initial-scale=1.0'><meta name='theme-color' content='#00034f'/>
  <div style='position:fixed; top:0px; padding-top:0px; width:100%; height:100%; background:whitesmoke; text-align:center; margin-left:-8px; font-family:arial;'><div style='font-size: large; background:darkblue; color: white; font-weight:bold; padding: 17px 0px 17px 0px'>
  My Open Diary</div><center><img src='not_connected.png' width='150px'></center>
  <div style='padding:10px;'><h2>Unable to connect database</h2>We are sorry. The system could not be connected with the database this time. Please reload this page or try again later.
  <br><br>
  Database hosted at <a href='https://remotemysql.com/'>remotemysql.com/</a>
  </div></div>");
}
?>
