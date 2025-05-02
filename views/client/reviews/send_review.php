<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php'; // Adjust this

$email = 'pllumbiklevis1@gmail.com';
$subject = 'Vleresimi i shfaqjes';

$reviewPageUrl = 'https://localhost:8080/biletaria_online/views/client/reviews/review-form.php';

$body = '
  <html>
  <head>
    <style>
      .star { font-size: 24px; text-decoration: none; color: #FFD700; margin: 5px; }
      .star:hover { text-decoration: underline; }
      .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
      }
    </style>
  </head>
  <body>
    <h2>Na ndihmoni të përmirësojmë shfaqjet tona</h2>
    <p>Sa yje i jepni kësaj shfaqjeje?</p>
    <p>
      <a href="' . $reviewPageUrl . '?rating=5" class="star">★★★★★</a><br>
      <a href="' . $reviewPageUrl . '?rating=4" class="star">★★★★</a><br>
      <a href="' . $reviewPageUrl . '?rating=3" class="star">★★★</a><br>
      <a href="' . $reviewPageUrl . '?rating=2" class="star">★★</a><br>
      <a href="' . $reviewPageUrl . '?rating=1" class="star">★</a>
    </p>
    <p>Ose shkruani një koment:</p>
    <a href="' . $reviewPageUrl . '" class="button">Shkruani një koment</a>
  </body>
  </html>
';

$success = sendEmail($email, $subject, $body);

if ($success) {
    echo "Emaili u dërgua me sukses.";
} else {
    echo "Dështoi dërgimi i emailit.";
}
?>