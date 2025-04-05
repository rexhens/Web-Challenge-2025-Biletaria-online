<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../assets/vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
function sendEmail(string $email, string $subject, string $body): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();

        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPAuth = true;
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];

        $mail->setFrom($_ENV['SMTP_USER'], "Teatri Metropol");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $template = $body;

        $mail->Body = $template;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function authenticateUser($connection): bool {

    if(isset($_SESSION['id'])) {
        if($_SESSION['id'] == 1) {
            header("Location: index.php");
            exit();
        }
        return true;
    }

    if(isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $sql = "SELECT * FROM `users` WHERE `remember_token` = '$token'";
        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $user['id'];

            if($user['role'] == 'admin') {
                header("Location: index.php");
            }
            return true;
        }
    }

    header("Location: login.php");
    exit();

}

function authenticateAdmin($connection): bool {

    if(isset($_SESSION['id'])) {
        if($_SESSION['id'] != 1) {
            header("Location: index.php");
            exit();
        }
        return true;
    }

    if(isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $sql = "SELECT * FROM `users` WHERE `remember_token` = '$token'";
        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $user['id'];

            if($user['role'] == 'user') {
                header("Location: index.php");
            }
            return true;
        }
    }

    header("Location: login.php");
    exit();

}

function checkSessionTimeout(): void {

    $sessionTimeout = 900;
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $inactivityDuration = time() - $_SESSION['LAST_ACTIVITY'];
        if ($inactivityDuration > $sessionTimeout) {
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;
        }
    }

    $_SESSION['LAST_ACTIVITY'] = time();
}