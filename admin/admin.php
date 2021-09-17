<?php
class admin{
  private $email, $password, $name;
  private $role, $adminFound=1;
  private $connection, $picture;

  function __construct($email){
    $this->email = nl2br(htmlentities($email));
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $sql = "SELECT * from admin where email=$1";
    $query_run = pg_prepare($this->connection, "", $sql);
    $query_run = pg_execute($this->connection, "", array($this->email))or die("<script>msg('Opps! Something wrong','red')</script>");
    if(pg_num_rows($query_run)==0){
      $this->adminFound = 0;
    }
    else{
      while($row = pg_fetch_array($query_run)){
        $this -> role = $row['role'];
        $sql2 = "SELECT name, pass, picture from profile where email=$1";
        $query_run2 = pg_prepare($this->connection, "", $sql2);
        $query_run2 = pg_execute($this->connection, "", array($this->email))or die("<script>msg('Opps! Something wrong','red')</script>");
        while($row2 = pg_fetch_array($query_run2)){
          $this -> name = nl2br(htmlentities($row2['name']));
          $this -> password = nl2br(htmlentities($row2['pass']));
          $this -> picture = $row2['picture'];
        }
      }
    }
  }

  function isAdminFound(){
    return $this -> adminFound;
  }
  function getAdminEmail(){
    return $this->email;
  }
  function getAdminName(){
    return $this -> name;
  }
  function getPassword(){
    return $this -> password;
  }
  function getRole(){
    return $this -> role;
  }
  function getPicture(){
    return $this -> picture;
  }

  function remove(){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this->getAdminEmail();
    if($em == 'mirakib25@gmail.com') return;
    $sql = "DELETE FROM admin WHERE email=$1";
    $query_run = pg_prepare($this->connection, "", $sql);
    $query_run = pg_execute($this->connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
    if($em == $_SESSION['admin_email']){
      echo "<script>window.location.href='/admin/index.php?logout=true'</script>";
    }
  }
  function add(){
    include('database_login.php');
    $this->connection = pg_connect($conn_string) or die("<script>msg('Could not connect to PostgreSQL', 'red')</script>");
    $em = $this->getAdminEmail();
    $sql = "INSERT INTO admin (email, role) VALUES($1, 'Admin')";
    $query_run = pg_prepare($this->connection, "", $sql);
    $query_run = pg_execute($this->connection, "", array($em))or die("<script>msg('Opps! Something wrong','red')</script>");
  }
  function printInfo(){
    ?>
    <tr>
      <td>
        <div style="margin-right:5px;background-image: url('/uploads/<?php echo $this->getPicture() ?>'); background-size: 20px;background-repeat: no-repeat;width: 20px;height: 20px;border-radius: 50%;float:left;"></div>
        <div style='float:left'><?php echo $this->getAdminName() ?></div>
      </td>
      <td><?php echo $this->getRole() ?></td>
      <td>Remove</td>
    </tr>
    <?php
  }
}
 ?>
