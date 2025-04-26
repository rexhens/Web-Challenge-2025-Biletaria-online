<?php
$servername = "metropolticketing.marketingelite.eu";
$username = "marketingelite";
$password = "ndgcFAGTtnqW3Uz";
$database = "theater_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}