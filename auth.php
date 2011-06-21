<?php

if (isset($_GET['fail'])) {
    $err_type = $_GET['fail'];
    if ($err_type == 'invalid') {
        $err_msg = 'You entered an invalid username or password!';
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
        <form name="login" id="login" method="post" action="php/controller/login.php">
            <div align="center">
                <h3>Login</h3><br />
                Full Name: <input type="text" id="fullname" name="fullname" /><br />
                Password: <input type="password" id="pass" name="pass" /><br />
                <input type="submit" id="submit" name="submit" value="Submit" /> | <input type="reset" value="Reset" /><br />
                <a href="forgot.php">Forgot Password?</a>
            </div>
        </form>
    </body>
</html>
