<?php
/** @var mysqli $conn */
require "../config/db_connect.php";

if(isset($_GET["token"])) {
    $token = $_GET["token"];
    $stmt = $conn->prepare("SELECT is_verified FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if(!$row) {
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>";
              require '../includes/links.php';
        echo "<title>Teatri Metropol | Mesazh</title>
              <link rel='icon' type='image/x-icon' href='../assets/img/metropol_icon.png'>
              <link rel='stylesheet' href='../assets/css/styles.css'>
              <style>
                  body {
                    background: url('../assets/img/error.png') no-repeat center center fixed;
                    background-size: cover;
                  }
              </style>
              </head>
              <body>
              <div class='errors show' style='background-color: #f44336'>
                    <p style='color: #E4E4E4;'>Kod i gabuar verifikimi.</p>
              </div>
              </body>
              </html>";
    } else {
        if($row["is_verified"] == 0) {
            $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE verification_token = ?");
            $stmt->bind_param("s", $token);

            if (!$stmt->execute()) {
                echo "<!DOCTYPE html>
                      <html lang='en'>
                      <head>";
                require '../includes/links.php';
                echo "<title>Teatri Metropol | Mesazh</title>
                      <link rel='icon' type='image/x-icon' href='../assets/img/metropol_icon.png'>
                      <link rel='stylesheet' href='../assets/css/styles.css'>
                      <style>
                          body {
                            background: url('../assets/img/error.png') no-repeat center center fixed;
                            background-size: cover;
                          }
                      </style>
                      </head>
                      <body>
                      <div class='errors show' style='background-color: #f44336'>
                            <p style='color: #E4E4E4;'>Një problem ndodhi! Provoni më vonë!.</p>
                      </div>
                      </body>
                      </html>";
                $stmt->close();
            } else {
                header("location: login.php");
            }
        } else {
            header("location: index.php");
        }
    }
} else {
    echo "<!DOCTYPE html>
          <html lang='en'>
          <head>";
    require '../includes/links.php';
    echo "<title>Teatri Metropol | Mesazh</title>
          <link rel='icon' type='image/x-icon' href='../assets/img/metropol_icon.png'>
          <link rel='stylesheet' href='../assets/css/styles.css'>
          <style>
              body {
                background: url('../assets/img/error.png') no-repeat center center fixed;
                background-size: cover;
              }
          </style>
          </head>
          <body>
          <div class='errors show' style='background-color: #f44336'>
                <p style='color: #E4E4E4;'>Nuk ka një kod për verifikim.</p>
          </div>
          </body>
          </html>";
}

mysqli_close($conn);