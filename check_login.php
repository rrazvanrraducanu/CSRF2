<?php
session_start();
//try to inject :  ' or 1=1--
// Connect to server and select database.
require_once 'connection.php';
// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];


$sql="SELECT * FROM test WHERE username='$myusername' and password='$mypassword'";
$result=$con->prepare($sql);
$result->execute();
//$result = mysqli_query($con,  $sql )or die("Vai vai vai!!!");
//$count=mysqli_num_rows($result);
$row_count =$result->rowCount();
$q=$con->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);

if($row_count){  
     // Get results
    while( $row = $q->fetch()) {
        // Get values
        $id= $row['id'];
        $username = $row['username'];
        $password  = $row['password'];
$_SESSION['id']=$id;
$_SESSION['user']=$username;
$_SESSION['pass']=$password;
        // Feedback for end user
        echo "<pre>ID: {$id}<br />Username: {$username}<br />Password: {$password}</pre>";
        echo "<a href='passwd.php?id=".$id."'>Change password for user: ".$username."</a><br/>";
    }
      echo "Login Successful<br/><br/>";
      echo "<a href='logout.php'>Logout</a>";
}else{
    echo "Wrong Username or Password";
}
?>
