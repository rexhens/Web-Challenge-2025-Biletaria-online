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

    <style>
        :root {
            --default-font: "Quicksand", sans-serif;
            --heading-font: "Russo One", sans-serif;
            --nav-font: "Afacad Flux", sans-serif;

            --background-color: #1B1B1B;
            --default-color: #785E5B;
            --heading2-color: #836e4f;
            --heading-color: #7C8598;
            --accent2-color: rgb(130, 152, 145);
            --accent-color: #8f793f;
            --surface-color: #c8bbb3;
            --text-color: #E4E4E4;
            --error-color: #f44336;
            --success-color: rgba(131, 173, 68);
        }

        body {
             background: url('../../../assets/img/background-image.png') no-repeat center center/cover;
            color: var(--text-color);
            font-family: var(--default-font);
            margin: 0;
            padding: 0;
        }

        .shows-container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2rem;
            color: var(--heading-color);
            font-family: var(--heading-font);
        }

        .add-show-btn {
            background: var(--accent-color);
            color: black;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .add-show-btn:hover {
            background: #75612b;
        }

        .shows-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .show-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            background: rgba(228, 228, 228, 0.04);
            backdrop-filter: blur(5px);
            padding: 20px;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.5);
        }

        .show-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .show-content h3 {
            font-family: var(--heading-font);
            color: var(--heading2-color);
        }

        .show-dates {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .btn.info {
            background: var(--accent-color);
            color: black;
        }

        .btn.reserve {
            background: black;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
        }

        .btn:hover {
            opacity: 0.8;
        }

        .no-shows {
            text-align: center;
            font-size: 1.2rem;
            color: var(--surface-color);
        }
    </style>
</head>
<body>
    <div class="shows-container">
        <header>
            <h1>Upcoming Shows</h1>
            <a href="./add.php" class="add-show-btn">+ Add New Show</a>
        </header>
        <div class="shows-grid">
            <?php if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { ?>
                <div class="show-item">
                    <img class="show-img" src="get_image.php?id=<?php echo $row['id']; ?>" alt="Show Poster">
                    <div class="show-content">
                        <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="show-dates">
                            <?php
                            $start_date = date('d M Y', strtotime($row['start_date']));
                            $end_date = date('d M Y', strtotime($row['end_date']));
                            echo $start_date === $end_date ? $start_date : "$start_date - $end_date";
                            ?>
                        </p>
                        <p class="show-description"> <?php echo htmlspecialchars($row['description']); ?> </p>
                        <div class="btn-group">
                            <a href="show_details.php?id=<?php echo $row['id']; ?>" class="btn info">More Info</a>
                            <a href="reserve.php?id=<?php echo $row['id']; ?>" class="btn reserve">Reserve</a>
                        </div>
                    </div>
                </div>
            <?php } } else { echo "<p class='no-shows'>No shows available at the moment.</p>"; } ?>
        </div>
    </div>
</body>
</html>