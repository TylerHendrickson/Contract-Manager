<form name="changepass" id="changepass" method="post" action="../../php/controller/account_controller.php?action=changepass">
    <div align="center">
        <h3>Change Password</h3><br />
            Old Password: <input type="password" id="old_pass" name="oldpass" /><br />
            New Password: <input type="password" id="new_pass" name="newpass" /><br />
            Re-enter new password: <input type="password" id="re_pass" name="repass" /><br />
            <input type="submit" id="submit" name="submit" value="Update Password" />
    </div>
</form>
