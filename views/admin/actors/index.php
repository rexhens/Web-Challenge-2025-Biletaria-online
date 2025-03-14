<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./index.css">
    <title>Actors Page</title>

</head>

<body>
    <?php
    require_once '../config/db_connect.php';

    $result = $conn->query('SELECT * FROM actors');

    if ($result->num_rows > 0) {
        echo "<div class='big-container'>";

        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <div class="image">
                    <img src="get_image.php?id=<?php echo $row['id']; ?>" alt="Actor Image">
                </div>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <a href="../shows/index.php" class="view-shows">
                    Shiko shfaqjet
                </a>

                <!-- Biography Overlay (Initially Hidden) -->
                <div class="biography-overlay">
                    <p><?php echo htmlspecialchars($row['biography']); ?></p>
                </div>
            </div>

            <?php
        }

        echo "</div>";
    } else {
        echo "No actors found.";
    }
    ?>
</body>

</html>