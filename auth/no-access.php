<?php
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
http_response_code(403);
$error = "
<img src='/biletaria_online/assets/img/403.png' style='width: 515px;'>
";
customError($error);