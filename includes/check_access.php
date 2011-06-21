<?php

require_once '../../../PHP/controller/access_check.php';

$userType = accessByType();
if ($userType != $accessReq) {
    header("Location:../../contractee/main/main.php");
}
?>
