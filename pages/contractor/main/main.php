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
        <title>Main Control Panel</title>
        <link rel="stylesheet" href="../../../style.css" type="text/css" />
    </head>
    <body>
        <div id="tab">
            <?php include '../../../includes/contractor_top_tabs.php'; ?>
            <div class="bottom">
            </div>
        </div>
        <div id="content">

        </div>
    </body>
</html>