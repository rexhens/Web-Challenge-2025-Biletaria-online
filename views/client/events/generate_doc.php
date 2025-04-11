<?php
// Collect data from the form
$emer = $_POST['emer'];
$mbiemer = $_POST['mbiemer'];
$pozicioni = $_POST['pozicioni'];
$kontakti = $_POST['kontakti'];
$titulli = $_POST['titulli'];
$tematika = $_POST['tematika'];
$permbajtja = $_POST['permbajtja'];
$telefoni = $_POST['telefoni'];
$email = $_POST['email'];
$data = $_POST['data'];
$orari = $_POST['orari'];
$kohezgjatja = $_POST['kohezgjatja'];
$salla = $_POST['salla'];
$specifikime = $_POST['specifikime'];
$regjisor = $_POST['regjisor'];
$asregjisor = $_POST['asregjisor'];
$aktoret = $_POST['aktoret']; // Should be an array of names (1-6)

// Load the local image file and base64 encode it
$imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/doc-header.png';
if (file_exists($imagePath)) {
  $imageData = base64_encode(file_get_contents($imagePath));
  // Embed the image directly using base64 encoding
  $imageTag = '<img src="../../../assets/img/doc-header.png" alt="Header Logo" style="width:120px; margin-bottom:20px;">';
} else {
  // Fallback message if the local image cannot be found
  $imageTag = '<p>[Image file not found]</p>';
}

// Generate actor list
$aktorList = '';
foreach ($aktoret as $i => $akt) {
  if (trim($akt) !== '') {
    $aktorList .= ($i + 1) . ". $akt<br>";
  }
}

// Word document HTML content
$docContent = "
<html xmlns:o='urn:schemas-microsoft-com:office:office' 
      xmlns:w='urn:schemas-microsoft-com:office:word' 
      xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<meta charset='utf-8'>
<title>Formular</title>
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
<p><strong>Emër:</strong> $emer &nbsp;&nbsp;&nbsp; <strong>Mbiemër:</strong> $mbiemer</p>
<p><strong>Pozicioni në projekt:</strong> $pozicioni</p>
<p><strong>Personi i kontaktit:</strong> $kontakti</p>
<p><strong>Titulli i aktivitetit:</strong> $titulli</p>
<p><strong>Tematika:</strong><br>$tematika</p>
<p><strong>Përmbajtja:</strong><br>$permbajtja</p>

<p><strong>Nr Tel:</strong> $telefoni &nbsp;&nbsp;&nbsp; <strong>E-mail:</strong> $email</p>
<p><strong>Data e aktivitetit:</strong> $data</p>
<p><strong>Orari i aktivitetit:</strong> $orari &nbsp;&nbsp;&nbsp; <strong>Kohëzgjatja:</strong> $kohezgjatja</p>
<p><strong>Salla:</strong> $salla</p>

<p><strong>Specifikime Teknike:</strong><br>$specifikime</p>

<p><strong>Regjisor:</strong> $regjisor &nbsp;&nbsp;&nbsp; <strong>As. Regjisor:</strong> $asregjisor</p>

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

// Output as Word Document
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; Filename=formular.doc");
echo $docContent;
exit;
?>