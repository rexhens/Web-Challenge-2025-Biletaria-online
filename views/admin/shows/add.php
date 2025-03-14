<?php
require_once '../connections/db_connect.php';

$result = $conn->query("SELECT * FROM shows");

if ($result->num_rows > 0) {
    echo "<div class='big-container'>";

    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="show-card">
            <img src="get_image.php?id=<?php echo $row['id']; ?>" alt="Show Poster" class="poster">

            <!-- Title Overlay -->
            <div class="show-info">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <a href="show_details.php?id=<?php echo $row['id']; ?>" class="read-more">Lexo më shumë</a>
            </div>
        </div>
        <?php
    }

    echo "</div>";
} else {
    echo "<p>No shows found.</p>";
}

$conn->close();
?>