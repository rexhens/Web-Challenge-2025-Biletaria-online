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
    @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap');

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
      background-color: var(--background-color);
      color: var(--text-color);
      font-family: var(--default-font);
      margin: 0;
      padding: 20px;
    }

    .shows-container {
      max-width: 1200px;
      margin: auto;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    h1 {
      font-size: 2.5rem;
      color: var(--heading-color);
      font-family: var(--heading-font);
      margin: 0;
    }

    .add-show-btn {
      background: var(--accent-color);
      color: black;
      padding: 12px 20px;
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
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
    }

    .show-card {
      position: relative;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.7);
      height: 500px; /* Bigger card height */
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      background-size: cover;
      background-position: center;
      transition: transform 0.3s ease;
    }

    .show-card:hover {
      transform: scale(1.02);
    }

    .show-overlay {
      background: rgba(0, 0, 0, 0.6);
      padding: 20px;
      color: var(--text-color);
    }

    .show-overlay h3 {
      font-family: var(--heading-font);
      color: var(--heading2-color);
      margin: 0 0 10px;
      font-size: 1.8rem;
    }

    .show-dates {
      font-size: 0.95rem;
      margin-bottom: 10px;
    }

    .show-description {
      font-size: 0.9rem;
      margin-bottom: 15px;
      max-height: 60px;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .btn-group {
      display: flex;
      justify-content: flex-start;
      gap: 15px;
    }

    .btn {
      text-decoration: none;
      padding: 10px 15px;
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
      opacity: 0.9;
    }

    .no-shows {
      text-align: center;
      font-size: 1.2rem;
      color: var(--surface-color);
    }
    .btn{
    padding: 10px;
    font-family: "Quicksand", sans-serif;
    font-size: 17px;
    color: var(--text-color);
    border: none;
    border-bottom: 2px solid rgb(143, 121, 63, 0.5);
    outline: none;
    background: none;
    background-color: #836e4f;
    font-weight: 300;
    
    }
  </style>
</head>
<body>
  <div class="shows-container">
    <header>
      <h1>Upcoming Shows</h1>
      <a href="./add.php" class="btn">+ Add New Show</a>
    </header>
    <div class="shows-grid">
      <?php if ($result->num_rows > 0) { while ($row = $result->fetch_assoc()) { 
          // Create the URL for the poster image.
          $posterUrl = "get_image.php?id=" . $row['id'];
          // Dates
          $start_date = date('d M Y', strtotime($row['start_date']));
          $end_date = date('d M Y', strtotime($row['end_date']));
          $dates = $start_date === $end_date ? $start_date : "$start_date - $end_date";
      ?>
        <div class="show-card" style="background-image: url('<?php echo $posterUrl; ?>');">
          <div class="show-overlay">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p class="show-dates"><?php echo $dates; ?></p>
            <p class="show-description"><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="btn-group">
              <a href="show_details.php?id=<?php echo $row['id']; ?>" class="btn">More Info</a>
              <a href="reserve.php?show_id=<?php echo $row['id']; ?>" class="btn reserve">Reserve</a>
            </div>
          </div>
        </div>
      <?php } } else { echo "<p class='no-shows'>No shows available at the moment.</p>"; } ?>
    </div>
  </div>
</body>
</html>
