<?php
require_once '../../../config/db_connect.php';

// Check if the ID is set and valid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Show ID is missing.");
}

$show_id = intval($_GET['id']);

// Fetch show details
$query = "SELECT * FROM shows WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("i", $show_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: No show found with the given ID.");
}

// Fetch actors
$actorsResult = null;
$actorsQuery = "SELECT a.* FROM actors a 
                    JOIN show_actors sa ON a.id = sa.actor_id 
                    WHERE sa.show_id = ?";
$stmtActors = $conn->prepare($actorsQuery);

if ($stmtActors === false) {
    die("Error preparing the actors query: " . $conn->error);
}

$stmtActors->bind_param("i", $show_id);
$stmtActors->execute();
$actorsResult = $stmtActors->get_result();

// If the query was successful, the variables should be populated
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['title']); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: url('../assets/img/background-image.png') no-repeat center center/cover;
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: var(--default-font);
            margin: 0;
            padding: 20px;
            transition: background-color 0.5s ease-in-out;
            box-sizing: border-box;
            overflow-x: hidden;
            padding-left: 100px;
        }

        .show-container {
            display: grid;
            grid-template-columns: 500px 1fr;
            gap: 100px;
            justify-items: start;
            align-items: flex-start;
            margin-top: 20px;
            max-width: 100%;
            width: 100%;
            height: 1000px;
            box-sizing: border-box;
            overflow: hidden;
            min-height: 600px;
            /* Ensure the container has a minimum height */
        }

        h1 {
            text-align: center;
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .show-poster img {
            width: 500px;
            height: 750px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(255, 255, 255, 0.2);
            transition: var(--transition);
        }

        .show-content {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            max-width: 600px;
        }

        .show-content p {
            font-size: large;
            color: white;
            margin-bottom: 10px;
        }

        .show-content a {
            display: block;
            padding: 15px 30px;
            background: var(--accent-color);
            color: #000;
            font-size: 1.2rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: var(--transition);
            margin-top: 20px;
        }

        .show-content a:hover {
            background: #a8904e;
            transform: scale(1.05);
        }

        /* Actors Section - Center actors */
        .actors-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
            justify-items: center;
            /* Center the actor cards */
            justify-content: center;
            /* Ensure the entire list is centered */
            max-width: 100%;
            padding: 0 10px;
            /* Add some padding to the left and right */
        }

        /* Ensure actors are centered and don't overlap */
        .actor-card {
            background: var(--card-bg);
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 5px 15px rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            transform: translateY(0);
        }

        .actor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 20px rgba(255, 255, 255, 0.2);
        }

        .actor-card img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .actor-card img:hover {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .show-container {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .actor-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>
    <h1><?php echo htmlspecialchars($row['title']); ?></h1>

    <div class="show-container">
        <!-- Poster Section (Left) -->
        <div class="show-poster">
            <img src="client/shows/get_image.php?id=<?php echo $row['id']; ?>" alt="Poster">
        </div>

        <!-- Description and Actors Section (Right) -->
        <div class="show-content">
            <p><strong>Pershkrim:</strong> <?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
            <a style="display:'block'" href="reserve.php?id=<?php echo $row['id']; ?>" class="btn-reserve">Rezervo
                Tani</a>
        </div>

    </div>

    <h2>Aktorët:</h2>
    <div class="actors-list">
        <?php if ($actorsResult && $actorsResult->num_rows > 0): ?>
            <?php while ($actor = $actorsResult->fetch_assoc()): ?>
                <div class="actor-card">
                    <img src="client/shows/get_image.php?id=<?php echo $actor['id']; ?>"
                        alt="<?php echo htmlspecialchars($actor['name']); ?>">
                    <h4><?php echo htmlspecialchars($actor['name']); ?></h4>
                    <p>I lindur me: <?php echo htmlspecialchars($actor['birthdate']); ?></p>
                    <p>Pak biografi: <?php echo htmlspecialchars($actor['biography']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nuk ka aktorë të listuar për këtë shfaqje.</p>
        <?php endif; ?>

    </div>
</body>

</html>