<?php
require_once '../../../config/db_connect.php';

// Ensure an ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No actor ID provided.");
}

$actor_id = intval($_GET['id']);

// Fetch actor details from the database
$sql = "SELECT * FROM actors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $actor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $actor = $result->fetch_assoc();
} else {
    die("Actor not found.");
}

// Handle form submission for updating actor details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $name = $first_name . ' ' . $last_name;
    $birthdate = $_POST['birthdate'];
    $biography = $_POST['biography'];

    // Check if a new photo is uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $image = file_get_contents($_FILES['photo']['tmp_name']);
        $sql = "UPDATE actors SET name = ?, birthdate = ?, biography = ?, photo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssbi", $name, $birthdate, $biography, $null, $actor_id);
        $stmt->send_long_data(3, $image);
    } else {
        // Update without changing the photo
        $sql = "UPDATE actors SET name = ?, birthdate = ?, biography = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $birthdate, $biography, $actor_id);
    }

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect after successful update
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
    <title>Edit Actor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gold-400 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-lg p-6 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Edit Actor Details</h2>
        <form id="actorForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo $actor['id']; ?>">

            <label class="block">First Name:
                <input type="text" name="first_name" class="w-full p-2 bg-gray-700 text-white rounded"
                    value="<?php echo explode(' ', $actor['name'])[0]; ?>" required>
            </label>

            <label class="block">Last Name:
                <input type="text" name="last_name" class="w-full p-2 bg-gray-700 text-white rounded"
                    value="<?php echo explode(' ', $actor['name'])[1]; ?>" required>
            </label>

            <label class="block">Birthdate:
                <input type="date" name="birthdate" class="w-full p-2 bg-gray-700 text-white rounded"
                    value="<?php echo $actor['birthdate']; ?>" required>
            </label>

            <label class="block">Biography:
                <textarea name="biography" class="w-full p-2 bg-gray-700 text-white rounded h-40"
                    required><?php echo $actor['biography']; ?></textarea>
            </label>

            <div class="mb-3 text-center">
                <label class="cursor-pointer block" onclick="document.getElementById('photoInput').click()">
                    <?php if (!empty($actor['photo'])): ?>
                        <img id="photoPreview" class="mx-auto w-40 h-40 object-cover rounded-lg"
                            src="data:image/jpeg;base64,<?php echo base64_encode($actor['photo']); ?>" alt="Preview">
                    <?php else: ?>
                        <p class="text-sm text-gray-400 mt-2">Click to upload photo</p>
                    <?php endif; ?>
                </label>
                <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden"
                    onchange="previewImage(event)">
            </div>

            <button type="submit" class="w-full bg-gold-500 text-gray-900 py-2 rounded hover:bg-gold-600">Update
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