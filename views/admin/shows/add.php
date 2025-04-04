<?php
/** @var mysqli $conn */
require "../../../config/db_connect.php";
session_start();
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $hall = $_POST["hall"];
    $genre_id = $_POST["select-genre"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $time = $_POST["time"];
    $description = $_POST["description"];
    $trailer = $_POST["trailer"];

    // Check if a file was uploaded
    if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == 0) {
        $poster = file_get_contents($_FILES["poster"]["tmp_name"]); // Read file content
    } else {
        $poster = null; // No file uploaded
    }

    // Prepare SQL query
    $sql = "INSERT INTO shows (title, hall, genre_id, start_date, end_date, time, description, poster1, trailer) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssissssbs", $title, $hall, $genre_id, $start_date, $end_date, $time, $description, $poster, $trailer);
        $stmt->send_long_data(6, $poster);
        if ($stmt->execute()) {
            $show_id = $conn->insert_id; // Get the last inserted ID
            // Redirect after successful insert
            header("Location: assign_actors.php?show_id=" . $show_id);
            exit();
        } else {
            $error_message = "Error adding show: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Database error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../../../includes/links.php'; ?>
    <meta property="og:image" content="../../../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../../../assets/img/metropol_icon.png">
    <title>Metropol Ticketing | Shto Shfaqe</title>
    <link rel="stylesheet" href="../../../assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <style>
        body {
            background: url('../../../assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
            justify-content: flex-start;
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
<form id="showForm" method="POST" enctype="multipart/form-data" class="form-container">
    <h1>Shtoni një shfaqje në <br>
        <span>Teatrin Metropol</span>
    </h1>
    <input type="hidden" id="id" name="id">

    <div class="form-group">
        <input type="text" name="title" id="title" placeholder=" " required>
        <label for="title">Titulli</label>
    </div>

    <div class="form-group">
        <input type="text" name="hall" id="hall" placeholder=" " required>
        <label for="hall">Salla</label>
    </div>

    <div class="form-group">
        <select name="select-genre" id="select-genre">
            <option value="" disabled selected>-- Zgjidhni zhanrin --</option>
        </select>
    </div>

    <div class="form-group">
        <input type="text" name="start_date" id="start_date" placeholder=" " required>
        <label for="start_date">Data e fillimit</label>
    </div>

    <div class="form-group">
        <input type="text" name="end_date" id="end_date" placeholder=" " required>
        <label for="end_date">Data e mbarimit</label>
    </div>

    <div class="form-group">
        <textarea name="description" id="description" placeholder="Përshkrimi i shfaqjes..." required></textarea>
    </div>



    <div class="mb-3 text-center">
        <label class="cursor-pointer block" onclick="document.getElementById('posterInput').click()">
            <img id="posterPreview" class="photo-preview hidden mx-auto w-40 h-40 object-cover rounded-lg"
                 src="#" alt="Preview">
            <p class="text-sm text-gray-400 mt-2">Click to upload photo</p>
        </label>
        <input type="file" name="poster" id="posterInput" accept="image/*" class="hidden" required
               onchange="previewImage(event)">
    </div>

    <button type="submit" class="w-full bg-gold-500 text-gray-900 py-2 rounded hover:bg-gold-600">Add
        Show</button>
</form>

<?php if (isset($error_message)): ?>
    <div class="mt-4 text-red-500"><?php echo $error_message; ?></div>
<?php endif; ?>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('posterPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const genreSelect = document.getElementById("select-genre");

            fetch(`../genres/get_genres.php`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((genres) => {
                    genreSelect.innerHTML = '<option value="">-- Zgjidhni zhanrin --</option>';
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

<script src="../../../assets/js/flatpickr.min.js"></script>
<script src="../../../assets/js/functions.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#start_date", {
            dateFormat: "d/m/Y",
            disableMobile: true
        });
        flatpickr("#end_date", {
            dateFormat: "d/m/Y",
            disableMobile: true
        });
    });
</script>
</body>
</html>