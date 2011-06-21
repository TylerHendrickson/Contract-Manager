<?php
include '../../includes/auth_check.php';
include '../../includes/sub_check.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Users</title>
        <link rel="stylesheet" href="../../style.css" type="text/css" />
    </head>
    <body>
        <div id="tab">
            <?php
            include '../../includes/top_tabs.php';
            ?>
            <div class="bottom">
                <table>
                    <tr id="tab_bottom">
                        <td><a href="account.php?sub=change_pass">Change Password</a></td>
                        <td><a href="account.php?sub=change_username">Change Username</a></td>
                        <td><a href="account.php?sub=add_user">Add User</a></td>
                        <td><a href="account.php?sub=delete_user">Delete User</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="content">
            <div class="message">
                <?php
                if (isset($_GET['msg'])) {
                    $message = htmlspecialchars($_GET['msg']);
                    print($message);
                }
                ?>
            </div>
            <div class="main_content">
                <?php
                if ($page == 'add_user') {
                    include 'subsel/a_add.php';
                } else if ($page == 'change_pass') {
                    include 'subsel/a_change_pass.php';
                } else if ($page == 'change_username') {
                    include 'subsel/a_change_name.php';
                } else if ($page == 'delete_user') {
                    include 'subsel/a_delete.php';
                } else if ($page == 'first_login') {
                	include 'subsel/a_first_login.php';
                }
                ?>
            </div>
        </div>
    </body>
</html>