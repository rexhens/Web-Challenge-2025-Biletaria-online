<?php 
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=raport.doc");

echo "<html>";
echo "<meta charset='UTF-8'>";
echo "<head>
<style>
    body { font-family: Arial; }
    h2 { text-align: center; color: #2c3e50; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: center; }
    th { background-color: #2980b9; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
</style>
</head>";
echo "<body>";
echo "<h2>Raporti i Aktorëve</h2>";
echo "<table>";
echo "<tr><th>ID</th><th>Emri</th><th>Email</th><th>Datëlindja</th></tr>";

require_once('../../config/db_connect.php');
$result = $conn->query("SELECT * FROM actors");

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>" . date("d-m-Y", strtotime($row['birthdate'])) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</body>";
echo "</html>";
?>