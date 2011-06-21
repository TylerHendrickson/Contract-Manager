<?php
session_set_cookie_params(60 * 30); //30min
session_start();

if ($_SESSION['login'] == null) {
    Header("Location: ../../auth.php ");
}
?>