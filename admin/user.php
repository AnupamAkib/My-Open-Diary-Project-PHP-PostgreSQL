<?php
include 'admin.php';
class user{
  private $fname, $lname, $name, $email, $birthday, $gender, $pass, $phone, $address, $picture, $suspention, $found=0;
  private $connection, $story;
  function __construct($email){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $this->email = nl2br(htmlentities($email));
    $sql = "SELECT * from profile where email=$1";
    $query_run = pg_prepare($this->connection, "", $sql);
    $query_run = pg_execute($this->connection, "", array($this->email))or die("<script>msg('Opps! Something wrong','red')</script>");
    if(pg_num_rows($query_run)){
      $this->found = 1;
    }
    while($row = pg_fetch_array($query_run)){
      $this->fname = nl2br(htmlentities($row['fname']));
      $this->lname = nl2br(htmlentities($row['lname']));
      $this->name = nl2br(htmlentities($row['name']));
      $this->email = nl2br(htmlentities($row['email']));
      $this->birthday = $row['birthday'];
      $this->gender = $row['gender'];
      $this->pass = nl2br(htmlentities($row['pass']));
      $this->phone = nl2br(htmlentities($row['phone']));
      $this->address = nl2br(htmlentities($row['address']));

      $tmp = $row['picture'];
      $tmp = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'.$tmp;
      if(file_exists($tmp)){
        $this->picture = $row['picture'];
      }
      else{
        $this->picture = "default_picture.jpg";
      }
      $this->suspension = $row['suspention'];
    }

    $q = "SELECT * from diary where author_email=$1 order by id DESC";
    $this->story = pg_prepare($this->connection, "", $q);
    $this->story = pg_execute($this->connection, "", array($email))or die("<script>msg('Opps! Something wrong','red')</script>");
  }

  function isExist(){
    return $this->found;
  }

  function getFname(){
    return $this->fname;
  }
  function getLname(){
    return $this->lname;
  }
  function getFullName(){
    return $this->name;
  }
  function getEmail(){
    return $this->email;
  }
  function getBirthday(){
    return $this->birthday;
  }
  function getGender(){
    return $this->gender;
  }
  function getPassword(){
    return $this->pass;
  }
  function getPhone(){
    return $this->phone;
  }
  function getAddress(){
    return $this->address;
  }
  function getPicture(){
    return $this->picture;
  }
  function getSuspension(){
    return $this->suspension;
  }
  function getPublicStoryCnt(){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this->getEmail();
    $sql = "SELECT count(id) from diary where author_email=$1 and status='Public'";
    $q = pg_prepare($this->connection, "", $sql);
    $q = pg_execute($this->connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
    $r = pg_fetch_array($q);
    return $r[0];
  }
  function getPrivateStoryCnt(){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this->getEmail();
    $sql = "SELECT count(id) from diary where author_email=$1 and status='Private'";
    $q = pg_prepare($this->connection, "", $sql);
    $q = pg_execute($this->connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
    $r = pg_fetch_array($q);
    return $r[0];
  }

  function setSuspension($val){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this->getEmail();
    $sql = "UPDATE profile SET suspention=$val where email=$1";
    $q = pg_prepare($this->connection, "", $sql);
    $q = pg_execute($this->connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
  }

  function viewAllStories(){
    ?>
    <center><h2>All Stories</h2></center>
    <div class="table-responsive fixed-table-body">
    <table class='table table-hover'><tr><th>Name</th><th>Visibility</th><th>Actions</th></tr>
    <?php
    while($row = pg_fetch_array($this->story)){
      $story_id = $row['id'];
      ?>
      <tr><td><a href='/diary.php?story=<?php echo $row['id'] ?>' style='font-weight:bold'><?php echo nl2br(htmlentities($row['title'])) ?></a><br><?php echo $row['dateandtime'] ?></td><td><?php echo $row['status'] ?></td>
        <td>
          <button type="button" name="button" class="btn btn-primary" onclick="window.location.href='/edit_diary.php?story=<?php echo $story_id ?>'">Edit</button>
          <button type="button" name="button" class="btn btn-danger" onclick="window.location.href='/delete.php?story=<?php echo $story_id ?>'">Delete</button>
        </td>
      </tr>
      <?php
    }

    ?></div></table><?php
    if(pg_num_rows($this->story)==0){
      echo "<center><h3>This user did not make any story.</h3></center><br><br><br>";
    }
  }

  function printInfo(){
    ?>
    <center>
      <div>
        <div class='profile_pic' style="background-image: url('/uploads/<?php echo $this->getPicture() ?>'); background-size: 200px; background-repeat: no-repeat;">
      </div>
      <h1><?php echo $this->getFullName() ?></h1>
      <?php
        if($this->getSuspension()){
          echo "<b><font size='5' color='red'>(Suspended Account)</font></b>";
        }
        else{
          echo "<b><font size='5' color='green'>(Active Account)</font></b>";
        }
       ?>
       <br><br>
    </center>
    <div style="background:whitesmoke; padding:20px">
      <center>
      <div class="card_container">
          <table width="100%">
            <tr>
              <td align='center' class='card'><h1><?php echo $this -> getPublicStoryCnt() ?></h1>Public Story</td>
              <td align='center' class='card'><h1><?php echo $this -> getPrivateStoryCnt() ?></h1>Private Story</td>
            </tr>
          </table>
      </div>
      </center>
      <br>


      <b>Email: </b><?php echo $this->getEmail() ?><br>
      <b>Password: </b><?php if($this->getEmail()=='mirakib25@gmail.com'){echo "******";}else{echo $this->getPassword();} ?><br>
      <b>Birthday: </b><?php echo $this->getBirthday() ?><br>
      <b>Gender: </b><?php echo $this->getGender() ?><br>
      <b>Phone: </b><?php echo $this->getPhone() ?><br>
      <b>Address: </b><?php echo $this->getAddress() ?><br>
    </div>
    <?php
  }
  function printActionButtons(){
    ?>
    <center><br><div class="btn-group">
      <form class="" action="" method="post">
      <?php
      $admn = new admin($this->getEmail());
        if($admn->isAdminFound()){
          ?>
          <button type="submit" class="btn btn-danger" name='remove_an_admin' id='remove_admin'>Remove Admin</button>
          <button type="submit" class="btn btn-default" name='suspend_account_btn' disabled>Suspend This User</button>
          <?php
        }
        else{
          if($this -> getSuspension()){
            ?>
            <button type="submit" class="btn btn-primary" name='make_admin' disabled>Make Admin</button>
            <button type="submit" class="btn btn-default" name='active_account_btn'>Activate This User</button>
            <?php
          }
          else{
            ?>
            <button type="submit" class="btn btn-primary" name='make_admin' id='make_admin'>Make Admin</button>
            <button type="submit" class="btn btn-default" name='suspend_account_btn' id='suspend_this_user'>Suspend This User</button>
            <?php
          }

        }


       ?>
      </form>
      <?php
      if(isset($_POST['active_account_btn'])){
        //echo "active_account_btn";
        $this -> setSuspension(0);
        $em = $this->getEmail();
        $_SESSION['active_account_btn'] = true;
        echo "<script>window.location.href='search_user.php?email=$em'</script>";
      }
      if(isset($_POST['suspend_account_btn'])){
        echo "<script> disable_btn('make_admin') </script>";
        echo "<script> disable_btn('suspend_this_user') </script>";
        $this -> setSuspension(1);
        $em = $this->getEmail();
        $_SESSION['suspend_account_btn'] = true;
        echo "<script>window.location.href='search_user.php?email=$em'</script>";
      }
      if(isset($_POST['make_admin'])){
        echo "<script> disable_btn('make_admin') </script>";
        echo "<script> disable_btn('suspend_this_user') </script>";
        //echo "make admin done";
        $admn = new admin($this->getEmail());
        $admn->add();
        $em = $this->getEmail();
        $_SESSION['make_admin'] = true;
        echo "<script>window.location.href='search_user.php?email=$em'</script>";
      }
      if(isset($_POST['remove_an_admin'])){
        echo "<script> disable_btn('remove_admin') </script>";
        $admn = new admin($this->getEmail());
        $admn->remove();
        $em = $this->getEmail();
        $_SESSION['remove_an_admin'] = true;
        echo "<script>window.location.href='search_user.php?email=$em'</script>";
      }
      $em = $this->getEmail();
       ?>
    </div><br>
    <button type="button" class="btn btn-default" onclick="window.location.href='user_activity.php?email=<?php echo $em ?>'">View Activity Log</button><br><br>
    <button type="button" class="btn btn-link" onclick="window.location.href='/my_diary.php?action=view'">Login as This User</button><br><br>
    </center>
    <?php
  }
}

 ?>
