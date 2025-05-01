<?php
// Show errors while testing (REMOVE these two lines when you go live)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include Dompdf library
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/dompdf/autoload.inc.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/vendor/autoload.php';
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Collect data from the form
$institucioni = $_POST['institucioni'] ?? '';
$emer = $_POST['emer'] ?? '';
$mbiemer = $_POST['mbiemer'] ?? '';
$pozicioni = $_POST['pozicioni'] ?? '';
$kontakti = $_POST['kontakti'] ?? '';
$titulli = $_POST['titulli'] ?? '';
$tematika = $_POST['tematika'] ?? '';
$permbajtja = $_POST['permbajtja'] ?? '';
$telefoni = $_POST['telefoni'] ?? '';
$email = $_POST['email'] ?? '';
$data = $_POST['data'] ?? '';
$orari = $_POST['orari'] ?? '';
$kohezgjatja = $_POST['kohezgjatja'] ?? '';
$salla = $_POST['salla'] ?? '';
$specifikime = $_POST['specifikime'] ?? '';
$regjisor = $_POST['regjisor'] ?? '';
$asregjisor = $_POST['asregjisor'] ?? '';
$aktoret = $_POST['aktoret'] ?? [];

$requiredFields = [
    'institucioni', 'emer', 'mbiemer', 'pozicioni', 'kontakti',
    'titulli', 'tematika', 'permbajtja', 'telefoni', 'email',
    'data', 'orari', 'kohezgjatja', 'salla',
    'regjisor', 'asregjisor'
];

$missingFields = [];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    $_SESSION['error'] = "Ju lutemi plotësoni të gjitha fushat e kërkuara. Fushat bosh: " . implode(', ', $missingFields);
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}
if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $emer)) {
    $_SESSION['error'] = "Emri nuk është i vlefshëm.";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}
if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $mbiemer)) {
    $_SESSION['error'] = "Mbiemri nuk është i vlefshëm.";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Email-i nuk është i vlefshëm.";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}
if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $telefoni)) {
    $_SESSION['error'] = "Numri i telefonit nuk është i vlefshëm.";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}

$imageTag = '';
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/doc-header.png';
if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents(filename: $imagePath));
    $imageTag = '<img src="data:image/png;base64,' . $imageData . '" alt="Header Logo" style="width:100%; height:auto; margin-bottom:20px;">';
}

$aktorList = '';
if (!empty($aktoret) && is_array($aktoret)) {
    foreach ($aktoret as $i => $akt) {
        if (trim($akt) !== '') {
            $aktorList .= ($i + 1) . ". " . htmlspecialchars($akt) . "<br>";
        }
    }
}

$html = "
<html>
<head>
<meta charset='utf-8'>
<style>
  body {
    font-family: 'Calibri', sans-serif;
    margin: 2cm;
    font-size: 12pt;
    line-height: 1.5;
  }
  h2, h3 {
    text-align: center;
    margin: 0;
  }
  .section-title {
    font-weight: bold;
    margin-top: 20px;
  }
</style>
</head>
<body>
$imageTag

<h2>BASHKIA TIRANË</h2>
<h3>QENDRA KULTURORE “TIRANA”</h3>

<p style='text-align:right;'>Tiranë, më___.___.2024</p>

<p><strong>Lënda:</strong> Formular aplikimi për ambient me qera</p>

<p class='section-title'>Të dhëna të përgjithshme:</p>
<p><strong>Institucioni / Organizata:</strong> " . htmlspecialchars($institucioni) . "</p>
<p><strong>Emër:</strong> " . htmlspecialchars($emer) . " &nbsp;&nbsp;&nbsp; <strong>Mbiemër:</strong> " . htmlspecialchars($mbiemer) . "</p>
<p><strong>Pozicioni në projekt:</strong> " . htmlspecialchars($pozicioni) . "</p>
<p><strong>Personi i kontaktit:</strong> " . htmlspecialchars($kontakti) . "</p>
<p><strong>Titulli i aktivitetit:</strong> " . htmlspecialchars($titulli) . "</p>
<p><strong>Tematika:</strong><br>" . nl2br(htmlspecialchars($tematika)) . "</p>
<p><strong>Përmbajtja:</strong><br>" . nl2br(htmlspecialchars($permbajtja)) . "</p>

<p><strong>Nr Tel:</strong> " . htmlspecialchars($telefoni) . " &nbsp;&nbsp;&nbsp; <strong>E-mail:</strong> " . htmlspecialchars($email) . "</p>
<p><strong>Data e aktivitetit:</strong> " . htmlspecialchars($data) . "</p>
<p><strong>Orari i aktivitetit:</strong> " . htmlspecialchars($orari) . " &nbsp;&nbsp;&nbsp; <strong>Kohëzgjatja:</strong> " . htmlspecialchars($kohezgjatja) . "</p>
<p><strong>Salla:</strong> " . htmlspecialchars($salla) . "</p>

<p><strong>Specifikime Teknike:</strong><br>" . nl2br(htmlspecialchars($specifikime)) . "</p>

<p><strong>Regjisor:</strong> " . htmlspecialchars($regjisor) . " &nbsp;&nbsp;&nbsp; <strong>As. Regjisor:</strong> " . htmlspecialchars($asregjisor) . "</p>

<p><strong>Aktorët pjesëmarrës:</strong><br>$aktorList</p>

<p class='section-title'>Rregullorja e Teatrit</p>
<ul>
  <li>Sallat në Teatër nuk jepen më pak se dy orë.</li>
  <li>Nuk lejohet konsumimi i ushqimit në ambientet e teatrit.</li>
  <li>Nuk lejohet pirja e duhanit në ambientet e teatrit.</li>
  <li>Është detyrim paraqitja në orarin e përcaktuar më parë.</li>
  <li>Dera mbyllet në orarin përkatës.</li>
  <li>Pikat e mësipërme nuk negociohen.</li>
</ul>

</body>
</html>
";


$dompdf = new Dompdf();
try {
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $pdfOutput = $dompdf->output();
} catch (Exception $e) {
    $_SESSION['error'] = "Gabim gjatë gjenerimit të PDF!";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}

$tempPdfPath = sys_get_temp_dir() . '/formulari_ambient_qera.pdf';
if (!file_put_contents($tempPdfPath, $pdfOutput)) {
    $_SESSION['error'] = "Nuk u ruajt dot dokumenti PDF.";
    $_SESSION['old'] = $_POST;
    header("location: apply_form.php");
    exit;
}

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Username = $_ENV['SMTP_USER'];
    $mail->Password = $_ENV['SMTP_PASS'];
    $mail->SMTPAuth = true;
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->Port = $_ENV['SMTP_PORT'];
    $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($_ENV['SMTP_USER'], "Teatri Metropol");
    $mail->addAddress($_ENV['SMTP_USER']);

    $mail->isHTML(true);
    $mail->Subject = "Formulari për ambient me qera";
    $mail->Body = "Përshëndetje, formulari i aplikimit është bashkëngjitur si dokument PDF.
<br><strong>Aplikues:</strong> $emer $mbiemer
<br><strong>Email:</strong> <a href='mailto:$email'>$email</a>
<br><strong>Telefon:</strong> $telefoni";

    $mail->addAttachment($tempPdfPath, 'formulari_ambient_qera.pdf');
    $mail->send();

    unlink($tempPdfPath);
    $dompdf->stream("formulari_ambient_qera.pdf", ["Attachment" => true]);
    exit;
} catch (Exception $e) {
    $_SESSION['error'] = "Gabim gjatë dërgimit të email-it!";
    $_SESSION['old'] = $_POST;
    if (file_exists($tempPdfPath)) {
        unlink($tempPdfPath);
    }
    header("location: apply_form.php");
    exit;
}