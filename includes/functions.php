<?php

use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
function sendEmail(string $email, string $subject, string $body): bool {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();

        $mail->Username = $_ENV['SMTP_USER'];
        $mail->Password = $_ENV['SMTP_PASS'];
        $mail->SMTPAuth = true;
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];

        $mail->setFrom($_ENV['SMTP_USER'], "Teatri Metropol");
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $template = $body;

        $mail->Body = $template;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function checkAdmin($conn): bool {

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();

    if ($role !== 'admin') {
        return false;
    }

    return true;
}

function redirectIfNotLoggedIn(): void {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: " . '/biletaria_online/auth/login.php');
        exit;
    }
}

function redirectIfNotAdmin($conn): void {
    if(!checkAdmin($conn)) {
        header("Location: " . '/biletaria_online/auth/no-access.php');
        exit;
    }
}

function groupDates($dates): array {
    if (empty($dates)) return [];

    $grouped = [];
    $start = $end = new DateTime($dates[0]);

    for ($i = 1; $i < count($dates); $i++) {
        $current = new DateTime($dates[$i]);
        $diff = (int)$end->diff($current)->format("%a");

        if ($diff === 1) {
            $end = $current;
        } else {
            $grouped[] = formatDateRange($start, $end);
            $start = $end = $current;
        }
    }

    $grouped[] = formatDateRange($start, $end);
    return $grouped;
}

function formatDateRange($start, $end): string {
    $muajiStart = muajiNeShqip($start->format('M'));
    $muajiEnd = muajiNeShqip($end->format('M'));

    if ($start == $end) {
        return $start->format('j') . " " . $muajiStart;
    } elseif ($muajiStart === $muajiEnd) {
        return $start->format('j') . "-" . $end->format('j') . " " . $muajiStart;
    } else {
        return $start->format('j') . " " . $muajiStart . " - " . $end->format('j') . " " . $muajiEnd;
    }
}

function muajiNeShqip($muajiAnglisht): string {
    $muajt = [
        'Jan' => 'Janar', 'Feb' => 'Shkurt', 'Mar' => 'Mars',
        'Apr' => 'Prill', 'May' => 'Maj', 'Jun' => 'Qershor',
        'Jul' => 'Korrik', 'Aug' => 'Gusht', 'Sep' => 'Shtator',
        'Oct' => 'Tetor', 'Nov' => 'Nëntor', 'Dec' => 'Dhjetor'
    ];
    return $muajt[$muajiAnglisht] ?? $muajiAnglisht;
}

function showError($error): void {
    echo "<!DOCTYPE html>
      <html lang='sq'>
      <head>";
    require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php';
    echo "<title>Teatri Metropol | Mesazh</title>
      <link rel='icon' type='image/x-icon' href='/biletaria_online/assets/img/metropol_icon.png'>
      <link rel='stylesheet' href='/biletaria_online/assets/css/styles.css'>
      <style>
          body {
            background: url('/biletaria_online/assets/img/error.png') no-repeat center center fixed;
            background-size: cover;
            justify-content: center;
          }
      </style>
      </head>
      <body>
      <div class='errors show'>
            <p>$error</p>
      </div>
      </body>
      </html>";
    exit;
}

function isHallAvailable($conn, $hall, $time, $dates, $id): array {
    $placeholders = implode(',', array_fill(0, count($dates), '?'));
    $idCondition = $id !== null ? " AND s.id != ?" : "";

    $sql = "
        SELECT s.time AS existing_start_time, sd.show_date
        FROM show_dates sd
        JOIN shows s ON sd.show_id = s.id
        WHERE s.hall = ? AND sd.show_date IN ($placeholders)$idCondition
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        showError("Një gabim ndodhi! Provoni më vonë!");
    }

    $params = array_merge([$hall], $dates);
    $types = str_repeat('s', 1 + count($dates));

    if ($id !== null) {
        $params[] = $id;
        $types .= 's';
    }

    $bindParams = [];
    $bindParams[] = &$types;
    foreach ($params as $key => $value) {
        $bindParams[] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bindParams);
    $stmt->execute();
    $result = $stmt->get_result();

    $conflicts = [];

    $fixedDurationSeconds = 4 * 60 * 60;
    $newStart = strtotime($time);
    $newEnd = $newStart + $fixedDurationSeconds;

    while ($row = $result->fetch_assoc()) {
        $existingStart = strtotime($row['existing_start_time']);
        $existingEnd = $existingStart + $fixedDurationSeconds;

        if ($newStart < $existingEnd && $newEnd > $existingStart) {
            $conflicts[] = $row['show_date'] . ' nga ora ' . $row['existing_start_time'];
        }
    }

    $stmt->close();

    if (!empty($conflicts)) {
        return [
            'available' => false,
            'conflict_info' => $conflicts
        ];
    }

    $idCondition = $id !== null ? " AND e.id != ?" : "";

    $sql = "
        SELECT e.time AS existing_start_time, ed.event_date
        FROM event_dates ed
        JOIN events e ON ed.event_id = e.id
        WHERE e.hall = ? AND ed.event_date IN ($placeholders)$idCondition
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        showError("Një gabim ndodhi! Provoni më vonë!");
    }

    $params = array_merge([$hall], $dates);
    $types = str_repeat('s', 1 + count($dates));

    if ($id !== null) {
        $params[] = $id;
        $types .= 's';
    }

    $bindParams = [];
    $bindParams[] = &$types;
    foreach ($params as $key => $value) {
        $bindParams[] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bindParams);
    $stmt->execute();
    $result = $stmt->get_result();

    $conflicts = [];

    while ($row = $result->fetch_assoc()) {
        $existingStart = strtotime($row['existing_start_time']);
        $existingEnd = $existingStart + $fixedDurationSeconds;

        if ($newStart < $existingEnd && $newEnd > $existingStart) {
            $conflicts[] = $row['event_date'] . ' nga ora ' . $row['existing_start_time'];
        }
    }

    $stmt->close();

    if (!empty($conflicts)) {
        return [
            'available' => false,
            'conflict_info' => $conflicts
        ];
    }

    return ['available' => true];
}

function deletePoster($conn, $table, $id): bool {

    $allowedTables = ['shows', 'events', 'actors'];
    if (!in_array($table, $allowedTables)) {
        return false;
    }

    $query = "SELECT poster FROM $table WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) return false;

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();

    if (!empty($poster)) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/biletaria_online/assets/img/$table/" . basename($poster);
        if (file_exists($imagePath)) {
            return unlink($imagePath);
        }
    }

    return false;
}

function getPosterPath($conn, $table, $id): string {

    $allowedTables = ['shows', 'events', 'actors'];
    if (!in_array($table, $allowedTables)) {
        return false;
    }

    $query = "SELECT poster FROM $table WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();

    if (!empty($poster)) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . "/biletaria_online/assets/img/$table/" . basename($poster);
        if (file_exists($imagePath)) {
            return $imagePath;
        }
    }

    return "File nuk u gjet!";
}