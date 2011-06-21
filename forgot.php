<?php
if (isset($_GET['fail'])) {
    $err_type = $_GET['fail'];


    if ($err_type == 'invalid') {
        $err_msg = 'The name you entered cannot be found!';
    } else if ($err_type == 'mail'){
    	$err_msg = 'The email address on record is invalid cannot be reached!';
    } else if ($err_type == 'none') {
    	$err_msg = 'A confirmation mail has been sent!';	
    }
} else {
    $err_msg = '';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="./style.css" type="text/css" />
    </head>
    <body>
        <div align="center">
<?php print($err_msg); ?>
        </div>
        <form name="login" id="login" method="post" action="php/controller/login.php?action=forget">
            <div align="center">
                <h3>Forgot password?</h3><br />
                Username: <input type="text" id="fullname" name="fullname" /><br />
                <input type="submit" id="submit" name="submit" value="Submit" /> | <input type="reset" value="Reset" /><br />
            </div>
        </form>
    </body>
</html>
