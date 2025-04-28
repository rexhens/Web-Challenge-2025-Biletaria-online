<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

require_once('../../config/db_connect.php');
$result = $conn->query("SELECT * FROM actors");

// Start building the HTML content
$html = "<html>";
$html .= "<meta charset='UTF-8'>";
$html .= "<head>
<style>
    body { font-family: Arial; }
    h2 { text-align: center; color: #2c3e50; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: center; }
    th { background-color: #2980b9; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
</style>
</head>";
$html .= "<body>";
$html .= "<h2>Raporti i Aktorëve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Emri</th><th>Email</th><th>Datëlindja</th></tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['email']}</td>";
    $html .= "<td>" . date("d-m-Y", strtotime($row['birthdate'])) . "</td>";
    $html .= "</tr>";
}

$html .= "</table>";
$html .= "</body>";
$html .= "</html>";

// Instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (force download)
$dompdf->stream("raporti_aktoreve.pdf", ["Attachment" => true]);
ob_end_flush();
?>