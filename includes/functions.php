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
function sendEmail(string $email, string $subject, string $title, string $body, string $link): bool {
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

        $mail->Body = emailTemplate($title, $body, $link);

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function emailTemplate(string $title, string $body, string $link): string {
    $linkHtml = '';
    if ($link) {
        $linkHtml = <<<HTML
<tr>
    <td>
        <p style="text-align: center; margin-bottom: 30px; margin-top: -30px;">
            <a style="padding: 15px 30px; text-decoration: none; font-size: 16px; background-color: #836e4f; border-radius: 3px; color: #E4E4E4;" href="$link">Kliko këtu</a>
        </p>
    </td>
</tr>
HTML;
    }

    return <<<HTML
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 30px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; font-family: Arial, sans-serif;">
                <tr>
                    <td style="background-color: #222; padding: 20px; text-align: center;">
                        <div style="display: flex; align-items: center; justify-content: center; color: #ffffff; font-family: Arial, sans-serif; width: 600px; height: 100%;">
                            <img src="http://teatrimetropol.al/wp-content/themes/metropol/img/logo-white.png" alt="Logo" style="width: 50px; height: auto; margin-right: 20px;">
                            <h1 style="font-size: 24px;">
                                Teatri <span style="color: #836e4f;">Metropol</span>
                            </h1>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 30px; height: 300px;">
                        <h2 style="color: #836e4f; font-size: 30px">$title</h2>
                        <p style="font-size: 20px; color: #333333;">$body</p>
                    </td>
                </tr>
                $linkHtml
                <tr>
                    <td>
                        <p style="font-size: 16px; margin-bottom: 20px; color: #777; text-align: center;">
                            Ju mirëpresim në Teatrin Metropol – Shtëpinë e Artit dhe Dialogut!
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #c8bbb3; text-align: center; padding: 20px; font-size: 13px; color: #555;">
                        Teatri Metropol, Tirana<br>
                        <a href="https://www.teatrimetropol.al" style="color: #8f793f; text-decoration: none;">www.teatrimetropol.al</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
HTML;
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

function checkTicketOffice($conn): bool {

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($role);
    $stmt->fetch();

    if ($role !== 'ticketOffice') {
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

function redirectIfNotAdminOrTicketOffice($conn): void {
    if(!checkAdmin($conn) && !checkTicketOffice($conn)) {
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

function ditaNeShqip($ditaAnglisht): string {
    $dita = [
        'Monday'    => 'E Hënë',
        'Tuesday'   => 'E Martë',
        'Wednesday' => 'E Mërkurë',
        'Thursday'  => 'E Enjte',
        'Friday'    => 'E Premte',
        'Saturday'  => 'E Shtunë',
        'Sunday'    => 'E Diel',
    ];
    return $dita[$ditaAnglisht] ?? $ditaAnglisht;
}

function showError($error): void {
    echo "<!DOCTYPE html>
      <html lang='sq'>
      <head>";
    require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php';
    echo "<title>Teatri Metropol | Error</title>
      <link rel='icon' type='image/x-icon' href='/biletaria_online/assets/img/metropol_icon.png'>
      <link rel='stylesheet' href='/biletaria_online/assets/css/styles.css'>
      <style>
          body {
            background: url('/biletaria_online/assets/img/error.png') no-repeat center center fixed;
            background-size: cover;
            justify-content: center !important;
          }
      </style>
      </head>
      <body>
      <div class='errors show'>
            $error
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

function customError($error): void {
    echo "<!DOCTYPE html>
      <html lang='sq'>
      <head>";
    require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php';
    echo "<title>Teatri Metropol | Error</title>
      <link rel='icon' type='image/x-icon' href='/biletaria_online/assets/img/metropol_icon.png'>
      <link rel='stylesheet' href='/biletaria_online/assets/css/styles.css'>
      <style>
          body {
            background: url('/biletaria_online/assets/img/error.png') no-repeat center center fixed;
            background-size: cover;
            justify-content: center !important;
          }
      </style>
      </head>
      <body>
      <div class='errors show' style='width: 90% !important; background-color: transparent !important; display: flex !important; flex-direction: column; align-items: center; justify-content: center; box-shadow: revert !important;'>
            $error
      </div>
      </body>
      </html>";
    exit;
}

function countOnlineReservations(mysqli $conn): int {
    $sql = "
        SELECT COUNT(*) AS total
        FROM reservations r
        WHERE online = 1
    ";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return (int)$row['total'];
    } else {
        return 0;
    }
}

function getOnlinePrecentage($conn): int {
    $sql = "
        SELECT COUNT(*) AS total
        FROM reservations r
        LEFT JOIN users u ON r.email = u.email
        WHERE (u.role IS NULL OR u.role NOT IN ('admin', 'ticketOffice'))
    ";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return (int) round((countOnlineReservations($conn) / (int)$row['total']) * 100);
    } else {
        return 0;
    }
}

function calculateExpireTime(string $showDate, string $showTime): ?DateTime {
    $now = new DateTime();
    $showDateTime = new DateTime("$showDate $showTime");
    $diffInSeconds = $showDateTime->getTimestamp() - $now->getTimestamp();

    $expire = clone $showDateTime;

    if ($diffInSeconds < 4 * 3600) {
        return null;
    }

    if ($diffInSeconds >= 7 * 24 * 3600) {
        // Më shumë se 7 ditë → skadon 5 ditë para shfaqjes në orën 16:00
        $expire->modify('-5 days')->setTime(16, 0);
    } elseif ($diffInSeconds >= 3 * 24 * 3600) {
        // 3 – 7 ditë → skadon 2 ditë para në orën 16:00
        $expire->modify('-2 days')->setTime(16, 0);
    } elseif ($diffInSeconds >= 2 * 24 * 3600) {
        // 2 – 3 ditë → skadon 1 ditë para në orën 16:00
        $expire->modify('-1 day')->setTime(16, 0);
    } else {
        // Më pak se 2 ditë → skadon 6 orë para orarit të shfaqjes
        $expire->modify('-6 hours');
    }

    return $expire;
}

function isActiveEmail(string $email, $conn): bool {
    $sql = "SELECT status FROM users WHERE email = ? AND status = 'not active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false;
    }

    return true;
}