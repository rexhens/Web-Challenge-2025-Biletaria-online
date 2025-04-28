<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$name = "";
$email = "";
$birthday = "";
$biography = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $biography = $_POST['description'];

    $errors = [];

    if(empty($name) || empty($email) || empty($birthday) || empty($biography)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email-i nuk është i vlefshëm.";
    }

    if (empty($errors)) {
        if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
            if (!empty($_FILES['file-input']['name'])) {
                $check = getimagesize($_FILES['file-input']['tmp_name']);
                if ($check !== false) {
                    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/actors/';
                    $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('poster_', true) . 'views.' . strtolower($ext);
                    $targetPath = $targetDir . $uniqueName;

                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }

                    if (move_uploaded_file($_FILES['file-input']['tmp_name'], $targetPath)) {
                        $posterPath = $targetPath;
                    } else {
                        $errors[] = "Nuk mund të ngarkohej imazhi.";
                    }
                } else {
                    $errors[] = "Skedari nuk është një imazh i vlefshëm.";
                }
            } else {
                $errors[] = "Ju duhet të zgjidhni një imazh për të ngarkuar.";
            }
        } else {
            $errors[] = "Nuk u ngarkua asnjë skedar.";
        }
    }

    if(empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO actors (name, email, birthday, description, poster) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $birthday, $biography, $posterPath);
        if (!$stmt->execute()) {
            $errors[] = "Një problem ndodhi! Provoni më vonë!";
        } else {
            header("Location: add.php?update=success");
            exit();
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php'; ?>
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="/biletaria_online/assets/img/metropol_icon.png">
    <title>Teatri Metropol | Shto Aktor</title>
    <link rel="stylesheet" href="/biletaria_online/assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="/biletaria_online/assets/css/styles.css">
</head>

<body class="light">

<form id="showForm" method="POST" enctype="multipart/form-data" class="fcontainer">
    <h1 style="font-size: 25px; width: 100%; margin-bottom: -10px;">Shtoni një <span>Aktor</span></h1>
    <div class="form-container light" style="padding-top: 47px; padding-bottom: 60px; gap: 30px;">

        <div class="form-group">
            <input type="text" name="name" id="name" placeholder=" " value="<?php echo htmlspecialchars($name); ?>" required>
            <label for="name">Emri i plotë</label>
        </div>

        <div class="form-group">
            <input type="email" name="email" id="email" placeholder=" " value="<?php echo htmlspecialchars($email); ?>" required>
            <label for="email">Email</label>
        </div>

        <div class="form-group">
            <input type="text" id="birthday" name="birthday" placeholder=" " value="<?php echo htmlspecialchars($birthday); ?>" readonly required>
            <label for="birthday">Datëlindja</label>
        </div>

        <div class="form-group">
            <textarea name="description" id="description" placeholder="Pak biografi..." style="height: 100px;" required><?php
                if (!empty($biography)) {
                    echo htmlspecialchars($biography);
                }
                ?></textarea>
        </div>

    </div>

    <div class="side-container light">
        <div class="photo-container" style="height: 400px;">
            <img src="/biletaria_online/assets/img/actor-icon.png" alt="poster" id="picture"></img>
            <input type="file" name="file-input" id="file-input" accept="image/*" style="display: none">
            <button type="button" id="change-photo" name="change-photo">Ngarko Portret</button>
        </div>
    </div>

    <button type="submit" name="submit">Shto Aktor</button>
</form>

<div class="info-container">
    <?php
    if(!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='errors show'><p>$error</p></div>";
        }
    }
    ?>
    <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
        <div class='errors show' style='background-color: rgba(131, 173, 68)'>
            <p style='color: #E4E4E4;'>Aktori u shtua me sukses!</p>
        </div>
    <?php endif; ?>
</div>
<script src="/biletaria_online/assets/js/flatpickr.min.js"></script>
<script src="/biletaria_online/assets/js/functions.js"></script>
<script src="/biletaria_online/assets/js/uploadPicture.js"></script>
<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#birthday", {
            mode: "single",
            dateFormat: "Y-m-d",
            locale: "sq"
        });
    });
</script>
<script>
    if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('update');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
</script>
</body>
</html>