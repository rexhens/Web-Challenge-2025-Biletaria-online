<?php
require "../../../config/db_connect.php";
session_start();

$errors = [];
$success = false;

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $roles = isset($_POST['role']) ? $_POST['role'] : '';
    $is_verified = 1;

    if (empty($name) || empty($surname) || empty($email) || empty($phone) || empty($password)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $name)) {
        $errors[] = "Emri nuk është i vlefshëm.";
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $surname)) {
        $errors[] = "Mbiemri nuk është i vlefshëm.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email-i nuk është i vlefshëm.";
    }
    if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $phone)) {
        $errors[] = "Numri i telefonit nuk është i vlefshëm.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Fjalëkalimi duhet të ketë të paktën 8 karaktere.";
    }

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        $errors[] = "Ky email është përdorur më parë.";
    }
    $checkStmt->close();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email, phone, password, role, verification_token, $is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $token = bin2hex(random_bytes(16));
        $stmt->bind_param("sssssss", $name, $surname, $email, $phone, $hashedPassword, $roles, $token, $is_verified);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Nuk u shtua përdoruesi. Gabim gjatë regjistrimit.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../../../includes/links.php'; ?>
    <meta property="og:image" content="../../../assets/img/metropol_icon.png">
    <link rel="icon" href="../../../assets/img/metropol_icon.png">
    <title>Teatri Metropol | Shto Përdorues</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <style>
        body {
            background-color: #1B1B1B;
            background-size: cover;
        }

        .role-options {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .role-options label {
            font-weight: normal;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }


        .back-button {
            margin-bottom: 15px;
            font-size: 14px;
            color: white;
            background-color: #444;
            padding: 7px 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: #222;
        }


        /* Input Fields */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"],
        select {
            max-width: 700px;
            padding: 14px 16px;
            font-size: 16px;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
        }

        /* Labels inside form-group */
        .form-group label {
            font-size: 16px;
        }

        /* Select Styling */
        /* Ensure the Select has the same width as other input fields */
        select {
            width: 100%;
            /* Make the select dropdown the same width */
            padding: 14px 16px;
            font-size: 16px;
            background-color: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
        }

        /* Make the back button position below the submit button */
        button {
            display: block;

            padding: 14px 16px;
            font-size: 16px;
            background-color: #444;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            /* Add some space below the button */
        }

        /* Style the back button */
        .back-button {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: white;
            background-color: #444;
            padding: 14px 16px;
            border-radius: 5px;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.2);

            /* Make back button width 100% to align with the submit button */
        }

        /* Back button hover effect */
        .back-button:hover {
            background-color: #222;
        }

        /* Form Container */
        .form-container {
            width: 100%;
            max-width: 700px;
            padding: 30px;
        }

        /* Entire Form Layout */
        .fcontainer {
            max-width: 900px;
            margin: auto;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <form method="POST" class="fcontainer">
        <h1 style="font-size: 25px; width: 100%;">Shto një <span>Përdorues</span></h1>

        <div class="form-container">
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
                <label for="password">Fjalëkalimi</label>
            </div>

            <div class="form-group">
                <label for="role"></label>
                <select name="role" id="role" required>
                    <option value="admin">Admin</option>
                    <option value="biletari">Biletari</option>
                    <option value="perdorues">Përdorues</option>
                </select>
            </div>
        </div>

        <button type="submit" name="submit">Shto Përdorues</button>


        <a href="../index.php" class="back-button">← Kthehu mbrapa</a>

    </form>


    <div class="info-container">
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='errors show'><p>$error</p></div>";
            }
        }

        if ($success) {
            echo "<div class='errors show' style='background-color: rgba(131, 173, 68)'>
                <p style='color: #E4E4E4;'>Përdoruesi u shtua me sukses!</p>
              </div>";
        }
        ?>
    </div>

    <script>
        const elementsToHide = document.getElementsByClassName("show");
        setTimeout(() => {
            Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
        }, 4500);
    </script>

</body>

</html>