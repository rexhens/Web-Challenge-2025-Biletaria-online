<?php
include_once '../../../config/db_connect.php';

$action = $_POST['formAction'];

$emri = $_POST['emri'];
$mbiemri = $_POST['mbiemri'];
$email = $_POST['email'];
$roli = $_POST['roli'];



$userId = $_POST['userId'];
$sql = "UPDATE users SET name = ?, surname = ?, email = ?, role = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $emri, $mbiemri, $email, $roli, $userId);


if ($stmt->execute()) {
    header("Location: index.php?success=true");
    exit;
} else {
    echo "Gabim: " . $stmt->error;
}

?>