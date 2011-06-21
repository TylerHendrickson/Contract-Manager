<?php

require_once '../model/user.php';
session_start();

$action = $_GET['action'];

switch ($action) {
    case '':
        login(User::getUserByName($_POST['fullname']), $_POST['pass']);
        break;
    case 'forget' :
        sendMail(User::getUserByName($_POST['fullname']));
        break;
}

/*
 * This function sends a mail to a user who forgot login password.
 * The mail contains the user's login information.
 */

function sendMail($user) {
    if ($user->getName() == '') {
        header("location:../../forgot.php?fail=invalid");
        return;
    }

    if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
        header("location:../../forgot.php?fail=mail");
        return;
    }

    $message = "Hello, " . $user->getName() . ",\r\n\r\n";
    $message = $message . "You are receiving this message in response to the password reminder you requested.\r\n";
    $message = $message . "Your password is: " . $user->getPass();
    $message = wordwrap($message, 70);
    $to = $user->getEmail();
    $subject = 'Password Reminder';
    $headers = 'From: noreply@example.com' . "\r\n" .
            'Reply-To: noreply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
    header("location:../../forgot.php?fail=none");
    return;
}

function login($user, $pass) {
    if ($user->getName() != '' && $user->getPass() == $pass) {
        //Login sccessful
        $_SESSION['login'] = $user->getId();
        if ($user->getType() == 'contractor') {
            header("location:../../pages/contractor/main/main.php");
        } else if ($user->getType() == 'contractee') {
            header("location:../../pages/contractee/main/main.php");
        }
        return;
    } else {
        //Login failure
        header("location:../../auth.php?fail=invalid");
        return;
    }
}
