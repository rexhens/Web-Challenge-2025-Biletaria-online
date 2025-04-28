<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$errors = [];
$success = false;

$name = "";
$surname = "";
$email = "";
$phone = "";
$roles = '';

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['password-confirm']);
    $roles = $_POST['role'] ?? '';
    $is_verified = 1;

    if (empty($name) || empty($surname) || empty($email) || empty($phone) || empty($password) || empty($passwordConfirm) || empty($roles)) {
        $errors[] = "Të gjitha fushat duhen plotësuar!";
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $name)) {
        $errors[] = "Emri nuk është i vlefshëm.";
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $surname)) {
        $errors[] = "Mbiemri nuk është i vlefshëm.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email-i nuk është i vlefshëm.";
    }
    if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $phone)) {
        $errors[] = "Numri i telefonit nuk është i vlefshëm.";
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^_\-+=<>])[A-Za-z\d@$!%*?&#^_\-+=<>]{8,}$/', $password)) {
        $errors[] = "<strong>Kriteret e Fjalëkalimit : </strong><br>
                         Përmban të paktën 8 karaktere.<br>
                         Përmban të paktën një shkronjë të madhe.<br>
                         Përmban të paktën një shkronjë të vogël.<br>
                         Përmban të paktën një numër.<br>
                         Përmban të paktën një karakter special. (p.sh., @, #, $, % etj.).";
    }
    if ($password !== $passwordConfirm) {
        $errors[] = "Fjalëkalimet nuk përputhen.";
    }

    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        $errors[] = "Ky email është përdorur më parë.";
    }
    $checkStmt->close();

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email, phone, password, role, verification_token, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $token = md5(uniqid(rand(), true));
        $stmt->bind_param("sssssssi", $name, $surname, $email, $phone, $hashedPassword, $roles, $token, $is_verified);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Nuk u shtua përdoruesi. Gabim gjatë regjistrimit.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../../../includes/links.php'; ?>
    <meta property="og:image" content="../../../assets/img/metropol_icon.png">
    <link rel="icon" href="../../../assets/img/metropol_icon.png">
    <title>Teatri Metropol | Shto Përdorues</title>
    <link rel="stylesheet" href="/biletaria_online/assets/css/styles.css">

</head>

<body id="page-top" class="light">
    <div style=" display: flex; min-height: 100vh; justify-content: flex-start; width: 100%; gap: 20%;">

        <!-- Sidebar -->
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div style="flex: 1; padding: 20px;">
            <form action="add-user.php" method="POST" class="form-container light" id="signup-form">
                <h1 style="color: black; font-size: 25px;">Shtoni një <span
                        style="color: #8f793f!important;">Përdorues</span>
                </h1>

                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder=" " required
                        value="<?php echo htmlspecialchars($name ?? '') ?>">
                    <label for="name">Emri</label>
                </div>

                <div class="form-group">
                    <input type="text" name="surname" id="surname" placeholder=" " required
                        value="<?php echo htmlspecialchars($surname ?? '') ?>">
                    <label for="surname">Mbiemri</label>
                </div>

                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder=" " required
                        value="<?php echo htmlspecialchars($email ?? '') ?>">
                    <label for="email">Email</label>
                </div>

                <div class="form-group">
                    <input type="tel" name="phone" id="phone" placeholder=" " required
                        value="<?php echo htmlspecialchars($phone ?? '') ?>">
                    <label for="phone">Numri i Telefonit</label>
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder=" " required>
                    <label for="password">Krijoni një fjalëkalim</label>
                    <span class="eye-icon" id="password-icon" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="form-group">
                    <input type="password" name="password-confirm" id="password-confirm" placeholder=" " required>
                    <label for="password-confirm">Konfirmoni fjalëkalimin</label>
                    <span class="eye-icon" id="password-confirm-icon" onclick="toggleConfirmPassword()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="form-group">
                    <select name="role" id="role" required>
                        <option value="" disabled <?php echo empty($roles) ? 'selected' : ''; ?>>-- Zgjidh rolin --
                        </option>
                        <option value="user" <?php echo ($roles === 'user') ? 'selected' : ''; ?>>Përdorues</option>
                        <option value="ticketOffice" <?php echo ($roles === 'ticketOffice') ? 'selected' : ''; ?>>Biletari
                        </option>
                        <option value="admin" <?php echo ($roles === 'admin') ? 'selected' : ''; ?>>Administrator</option>
                    </select>
                </div>

                <button type="submit" name="submit" style="margin-top: 20px;">Shto Përdorues</button>

            </form>


            <div class="info-container">
                <div class="name-error errors" id="name-error">
                    <p>Emri s'mund të përmbajë numra ose karaktere speciale.</p>
                </div>
                <div class="surname-error errors" id="surname-error">
                    <p>Mbiemri s'mund të përmbajë numra ose karaktere speciale.</p>
                </div>
                <div class="email-error errors" id="email-error">
                    <p>Adresë e pasaktë email-i!</p>
                </div>
                <div class="phone-error errors" id="phone-error">
                    <p>Numër i pasaktë telefoni!</p>
                </div>
                <div class="password-error errors" id="password-error">
                    <p><strong>Kriteret e Fjalëkalimit : </strong><br>
                        Përmban të paktën 8 karaktere.<br>
                        Përmban të paktën një shkronjë të madhe.<br>
                        Përmban të paktën një shkronjë të vogël.<br>
                        Përmban të paktën një numër.<br>
                        Përmban të paktën një karakter special. (p.sh., @, #, $, etj.).</p>
                </div>
                <div class="password-confirm-error errors" id="password-confirm-error">
                    <p>Fjalëkalimet nuk përputhen.</p>
                </div>
                <?php
                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        echo "<div class='errors show'><p>$error</p></div>";
                    }
                }

                if ($success) {
                    echo "<div class='errors show' style='background-color: rgba(131, 173, 68)'>
                <p style='color: #E4E4E4;'>Përdoruesi u shtua me sukses!</p>
              </div>";
                }
                ?>
            </div>

        </div>
    </div> <!-- FLEX CONTAINER ENDS -->

    <script>
        const elementsToHide = document.getElementsByClassName("show");
        setTimeout(() => {
            Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
        }, 4500);
    </script>
    <script src="/biletaria_online/assets/js/functions.js"></script>
    <script src="/biletaria_online/assets/js/signupValidations.js"></script>

    <!-- Sidebar toggle -->
    <script>
        $(document).ready(function () {
            $("#sidebarToggle").on('click', function (e) {
                e.preventDefault();
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
            });
        });
    </script>
</body>

</html>