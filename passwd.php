<?php
session_start();
require 'csrf.php';
$csrf=new csrf();
$token=$csrf->get_token();
$_SESSION['loggedin']=TRUE;

?>
<form action="change_pass.php" method="post">
			Current password:<br />
			<input type="password" AUTOCOMPLETE="off" name="password_current"><br />
			New password:<br />
			<input type="password" AUTOCOMPLETE="off" name="password_new"><br />
			Confirm new password:<br />
			<input type="password" AUTOCOMPLETE="off" name="password_conf"><br />
			<br />
			<input type="submit" value="Change" name="Change">
			<input type="hidden" name="token" value="<?php echo $token; ?>" />


		</form>
