<?php

if ($level == 'top') {
    require_once './model/user.php';
} else {
    require_once '../../../PHP/model/user.php';
}

function accessByType() {
    $userId = $_SESSION['login'];
    $user = User::getUserById($userId);
    return $user->getType();
}

?>
