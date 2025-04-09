<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
session_start();
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <title>Metropol Ticketing | Identifikohu</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: url('../assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            font-weight: lighter;
        }

        h1 {
            font-size: 20px;
        }

        h1 span {
            font-size: 30px;
        }
    </style>
</head>
<body>
<form action="login.php" method="post" id="login-form" class="form-container">
    <h1>Mirë se vini në <br>
        <span>Metropol Ticketing</span>
    </h1>
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " required>
        <label for="email">Email</label>
    </div>
    <div class="form-group">
        <input type="password" name="password" id="password" placeholder=" " required>
        <label for="password">Fjalëkalimi</label>
    </div>
    <div class="checkbox-container">
        <input type="checkbox" value="remember_me" id="remember_me" name="remember_me">
        <label for="remember_me">Më mbaj mend</label>
    </div>
    <button type="submit" name="submit" id="login">Identifikohu</button>
    <div class="form-footer">
        <a href="change-password.php">Keni harruar fjalëkalimin?</a>
        <p>Nuk keni një llogari? <a href="signup.php">Regjistrohu</a></p>
    </div>
</form>
<div class="info-container">
    <div class="email-error errors" id="email-error">
        <p>Adresë e pasaktë email-i!</p>
    </div>
    <div class="password-error errors" id="password-error">
        <p><strong>Kriteret e Fjalëkalimit : </strong><br>
            Përmban të paktën 8 karaktere.<br>
            Përmban të paktën një shkronjë të madhe.<br>
            Përmban të paktën një shkronjë të vogël.<br>
            Përmban të paktën një numër.<br>
            Përmban të paktën një karakter special. (p.sh., @, #, $, etj.).</p>
    </div>
    <?php

    if(isset($_POST["submit"])){

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $rememberMe = isset($_POST["remember_me"]);

        $errors = [];

        if(empty($email) || empty($password)){
            $errors[] = "Të gjitha fushat duhen plotësuar!";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Adresë e pasaktë email-i!";
        }

        if(empty($errors)){
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);

            $stmt->execute();
            $result = $stmt->get_result();

            if ($user = $result->fetch_assoc()) {
                $stmt->close();

                if($user["is_verified"] == 0) {
                    $errors[] = "Duhet të verifikoni email-in si fillim! Kontrolloni email-in tuaj!";
                } else {
                    if($user["failed_attempts"] >= 7 && strtotime($user["lock_time"]) > time()) {
                        $errors[] = "Llogaria juaj është bllokuar! Provoni më vonë";
                    } else {
                        if(!password_verify($password, $user["password"])) {
                            $errors[] = "Fjalëkalim i gabuar!";
                            $failed_attempts = $user["failed_attempts"] + 1;
                            if($failed_attempts >= 7) {
                                $lock_time = date("Y-m-d H:i:s", time() + 1800);

                                $stmt = $conn->prepare("UPDATE users SET failed_attempts = ?, lock_time = ? WHERE email = ?");
                                $stmt->bind_param("iss", $failed_attempts, $lock_time, $email);

                                if (!$stmt->execute()) {
                                    $errors[] = "Një problem ndodhi! Provoni më vonë!";
                                }

                                $stmt->close();
                            } else {
                                $stmt = $conn->prepare("UPDATE users SET failed_attempts = ? WHERE email = ?");
                                $stmt->bind_param("is", $failed_attempts,  $email);

                                if (!$stmt->execute()) {
                                    $errors[] = "Një problem ndodhi! Provoni më vonë!";
                                }

                                $stmt->close();
                            }
                        } else {
                            $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, lock_time = NULL WHERE email = ?");
                            $stmt->bind_param("s", $email);

                            if (!$stmt->execute()) {
                                $errors[] = "Një problem ndodhi! Provoni më vonë!";
                            }

                            $stmt->close();
                            $_SESSION["user_id"] = $user["id"];
                            if($rememberMe) {
                                try {
                                    $rememberToken = bin2hex(random_bytes(32));

                                    $stmt = $conn->prepare("UPDATE users SET remember_token = ? WHERE email = ?");
                                    $stmt->bind_param("ss", $rememberToken,  $email);

                                    if (!$stmt->execute()) {
                                        $errors[] = "Një problem ndodhi! Provoni më vonë!";
                                        session_unset();
                                        session_destroy();
                                    } else {
                                        setcookie('remember_me', $rememberToken, time() + (86400 * 90), "/");
                                    }

                                    $stmt->close();
                                } catch (\Random\RandomException $e) {
                                    $errors[] = "Një problem ndodhi! Provoni më vonë!";
                                }
                            }
                            if (isset($_SESSION['redirect_after_login'])) {
                                $redirect = $_SESSION['redirect_after_login'];
                                unset($_SESSION['redirect_after_login']);
                                header("Location: $redirect");
                            } else {
                                header("Location: ../index.php");
                            }
                            exit();
                        }
                    }
                }
            } else {
                $errors[] = "Nuk u gjet një llogari me këtë email.";
                $stmt->close();
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
<script src="../assets/js/functions.js"></script>
<script src="../assets/js/loginValidations.js"></script>
</body>
</html>