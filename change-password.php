<?php
/** @var mysqli $conn */
require "config/db_connect.php";
require "functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'includes/links.php'; ?>
    <link rel="icon" type="image/x-icon" href="assets/img/metropol_icon.png">
    <title>Tetari Metropol | Ndrysho Falëkalimin</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            background: url('assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
        }

        button {
            margin: 15px;
        }
    </style>
</head>
<body>
<form action="change-password.php" method="post" id="change-password-form" class="form-container">
    <h1><span>Ndryshoni fjalëkalimin</span></h1>
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required>
        <label for="email">Email</label>
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required>
        <label for="password">Fjalëkalimi i Ri</label>
    </div>
    <div class="form-group">
        <input type="password" name="password-confirm" id="password-confirm" placeholder=" " required>
        <label for="password-confirm">Konfirmoni Fjalëkalimin e Ri</label>
    </div>
    <button type="submit" name="submit" id="change">Ndrysho</button>
</form>
<div class="info-container">
    <div class="email-error errors" id="email-error">
        <p>Email-i i dhënë nuk është i saktë.</p>
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

        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $passwordConfirm = trim($_POST['password-confirm']);
        $verification_token = md5(uniqid(rand(), true));

        $errors = [];

        if(empty($email) || empty($password) || empty($passwordConfirm)) {
            $errors[] = "Të gjitha fushat duhen plotësuar!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresë e pasaktë email-i!";
        }
        if ($password !== $passwordConfirm) {
            $errors[] = "Fjalëkalimet nuk përputhen!";
        }
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $errors[] = "<strong>Kriteret e Fjalëkalimit : </strong><br>
                         Përmban të paktën 8 karaktere.<br>
                         Përmban të paktën një shkronjë të madhe.<br>
                         Përmban të paktën një shkronjë të vogël.<br>
                         Përmban të paktën një numër.<br>
                         Përmban të paktën një karakter special. (p.sh., @, #, $, etj.).";
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if(!$user) {
            $errors[] = "Nuk u gjet një llogari me këtë email.";
        } else {
            $subject = "Verifikoni Email";
            $body = "<h2>Ndryshimi i fjalëkalimit u krye me sukses!</h2>
                     <p>Verifikoni email-in tuaj duke klikuar link-un më poshtë për të përfunduar me ndryshimin e fjalëkalimit.</p>
                     <br>
                     <a href='http://localhost/biletaria_online/verify-email.php?token=$verification_token'>Kliko këtu</a>";

            if(!sendEmail($email, $subject, $body)) {
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            } else {
                echo "<div class='errors show' style='background-color: rgba(131, 173, 68)'>
                         <p style='color: #E4E4E4;'>Kontrolloni email-in tuaj për një link që ne ju kemi dërguar.</p>
                      </div>";
            }
        }

        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE users SET password = ?, is_verified = 0, verification_token = ? WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $hashedPassword, $verification_token, $email);

            if(!$stmt->execute()) {
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            }

            $stmt->close();
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
<script src="assets/js/functions.js"></script>
<script src="assets/js/changePasswordValidations.js"></script>
</body>
</html>