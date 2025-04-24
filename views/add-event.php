<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $hall = $_POST["hall"];
    $dates = explode(",", $_POST['event_dates']);
    $time = $_POST["time"];
    $description = $_POST["description"];
    $trailer = $_POST["trailer"];
    $price = $_POST["price"];

    $errors = [];

    if(empty($title) || empty($hall) || empty($dates) || empty($time) || empty($description) || empty($trailer) || empty($price)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }

    $result = isHallAvailable($conn, $hall, $time, $dates, null);

    if(!$result['available']) {
        $errors[] = "Salla është e zënë në: <br>" . implode('<br>', $result['conflict_info']);
    }

    if(empty($errors)) {
        if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
            if (!empty($_FILES['file-input']['name'])) {
                $check = getimagesize($_FILES['file-input']['tmp_name']);
                if ($check !== false) {
                    $targetDir = '../assets/img/events/';
                    $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('poster_', true) . '.' . strtolower($ext);
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

    if(empty($errors)){
        $sql = "INSERT INTO events (title, hall, time, description, poster, trailer, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $null = NULL;
            $stmt->bind_param("ssssssi", $title, $hall, $time, $description, $posterPath, $trailer, $price);
            if ($stmt->execute()) {
                $event_id = $conn->insert_id;
                $stmt->close();
                foreach ($dates as $date) {
                    $stmt = $conn->prepare("INSERT INTO event_dates (event_id, event_date) VALUES (?, ?)");
                    $stmt->bind_param("is", $event_id, $date);
                    if(!$stmt->execute()) {
                        $errors[] = "Një problem ndodhi! Provoni më vonë!";
                    }
                }
                if(empty($errors)){
                    echo "<div class='info-container'>
                               <div class='errors show' style='background-color: rgba(131, 173, 68)'>
                                   <p style='color: #E4E4E4;'>Eventi u shtua me sukses!</p>
                               </div>
                          </div>";
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
    <title>Teatri Metropol | Shto Event</title>
    <link rel="stylesheet" href="../assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

<form id="showForm" method="POST" enctype="multipart/form-data" class="fcontainer">
    <h1 style="font-size: 25px; width: 100%; margin-bottom: -10px;">Shtoni një <span>Event</span></h1>
    <div class="form-container" style="padding-top: 47px; padding-bottom: 60px;">
        <div class="form-group">
            <input type="text" name="title" id="title" placeholder=" " required>
            <label for="title">Titulli</label>
        </div>

        <div class="form-group">
            <select name="hall" id="hall" required>
                <option value="" disabled selected>-- Zgjidh sallën --</option>
                <option value="Shakespare">Shakespare</option>
                <option value="Çehov">Çehov</option>
                <option value="Bodrum">Bodrum</option>
            </select>
        </div>

        <div class="form-group">
            <input type="text" id="event_dates" name="event_dates" placeholder=" " readonly required>
            <label for="event_dates">Datat</label>
        </div>

        <div class="form-group">
            <input type="text" id="time" name="time" placeholder=" " required>
            <label for="time">Ora</label>
        </div>

        <div class="form-group">
            <textarea name="description" id="description" placeholder="Përshkrimi i eventit..." required></textarea>
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

    <button type="submit" name="submit">Shto Event</button>
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
<script src="../assets/js/flatpickr.min.js"></script>
<script src="../assets/js/functions.js"></script>
<script src="../assets/js/uploadPicture.js"></script>
<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#event_dates", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            locale: "sq"
        });

        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>
</body>
</html>