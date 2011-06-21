<?php
session_set_cookie_params(60 * 30); //30min
session_start();

if ($_SESSION['login'] == null) {
    Header("Location: ./auth.php ");
} else {
    $level = 'top';
    include './PHP/controller/access_check.php';
    $userType = accessByType();
    if ($userType == 'contractor') {
        header("location:./pages/contractor/main/main.php");
    } else if ($userType == 'contractee') {
        header("location:./pages/contractee/main/main.php");
    }
}
?>