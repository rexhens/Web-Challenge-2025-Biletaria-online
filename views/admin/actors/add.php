<?php
require_once '../../../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] . $_POST['surname'];
    $birthdate = $_POST['birthdate'];
    $biography = $_POST['biography'];

    // Check if file is uploaded
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] != 0) {
        die("Error: No file uploaded or file upload error.");
    }

    // Read the image as binary data
    $image = file_get_contents($_FILES['photo']['tmp_name']);

    // Fix the SQL query by correctly adding 4 values
    $sql = "INSERT INTO actors (name, birthdate, biography, photo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssb", $name, $birthdate, $biography, $null);
    $stmt->send_long_data(3, $image); // Send BLOB data

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect to actors list
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Actor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./add.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control,
        textarea {
            height: 45px;
            font-size: 16px;
        }

        .form-control:focus,
        textarea:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        .photo-upload {
            border: 2px dashed #007bff;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
            font-size: 18px;
        }

        .photo-upload:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        .photo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 15px auto;
        }

        button {
            font-size: 18px;
            padding: 12px;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2 class="text-center mb-4">Shto nje aktor te ri ne teatrin Metropol</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Emri</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mbiemri</label>
                <input type="text" name="surname" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Data e lindjes</label>
                <input type="date" name="birthdate" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Biografia</label>
                <textarea name="biography" class="form-control" style=" height: 120px; " rows="10" required></textarea>
            </div>


            <div class="mb-3 text-center">
                <label class="photo-upload" onclick="document.getElementById('photoInput').click()">
                    <img id="photoPreview" class="photo-preview d-none" src="#" alt="Preview">
                    <p>Kliko per te shkarkuar foto</p>
                </label>
                <input type="file" id="photoInput" name="photo" accept="image/*" class="d-none" required
                    onchange="previewImage(event)">
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Actor</button>
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
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>