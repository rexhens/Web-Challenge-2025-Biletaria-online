<?php
include_once '../../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (is_numeric($_POST['userId'])) {
        $id = (int) $_POST['userId'];
    

        $sql = "UPDATE shows SET priority = 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php?update=success');
                exit();
            } else {
                echo "Gabim gjatë përditësimit: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Gabim në përgatitjen e deklaratës: " . mysqli_error($conn);
        }
    } else {
        echo "ID e pavlefshme!";
    }
}
?>