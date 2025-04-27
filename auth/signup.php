<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
session_start();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php'; ?>
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="/biletaria_online/assets/img/metropol_icon.png">
    <title>Teatri Metropol | Regjistrohu</title>
    <link rel="stylesheet" href="/biletaria_online/assets/css/styles.css">
    <style>
        body {
            background: url('/biletaria_online/assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            font-weight: lighter;
        }

        h1 {
            font-size: 25px;
        }

        h1 span {
            font-size: 34px;
        }
    </style>
</head>
<body>
<form action="signup.php" method="post" id="signup-form" class="form-container">
    <h1>Krijoni llogari në <br>
        <span>Teatrin Metropol</span>
    </h1>
    <div class="form-group">
        <input type="text" name="name" id="name" placeholder=" " required>
        <label for="name">Emri</label>
    </div>
    <div class="form-group">
        <input type="text" name="surname" id="surname" placeholder=" " required>
        <label for="surname">Mbiemri</label>
    </div>
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required>
        <label for="email">Email</label>
    </div>
    <div class="form-group">
        <input type="tel" name="phone" id="phone" placeholder=" " required>
        <label for="phone">Numri i Telefonit</label>
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required>
        <label for="password" >Krijoni një fjalëkalim</label>
    </div>
    <div class="form-group">
        <input type="password" name="password-confirm" id="password-confirm" placeholder=" " required>
        <label for="password-confirm">Konfirmoni fjalëkalimin</label>
    </div>
    <button type="submit" name="submit" id="signup">Regjistrohu</button>
    <div class="form-footer">
        <p>Tashmë e keni një llogari? <a href="login.php">Identifikohu</a></p>
    </div>
</form>
<div class="info-container">
    <div class="name-error errors" id="name-error">
        <p>Emri s'mund të përmbajë numra ose karaktere speciale.</p>
    </div>
    <div class="surname-error errors" id="surname-error">
        <p>Mbiemri s'mund të përmbajë numra ose karaktere speciale.</p>
    </div>
    <div class="email-error errors" id="email-error">
        <p>Adresë e pasaktë email-i!</p>
    </div>
    <div class="phone-error errors" id="phone-error">
        <p>Numër i pasaktë telefoni!</p>
    </div>
    <div class="password-error errors" id="password-error">
        <p><strong>Kriteret e Fjalëkalimit : </strong><br>
            Përmban të paktën 8 karaktere.<br>
            Përmban të paktën një shkronjë të madhe.<br>
            Përmban të paktën një shkronjë të vogël.<br>
            Përmban të paktën një numër.<br>
            Përmban të paktën një karakter special. (p.sh., @, #, $, etj.).</p>
    </div>
    <div class="password-confirm-error errors" id="password-confirm-error">
        <p>Fjalëkalimet nuk përputhen.</p>
    </div>
    <?php

    if (isset($_POST['submit'])) {

        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);
        $passwordConfirm = trim($_POST['password-confirm']);
        $verification_token = md5(uniqid(rand(), true));

        $errors = [];

        if(empty($name) || empty($surname) || empty($email) || empty($phone) || empty($password) || empty($passwordConfirm)) {
            $errors[] = "Të gjitha fushat duhen plotësuar!";
        }
        if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $name)) {
            $errors[] = "Emri s'mund të përmbajë numra ose karaktere speciale.";
        }
        if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $surname)) {
            $errors[] = "Mbiemri s'mund të përmbajë numra ose karaktere speciale.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresë e pasaktë email-i!";
        }
        if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $phone)) {
            $errors[] = "Numër i pasaktë telefoni!";
        }
        if ($password !== $passwordConfirm) {
            $errors[] = "Fjalëkalimet nuk përputhen.";
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^_\-+=<>])[A-Za-z\d@$!%*?&#^_\-+=<>]{8,}$/', $password)) {
            $errors[] = "<strong>Kriteret e Fjalëkalimit : </strong><br>
                         Përmban të paktën 8 karaktere.<br>
                         Përmban të paktën një shkronjë të madhe.<br>
                         Përmban të paktën një shkronjë të vogël.<br>
                         Përmban të paktën një numër.<br>
                         Përmban të paktën një karakter special. (p.sh., @, #, $, % etj.).";
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        if($stmt->execute()) {
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $errors[] = "Email-i i dhënë tashmë i përket një llogarie.";
            }
        } else {
            $errors[] = "Një problem ndodhi! Provoni më vonë!";
        }

        $stmt->close();

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, surname, email, phone, password, verification_token) 
                                          VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $surname, $email, $phone, $hashedPassword, $verification_token);

            if(!$stmt->execute()) {
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            }

            $stmt->close();
        }

        if(empty($errors)) {
            $subject = "Verifikoni Email";
            $body = "<h2>Regjistrimi juaj ishte i suksesshëm!</h2>
                     <p>Verifikoni email-in tuaj duke klikuar link-un më poshtë për të përfunduar regjistrimin tuaj.</p>
                     <br>
                     <a href='http://localhost/biletaria_online/auth/verify-email.php?token=$verification_token'>Kliko këtu</a>";

            if(!sendEmail($email, $subject, $body)) {
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            } else {
                echo "<div class='errors show' style='background-color: rgba(131, 173, 68)'>
                         <p style='color: #E4E4E4;'>Kontrolloni email-in e dhënë për një link që ne ju kemi dërguar.</p>
                      </div>";
            }
        }

        if(!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='errors show'><p>$error</p></div>";
            }
        }

        mysqli_close($conn);
    }
    ?>
</div>
<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
<script src="/biletaria_online/assets/js/functions.js"></script>
<script src="/biletaria_online/assets/js/signupValidations.js"></script>
</body>
</html>