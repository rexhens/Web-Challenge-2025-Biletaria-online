<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $hall = $_POST["hall"];
    $genre_id = $_POST["select-genre"];
    $dates = explode(",", $_POST['show_dates']);
    $time = $_POST["time"];
    $description = $_POST["description"];
    $trailer = $_POST["trailer"];
    $price = $_POST["price"];

    echo "Textarea length: " . strlen($_POST['description']);

    $errors = [];

    if(empty($title) || empty($hall) || empty($genre_id) || empty($dates) || empty($time) || empty($description) || empty($trailer) || empty($price)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }

    if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
        if (!empty($_FILES['file-input']['name'])) {
            $check = getimagesize($_FILES['file-input']['tmp_name']);
            if ($check !== false) {
                $poster = file_get_contents($_FILES["file-input"]["tmp_name"]);
            } else {
                $errors[] = "Skedari nuk është një imazh i vlefshëm.";
            }
        } else {
            $errors[] = "Ju duhet të zgjidhni një imazh për të ngarkuar.";
        }
    } else {
        $errors[] = "Nuk u ngarkua asnjë skedar.";
    }

    if(empty($errors)){
        $sql = "INSERT INTO shows (title, hall, genre_id, time, description, poster, trailer, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssissbsi", $title, $hall, $genre_id, $time, $description, $poster, $trailer, $price);
            $stmt->send_long_data(5, $poster);
            if ($stmt->execute()) {
                $show_id = $conn->insert_id;
                foreach ($dates as $date) {
                    $stmt = $conn->prepare("INSERT INTO show_dates (show_id, show_date) VALUES (?, ?)");
                    $stmt->bind_param("is", $show_id, $date);
                    if(!$stmt->execute()) {
                        $errors[] = "Një problem ndodhi! Provoni më vonë!";
                    }
                }
                if(empty($errors)) {
                    header("Location: assign_actors.php?show_id=" . $show_id);
                    exit();
                }
            } else {
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            }
            $stmt->close();
        } else {
            $errors[] = "Një problem ndodhi! Provoni më vonë!";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <title>Metropol Ticketing | Shto Shfaqe</title>
    <link rel="stylesheet" href="../assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: url('../assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>

<form id="showForm" method="POST" enctype="multipart/form-data" class="container">
    <h1 style="font-size: 25px; width: 100%;">Shtoni një <span>Shfaqje</span></h1>
    <div class="form-container">
        <div class="form-group">
            <input type="text" name="title" id="title" placeholder=" " required>
            <label for="title">Titulli</label>
        </div>

        <div class="form-group">
            <select name="hall" id="hall" required>
                <option value="" disabled selected>-- Zgjidh sallën --</option>
                <option value="Shakespare">Shakespare</option>
                <option value="Cehov">Cehov</option>
            </select>
        </div>

        <div class="form-group">
            <select name="select-genre" id="select-genre" required>
                <option value="" disabled selected>-- Zgjidh zhanrin --</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" id="show_dates" name="show_dates" placeholder=" " readonly required>
            <label for="show_dates">Datat</label>
        </div>

        <div class="form-group">
            <input type="text" id="time" name="time" placeholder=" " required>
            <label for="time">Ora</label>
        </div>

        <div class="form-group">
            <textarea name="description" id="description" placeholder="Përshkrimi i shfaqjes..." required></textarea>
        </div>

        <div class="form-group">
            <input type="text" id="trailer" name="trailer" placeholder=" " required>
            <label for="trailer">Trailer</label>
        </div>

        <div class="form-group">
            <input type="number" id="price" name="price" class="custom-number" min="0" placeholder=" " required>
            <label for="price">Çmimi i biletës</label>
            <div class="custom-spinner">
                <div class="plus" onclick="document.querySelector('.custom-number').stepUp()">+</div>
                <div class="minus" onclick="document.querySelector('.custom-number').stepDown()">−</div>
            </div>
        </div>
    </div>

    <div class="side-container">
        <div class="photo-container">
            <img src="../assets/img/show-icon.png" alt="poster" id="picture"></img>
            <input type="file" name="file-input" id="file-input" accept="image/*" style="display: none">
            <button type="button" id="change-photo" name="change-photo">Ngarko Poster</button>
        </div>
    </div>

    <button type="submit" name="submit">Shto Shfaqje</button>
</form>

<div class="info-container">
    <?php
    if(!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='errors show'><p>$error</p></div>";
        }
    }
    ?>
</div>
<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const genreSelect = document.getElementById("select-genre");

        fetch(`get_genres.php`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((genres) => {
                genres.forEach((genre) => {
                    const option = document.createElement("option");
                    option.value = genre.id;
                    option.textContent = genre.genre_name;
                    genreSelect.appendChild(option);
                });
            })
            .catch((error) => {
                alert("Dështoi marrja e zhanreve! Provoni përsëri!");
            });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#show_dates", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: "sq"
        });

        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            theme: "dark"
        });
    });
</script>
<script src="../assets/js/flatpickr.min.js"></script>
<script src="../assets/js/functions.js"></script>
<script src="../assets/js/uploadPicture.js"></script>
</body>
</html>