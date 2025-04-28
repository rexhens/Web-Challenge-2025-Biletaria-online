<?php
// Show errors while testing (REMOVE these two lines when you go live)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Dompdf library
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Collect data from the form
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

// Load and prepare the image
$imageTag = '';
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/doc-header.png';
if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents(filename: $imagePath));
    $imageTag = '<img src="data:image/png;base64,' . $imageData . '" alt="Header Logo" style="width:100%; height:auto; margin-bottom:20px;">';
}

// Build actors list
$aktorList = '';
if (!empty($aktoret) && is_array($aktoret)) {
    foreach ($aktoret as $i => $akt) {
        if (trim($akt) !== '') {
            $aktorList .= ($i + 1) . ". " . htmlspecialchars($akt) . "<br>";
        }
    }
}

// Create the HTML
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
<p><strong>Aplikanti:</strong> Individ / Institucion / Organizatë OJF</p>
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

// Generate the PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("formulari_ambient_qera.pdf", ["Attachment" => true]);
?>