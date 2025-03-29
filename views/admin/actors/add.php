<?php
require_once '../../../config/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];
    $biography = $_POST['biography'];

    // Read image file as binary data
    $photo = file_get_contents($_FILES['photo']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO actors (name, birthdate, biography, photo) VALUES (?, ?, ?, ?)");
    $full_name = $first_name . ' ' . $last_name;
    $stmt->bind_param("sssb", $full_name, $birthdate, $biography, $null);
    $stmt->send_long_data(3, $photo); // Send BLOB data

    if ($stmt->execute()) {
        echo "<script>alert('Actor added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error adding actor.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Actor</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('../../../assets/img/background-image.png') no-repeat center center/cover;
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: var(--default-font);
            margin: 0;
            padding: 20px;
        }
    </style>
</head>

<body class=" text-gold-400 flex justify-center items-center min-h-screen">
    <div class="form-container" style="max-width: 700px;"">
        <h2 class=" text-2xl font-bold text-center mb-4">Add New Actor</h2>
        <form id="actorForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            <label class="form-group">First Name:
                <input type="text" name="first_name" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="form-group">Last Name:
                <input type="text" name="last_name" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="form-group">Birthdate:
                <input type="date" name="birthdate" class="w-full p-2 bg-gray-700 text-white rounded" required>
            </label>

            <label class="form-group">Biography:
                <textarea name="biography" class="w-full p-2 bg-gray-700 text-white rounded h-40"
                    style="background-color: rgba(228, 228, 228, 0.04);" required></textarea>
            </label>

            <div class="mb-3 text-center">
                <label class="cursor-pointer block" onclick="document.getElementById('photoInput').click()">
                    <img id="photoPreview" class="photo-preview hidden mx-auto w-40 h-40 object-cover rounded-lg"
                        src="#" alt="Preview">
                    <p class="text-sm text-gray-400 mt-2">Click to upload photo</p>
                </label>
                <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" required
                    onchange="previewImage(event)">
            </div>

            <button type="submit" class="w-full bg-gold-500 text-gray-900 py-2 rounded hover:bg-gold-600">Add
                Actor</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('photoPreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>