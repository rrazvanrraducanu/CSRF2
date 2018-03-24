<?php
session_start();
require_once 'connection.php';
if( isset( $_POST[ 'Change' ] ) ) {
    // Check Anti-CSRF token
   require 'csrf.php';
  $csrf=new csrf();
  $token=$csrf->get_token_from_post();
  
  
  if($csrf->check_token($token)==FALSE){
      die("I am watching you!!!");
  }
if(!empty($_SESSION['loggedin']) && ($_SESSION['loggedin']===TRUE)){
    
    // Get input
    $pass_curr = $_POST[ 'password_current' ]; 
    $pass_new  = $_POST[ 'password_new' ];
    $pass_conf = $_POST[ 'password_conf' ];

    // Sanitise current password input
    $pass_curr = stripslashes( $pass_curr );
  //  $pass_curr = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass_curr ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
  //  $pass_curr = md5( $pass_curr );

    // Check that the current password is correct
    $data = $con->prepare( 'SELECT password FROM test WHERE username = (:username) AND password = (:password) LIMIT 1;' );
    $data->bindParam( ':username', $_SESSION['user'], PDO::PARAM_STR );
    $data->bindParam( ':password', $_SESSION['pass'], PDO::PARAM_STR );
    $data->execute(); 
    
    
// Do both new passwords match and does the current password match the user?
    if( ( $pass_new == $pass_conf ) && ( $data->rowCount() == 1 ) ) {
        // It does!
        $pass_new = stripslashes( $pass_new );
      //  $pass_new = ((isset($con) && is_object($con)) ? mysqli_real_escape_string($con,  $pass_new ) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
       // $pass_new = md5( $pass_new );


        // Update database with new password
        $data = $con->prepare( 'UPDATE test SET password = (:password) WHERE username = (:user);' );
        $data->bindParam( ':password', $pass_new, PDO::PARAM_STR );
        $data->bindParam( ':user', $_SESSION['user'], PDO::PARAM_STR );
        $data->execute();

        // Feedback for the user
        echo "<pre>Password Changed.</pre>";
    }
    else {
        // Issue with passwords matching
        echo "<pre>Passwords did not match or current password incorrect.</pre>";
    }
}
}else{
     $csrf->get_token();
     echo "Keep trying!";
 }


?> 