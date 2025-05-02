<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

?>

<?php

$title = '';
$hall = '';
$dates = '';
$time = '';
$description = '';
$trailer = '';
$price = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $hall = $_POST["hall"];
    $genre_id = $_POST["select-genre"];
    $dates = explode(",", $_POST['show_dates']);
    $time = $_POST["time"];
    $description = $_POST["description"];
    $trailer = $_POST["trailer"];
    $price = $_POST["price"];

    $errors = [];

    if (empty($title) || empty($hall) || empty($genre_id) || empty($dates) || empty($time) || empty($description) || empty($trailer) || empty($price)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }

    $result = isHallAvailable($conn, $hall, $time, $dates, null);

    if (!$result['available']) {
        $errors[] = "Salla është e zënë në: <br>" . implode('<br>', $result['conflict_info']);
    }

    if (empty($errors)) {
        if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
            if (!empty($_FILES['file-input']['name'])) {
                $check = getimagesize($_FILES['file-input']['tmp_name']);
                if ($check !== false) {
                    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/shows/';
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

    if (empty($errors)) {
        $conn->begin_transaction();

        $sql = "INSERT INTO shows (title, hall, genre_id, time, description, poster, trailer, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $null = NULL;
            $stmt->bind_param("ssissssi", $title, $hall, $genre_id, $time, $description, $posterPath, $trailer, $price);
            if ($stmt->execute()) {
                $show_id = $conn->insert_id;
                foreach ($dates as $date) {
                    $stmt = $conn->prepare("INSERT INTO show_dates (show_id, show_date) VALUES (?, ?)");
                    $stmt->bind_param("is", $show_id, $date);
                    if (!$stmt->execute()) {
                        $errors[] = "Një problem ndodhi! Provoni më vonë!";
                        break;
                    }
                }
                if (empty($errors)) {
                    $conn->commit();
                    header("Location: assign_actors.php?show_id=" . $show_id);
                    exit();
                } else {
                    $conn->rollback();
                }
            } else {
                $conn->rollback();
                $errors[] = "Një problem ndodhi! Provoni më vonë!";
            }
            $stmt->close();
        } else {
            $conn->rollback();
            $errors[] = "Një problem ndodhi! Provoni më vonë!";
        }
    }

    $conn->close();
}
?>

<?php
$pageTitle = 'Shto Shfaqje';
$pageStyles = [
    '/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css',
    '/biletaria_online/assets/css/sb-admin-2.min.css',
    "/biletaria_online/assets/css/flatpickr.min.css",
    '/biletaria_online/assets/css/styles.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        .navbar-nav span {
            color: white !important;
        }
    </style>
</head>

<body id="page-top" class="light">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>

            <form id="showForm" method="POST" enctype="multipart/form-data" class="fcontainer">
                <h1 style="font-size: 25px; width: 100%; margin-bottom: -10px;">Shtoni një <span>Shfaqje</span></h1>
                <div class="form-container light">
                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder=" "
                            value="<?php echo htmlspecialchars($title); ?>" required>
                        <label for="title">Titulli</label>
                    </div>

                    <div class="form-group">
                        <select name="hall" id="hall" required>
                            <option value="" disabled <?php echo empty($hall) ? 'selected' : ''; ?>>-- Zgjidh sallën --
                            </option>
                            <option value="Shakespare" <?php echo ($hall == 'Shakespare') ? 'selected' : ''; ?>>Shakespare
                            </option>
                            <option value="Çehov" <?php echo ($hall == 'Çehov') ? 'selected' : ''; ?>>Çehov</option>
                            <option value="Bodrum" <?php echo ($hall == 'Bodrum') ? 'selected' : ''; ?>>Bodrum</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="select-genre" id="select-genre" required>
                            <option value="" disabled selected>-- Zgjidh zhanrin --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" id="show_dates" name="show_dates" placeholder=" "
                            value="<?php echo $dates ? implode(',', $dates) : ''; ?>" readonly required>
                        <label for="show_dates">Datat</label>
                    </div>

                    <div class="form-group">
                        <input type="text" id="time" name="time" placeholder=" "
                            value="<?php echo htmlspecialchars($time); ?>" required>
                        <label for="time">Ora</label>
                    </div>

                    <div class="form-group">
                        <textarea name="description" id="description" placeholder="Përshkrimi i shfaqjes..."
                            required><?php echo htmlspecialchars($description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" id="trailer" name="trailer" placeholder=" "
                            value="<?php echo htmlspecialchars($trailer); ?>" required>
                        <label for="trailer">Trailer</label>
                    </div>

                    <div class="form-group">
                        <input type="number" id="price" name="price" class="custom-number" min="0" placeholder=" "
                            value="<?php echo htmlspecialchars($price); ?>" required>
                        <label for="price">Çmimi i biletës</label>
                        <div class="custom-spinner">
                            <div class="plus" onclick="document.querySelector('.custom-number').stepUp()">+</div>
                            <div class="minus" onclick="document.querySelector('.custom-number').stepDown()">−</div>
                        </div>
                    </div>
                </div>

                <div class="side-container light" style="padding-top: 27px !important; padding-bottom: 27px !important;">
                    <div class="photo-container">
                        <img src="../../../assets/img/show-icon.png" alt="poster" id="picture"></img>
                        <input type="file" name="file-input" id="file-input" accept="image/*" style="display: none">
                        <button type="button" id="change-photo" name="change-photo">Ngarko Poster</button>
                    </div>
                </div>

                <button type="submit" name="submit">Shto Shfaqje</button>
            </form>

            <div class="info-container">
                <?php
                if (!empty($errors)) {
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

            fetch(`../../../includes/get_genres.php`)
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

    <!-- Sidebar toggle -->
    <script>
        $(document).ready(function () {
            $("#sidebarToggle").on('click', function (e) {
                e.preventDefault();
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
            });
        });
    </script>
    <script src="/biletaria_online/assets/js/flatpickr.min.js"></script>
    <script src="/biletaria_online/assets/js/functions.js"></script>
    <script src="/biletaria_online/assets/js/uploadPicture.js"></script>
</body>

</html>