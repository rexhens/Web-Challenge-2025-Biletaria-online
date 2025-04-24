<?php
$servername = "metropolticketing.marketingelite.eu";
$username = "marketingelite";
$password = "ndgcFAGTtnqW3Uz";
$database = "theater_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}