<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../includes/functions.php";

if(isset($_GET["token"])) {
    $token = $_GET["token"];
    $stmt = $conn->prepare("SELECT is_verified FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if(!$row) {
        showError("Kod i gabuar verifikimi.");
    } else {
        if($row["is_verified"] == 0) {
            $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE verification_token = ?");
            $stmt->bind_param("s", $token);

            if (!$stmt->execute()) {
                showError("Një problem ndodhi! Provoni më vonë!");
                $stmt->close();
            } else {
                header("location: login.php");
            }
        } else {
            header("location: index.php");
        }
    }
} else {
    showError("Nuk ka një kod për verifikim.");
}

mysqli_close($conn);