<?php
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

require_once('../../config/db_connect.php');
$revenueStmt = $conn->prepare("
    SELECT 
        MONTH(created_at) AS month, 
        SUM(total_price) AS revenue
    FROM reservations
    WHERE paid = 1 AND YEAR(created_at) = YEAR(CURRENT_DATE())
    GROUP BY MONTH(created_at)
    ORDER BY month
");

$revenueStmt->execute();
$revenueResult = $revenueStmt->get_result();

$monthlyRevenues = array_fill(1, 12, 0); // fill months with zero revenue

while ($row = $revenueResult->fetch_assoc()) {
    $monthlyRevenues[(int) $row['month']] = (float) $row['revenue'];
}
$months = [
    1 => 'Janar',
    2 => 'Shkurt',
    3 => 'Mars',
    4 => 'Prill',
    5 => 'Maj',
    6 => 'Qershor',
    7 => 'Korrik',
    8 => 'Gusht',
    9 => 'Shtator',
    10 => 'Tetor',
    11 => 'Nëntor',
    12 => 'Dhjetor'
];

// Get today's date
$today = date('d-m-Y');

// Start building the HTML
$html = "<html>";
$html .= "<meta charset='UTF-8'>";
$html .= "<head>
<style>
    body { font-family: Arial; }
    h1, h2 { text-align: center; color: #2c3e50; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: center; vertical-align: top; }
    th { background-color: #8f793f; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
    .section { margin-top: 50px; }
    .description {
        display: -webkit-box;
        -webkit-line-clamp: 10;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-align: left;
    }
    .info-section {
        margin-bottom: 40px;
        text-align: center;
        font-size: 16px;
    }
</style>
</head>";
$html .= "<body>";

// General Info Section
$html .= "<div class='info-section'>";
$html .= "<h1>Raport i Përgjithshëm</h1>";
$html .= "<p>Data e gjenerimit: <strong>{$today}</strong></p>";
$html .= "<p>Ky raport përmban informacion mbi aktorët, përdoruesit, shfaqjet dhe eventet aktuale.</p>";
$html .= "</div>";



$html .= "<div class='section'>";
$html .= "<h2>Raporti i të Ardhurave Mujore</h2>";
$html .= "<table>";
$html .= "<tr><th>Muaji</th><th>Të Ardhurat (LEK)</th></tr>";

foreach ($monthlyRevenues as $month => $revenue) {
    $monthName = $months[$month];
    $html .= "<tr><td>{$monthName}</td><td>" . number_format($revenue, 2) . "</td></tr>";
}

$html .= "</table>";
$html .= "</div>";



//////////////////////////
// Users Section
//////////////////////////
$result = $conn->query("SELECT * FROM users");
$html .= "<div class='section'>";
$html .= "<h2>Raporti i Përdoruesve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Emri</th><th>Mbiemri</th><th>Email</th><th>Telefoni</th><th>Roli</th><th>Statusi</th></tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['surname']}</td>";
    $html .= "<td>{$row['email']}</td>";
    $html .= "<td>{$row['phone']}</td>";
    $html .= "<td>{$row['role']}</td>";
    $html .= "<td>{$row['status']}</td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</div>";

//////////////////////////  
// Reservations Section
//////////////////////////


$result = $conn->query("SELECT * FROM reservations");

$html .= "<div class='section'>";
$html .= "<h2>Raporti i Rezervimeve</h2>";
$html .= "<table>";
$html .= "<tr>
    <th>ID</th><th>Emri i plotë</th><th>Telefoni</th>
    <th>Data</th><th>Salla</th><th>Skena</th><th>Data e shfaqjes</th>
    <th>Ora e shfaqjes</th><th>Çmimi Total</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    $date = date("d-m-Y", strtotime($row['date']));
    $showDate = date("d-m-Y", strtotime($row['show_date']));
    $html .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['full_name']}</td>
        <td>{$row['phone']}</td>
        <td>{$date}</td>
        <td>{$row['hall']}</td>
        <td>{$row['seat_id']}</td>
        <td>{$showDate}</td>
        <td>{$row['show_time']}</td>
        <td>" . number_format($row['total_price'], 2) . "</td>
    </tr>";
}

$html .= "</table>";
$html .= "</div>";


//////////////////////////
// Reviews Section
//////////////////////////
$result = $conn->query("
    SELECT 
        reviews.id,
        reviews.email,
        reviews.rating,
        reviews.comment,
        reviews.date,
        shows.title AS show_title,
        events.title AS event_title
    FROM reviews
    LEFT JOIN shows ON reviews.show_id = shows.id
    LEFT JOIN events ON reviews.event_id = events.id
");

$html .= "<div class='section'>";
$html .= "<h2>Raporti i Komenteve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Email</th><th>Shfaqja</th><th>Eventi</th><th>Vlerësimi</th><th>Komenti</th><th>Data</th></tr>";

while ($row = $result->fetch_assoc()) {
    $date = date("d-m-Y", strtotime($row['date']));
    $comment = htmlspecialchars($row['comment']);
    $showTitle = $row['show_title'] ?? '-';
    $eventTitle = $row['event_title'] ?? '-';

    $html .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['email']}</td>
        <td>{$showTitle}</td>
        <td>{$eventTitle}</td>
        <td>{$row['rating']}</td>
        <td><div class='description'>{$comment}</div></td>
        <td>{$date}</td>
    </tr>";
}

$html .= "</table>";
$html .= "</div>";




//////////////////////////
// Actors Section
//////////////////////////
$result = $conn->query("SELECT * FROM actors");
$html .= "<div class='section'>";
$html .= "<h2>Raporti i Aktorëve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Emri</th><th>Email</th><th>Datëlindja</th></tr>";

while ($row = $result->fetch_assoc()) {
    $birthdate = $row['birthday'] ? date("d-m-Y", strtotime($row['birthday'])) : '-';
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['name']}</td>";
    $html .= "<td>{$row['email']}</td>";
    $html .= "<td>{$birthdate}</td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</div>";



//////////////////////////
// Shows Section
//////////////////////////
$result = $conn->query("
    SELECT shows.*, genres.genre_name 
    FROM shows 
    LEFT JOIN genres ON shows.genre_id = genres.id
");

$html .= "<div class='section'>";
$html .= "<h2>Raporti i Shfaqjeve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Titulli</th><th>Përshkrimi</th><th>Ora</th><th>Salla</th><th>Zhanri</th><th>Çmimi</th></tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['title']}</td>";
    $html .= "<td><div class='description'>{$row['description']}</div></td>";
    $html .= "<td>{$row['time']}</td>";
    $html .= "<td>{$row['hall']}</td>";
    $html .= "<td>{$row['genre_name']}</td>";
    $html .= "<td>{$row['price']}</td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</div>";

//////////////////////////
// Events Section
//////////////////////////
$result = $conn->query("SELECT * FROM events");

$html .= "<div class='section'>";
$html .= "<h2>Raporti i Eventeve</h2>";
$html .= "<table>";
$html .= "<tr><th>ID</th><th>Titulli</th><th>Përshkrimi</th><th>Salla</th><th>Ora</th><th>Çmimi</th></tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>";
    $html .= "<td>{$row['id']}</td>";
    $html .= "<td>{$row['title']}</td>";
    $html .= "<td><div class='description'>{$row['description']}</div></td>";
    $html .= "<td>{$row['hall']}</td>";
    $html .= "<td>{$row['time']}</td>";
    $html .= "<td>{$row['price']}</td>";
    $html .= "</tr>";
}
$html .= "</table>";
$html .= "</div>";

$html .= "</body>";
$html .= "</html>";

// Create the PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


// Get current month in Albanian
$monthNumber = date('n'); // 1-12
$months = [
    1 => 'Janar',
    2 => 'Shkurt',
    3 => 'Mars',
    4 => 'Prill',
    5 => 'Maj',
    6 => 'Qershor',
    7 => 'Korrik',
    8 => 'Gusht',
    9 => 'Shtator',
    10 => 'Tetor',
    11 => 'Nëntor',
    12 => 'Dhjetor'
];
$currentMonth = $months[$monthNumber];


// Stream the file to browser
$dompdf->stream("raporti_per_muajin_{$currentMonth}.pdf", ["Attachment" => true]);

ob_end_flush();
?>