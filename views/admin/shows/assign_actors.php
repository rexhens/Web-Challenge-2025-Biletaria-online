<?php
require_once '../../../config/db_connect.php';

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
</head>

<body class="bg-gray-900 text-white flex flex-col justify-center items-center min-h-screen">
    <div class="w-full max-w-4xl p-6 bg-gray-800 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4">Assign Actors to Show</h2>

        <form id="assignActorsForm" action="save_show_actors.php" method="POST">
            <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php foreach ($actors as $actor): ?>
                    <div class="actor-card bg-gray-700 p-4 rounded-lg text-center cursor-pointer transition duration-300 hover:bg-gold-500"
                        data-id="<?php echo $actor['id']; ?>">
                        <img class="w-24 h-24 mx-auto rounded-full object-cover"
                            src="data:image/jpeg;base64,<?php echo base64_encode($actor['photo']); ?>"
                            alt="<?php echo $actor['name']; ?>">
                        <p class="mt-2 font-semibold"><?php echo $actor['name']; ?></p>
                        <input type="checkbox" name="actor_ids[]" value="<?php echo $actor['id']; ?>" class="hidden">
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="w-full bg-gold-500 text-gray-900 py-2 mt-4 rounded hover:bg-gold-600">
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