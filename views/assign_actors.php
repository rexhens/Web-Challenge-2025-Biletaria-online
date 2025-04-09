<?php
require_once '../config/db_connect.php';

// Get the show ID from the URL
if (!isset($_GET['show_id']) || empty($_GET['show_id'])) {
    die("Invalid request. No show ID provided.");
}

$show_id = intval($_GET['show_id']);

// Fetch all available actors
$sql = "SELECT * FROM actors";
$result = $conn->query($sql);
$actors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $actors[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Actors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">

    <style>
        body {
            background: url('../assets/img/background-image.png') no-repeat center center/cover;
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: var(--default-font);
            margin: 0;
            padding: 20px;
        }

        button {
            font-family: var(--default-font);
            font-size: 20px;
            color: var(--surface-color);
            padding: 10px;
            width: 180px;
            border: none;
            border-radius: 10px;
            background-image: linear-gradient(to bottom, var(--heading2-color), var(--accent-color));
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(70px);
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        button:hover {
            cursor: pointer;
            background-image: linear-gradient(to bottom, var(--accent-color), #75612b);
            backdrop-filter: blur(80px);
        }

        button:active {
            transform: scale(0.95);
        }
    </style>
</head>

<body class="bg-gray-900 text-white flex flex-col justify-center items-center min-h-screen">
    <div class="w-full max-w-4xl p-6  rounded-lg shadow-lg" style="background-color: rgba(228, 228, 228, 0.04)">
        <h2 class=" text-2xl font-bold text-center mb-4">Assign Actors to Show</h2>

        <form id="assignActorsForm" action="admin/shows/save_show_actors.php" method="POST">
            <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php foreach ($actors as $actor): ?>
                    <div class="actor-card p-4 rounded-lg text-center cursor-pointer transition duration-300 hover:bg-gold-500"
                        style="background-color: rgba(228, 228, 228, 0.04);" data-id="<?php echo $actor['id']; ?>">
                        <img class="w-24 h-24 mx-auto rounded-full object-cover"
                            src="data:image/jpeg;base64,<?php echo base64_encode($actor['photo']); ?>"
                            alt="<?php echo $actor['name']; ?>">
                        <p class="mt-2 font-semibold"><?php echo $actor['name']; ?></p>
                        <input type="checkbox" name="actor_ids[]" value="<?php echo $actor['id']; ?>" class="hidden">
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="w-full bg-gold-500  py-2 mt-4 rounded hover:bg-gold-600" id="login"
                style="background-color='#8f793f'">
                Assign Actors
            </button>
        </form>
    </div>

    <script>
        document.querySelectorAll(".actor-card").forEach(card => {
            card.addEventListener("click", function () {
                const checkbox = this.querySelector("input[type='checkbox']");
                checkbox.checked = !checkbox.checked;

                // Add border when selected
                this.classList.toggle("border-4", checkbox.checked); // Add border when selected
                this.classList.toggle("border-gold-500", checkbox.checked); // Gold border when selected
                this.classList.toggle("border-transparent", !checkbox.checked); // Remove border when unselected
            });
        });
    </script>
</body>

</html>