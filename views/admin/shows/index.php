<?php
require_once '../../../config/db_connect.php';

$query = 'SELECT * FROM shows ORDER BY start_date DESC';
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container">
        <a href="./add.php">Add a new show</a>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="show-card">
                    <img class="poster" src="get_image.php?id=<?php echo $row['id']; ?>" alt="Show Poster">
                    <div class="show-info">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="dates">
                            <?php
                            $start_date = date('d M Y', strtotime($row['start_date']));
                            $end_date = date('d M Y', strtotime($row['end_date']));
                            echo $start_date === $end_date ? $start_date : "$start_date - $end_date";
                            ?>
                        </p>
                        <a href="show_details.php?id=<?php echo $row['id']; ?>" class="read-more">Lexo më shumë</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No shows available at the moment.</p>";
        }
        ?>
    </div>
</body>

</html>