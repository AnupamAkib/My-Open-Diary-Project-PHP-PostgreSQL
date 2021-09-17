<?php
$title_name = "User Profile";
include 'header.php';
include 'db.php';
include 'user.php';
include 'check_login.php';

login_required();

unset($_SESSION['logged_in']);
unset($_SESSION['email']);

if(isset($_SESSION['active_account_btn'])){
  echo "<script>msg('User activited', '')</script>";
  unset($_SESSION['active_account_btn']);
}
if(isset($_SESSION['suspend_account_btn'])){
  echo "<script>msg('User suspended', '')</script>";
  unset($_SESSION['suspend_account_btn']);
}
if(isset($_SESSION['make_admin'])){
  echo "<script>msg('User promoted to admin', 'green')</script>";
  unset($_SESSION['make_admin']);
}
if(isset($_SESSION['remove_an_admin'])){
  echo "<script>msg('Admin removed', 'green')</script>";
  unset($_SESSION['remove_an_admin']);
}

 ?>
 <div class="container">

 <form class="" action="" method="get">
   <center>
     <div class="btn-group">
       <input list='all_email' class='btn btn-default' type="email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" placeholder="Enter User Email" required/>
       <button type="submit" class='btn btn-primary'>Search</button>
       <datalist id="all_email">
         <?php
         include('database_login.php');
         $connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
         $query = "SELECT email FROM profile order by email ASC";
         $query_run = pg_query($connection, $query);
         while($row = pg_fetch_array($query_run)){
           $eml = $row['email'];
           echo "<option value=$eml>";
         }
          ?>
       </datalist>
    </div>
</center>
 </form>

<?php
  if(isset($_GET['email'])){
    $email = $_GET['email'];

    $usr = new user($email);
    $admn = new admin($usr->getEmail());
    if($usr->isExist()){
      if($usr -> getEmail() != 'mirakib25@gmail.com'){
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $usr -> getEmail();
      }
      $usr->printInfo();
      if($admn->isAdminFound() && $admn->getRole()=='Super Admin'){
        echo "<center><h2>You can't change any data of a <b>Super Admin</b></h2></center>";
      }
      else{
        $_SESSION['view_as_admin'] = true;
        $usr->printActionButtons();
        $usr->viewAllStories();
      }

    }
    else{
      echo "<script>msg('User not found', 'red')</script><center><h2 style='color:red'>User Not found</h2></center>";
    }
  }
  else{
    include 'all_user.php';
  }
 ?>

 </div>
<?php include 'footer.php' ?>
