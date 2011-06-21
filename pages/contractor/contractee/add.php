<?php
include '../../../includes/auth_check.php';
if ($_SESSION['login'] == null) {
    Header("Location: ./auth.php ");
} else {
    $accessReq = 'contractor';
    include '../../../includes/check_access.php';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Contractee</title>
        <link rel="stylesheet" href="../../../style.css" type="text/css" />
    </head>
    <body>
        <div id="tab">
            <?php include '../../../includes/contractor_top_tabs.php'; ?>
            <div class="bottom">
            </div>
        </div>
        <div id="content">
            <form name="addcontractee" id="addcontractee" method="post" action="../../php/controller/user.php?action=add">
                <div align="center">
                    <h3>Add Contractee</h3><br />
                    <div class="mc_left">
                        Full Name: <input align="right" type="text" id="name" name="name" /><br />
                        Phone Number: <input type="text" id="phone" name="phone" /><br />
                        Email: <input type="text" id="email" name="email" /><br />
                    </div>
                    <div class="mc_right">
                        Street Address: <input type="text" id="address" name="address" /><br />
                        City: <input type="text" id="city" name="city" /><br />
                        State: <input type="text" id="state" name="state" /><br />
                        Zip Code: <input type="text" id="zip" name="zip" /><br />
                        <input type="submit" id="submit" name="submit" value="Add Contractee" />
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>