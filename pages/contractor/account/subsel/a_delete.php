<?php 
require_once '../../PHP/model/user.php';

$users = User::getAllUsers();
?>
<form name="deleteuser" id="deleteuser" method="post" action="../../php/controller/account_controller.php?action=deleteuser">
    <div align="center">
        <h3>Delete User</h3><br />
            Your Pass: <input type="password" id="password" name="yourpass" /><br />
            Select Account:<select name="username" id="username">
            <option value="">Choose a account</option>
            <?php 
            foreach ($users as $u) {
            	printf("<option value=\"%s\">%s</option>", $u->getName(), $u->getName());
            }
            ?>
            </select><br />
            <input type="submit" id="submit" name="submit" value="Delete User" />
    </div>
</form>