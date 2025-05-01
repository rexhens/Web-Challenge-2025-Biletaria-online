<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
$pageTitle = "Aplikim për salla me qira";
$pageStyles = [
    "/biletaria_online/assets/css/flatpickr.min.css",
    "/biletaria_online/assets/css/styles.css",
    '/biletaria_online/assets/css/navbar.css'
];
?>

<?php
if(isset($_SESSION['user_id'])) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    if($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    }
}
?>

<?php
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        .form-container {
            max-width: 1000px;
            margin: 20px 10px 0 10px !important;
            width: auto !important;
            border: 2px solid var(--surface-color);
        }

        fieldset {
            border: 1px solid #8f793f;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            width: 95%;
        }

        legend {
            padding: 0 10px;
            font-size: 18px;
            font-weight: bold;
            color: #C8BBB3FF;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 100%;
        }

        .full-width {
            width: 100%;
        }

        .full-width button {
            width: 100% !important;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 945px) {
            .form-container {
                width: 100% !important;
                padding: 25px 35px !important;
            }

            .form-group {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

<form class="form-container" method="post" action="generate_pdf.php">
    <h1 class="full-width">Aplikim për salla me qera në <br>
        <span>Teatrin Metropol</span>
    </h1>

    <fieldset>
        <legend>Institucioni / Organizata / Aplikanti</legend>
        <div class="form-group" style="width: 100% !important;">
            <input type="text" id="institucioni" name="institucioni" placeholder=" " required
                   value="<?php echo htmlspecialchars($old['institucioni'] ?? '') ?>" />
            <label for="institucioni">Emri</label>
        </div>
    </fieldset>

    <fieldset>
        <legend>Informacion i përgjithshëm</legend>
        <div class="form-grid">
            <div class="form-group">
                <input type="text" id="emer" name="emer" placeholder=" "
                       value="<?php echo htmlspecialchars($old['emer'] ?? ($user['name'] ?? '')) ?>" required />
                <label for="emer">Emër</label>
            </div>
            <div class="form-group">
                <input type="text" id="mbiemer" name="mbiemer" placeholder=" "
                       value="<?php echo htmlspecialchars($old['mbiemer'] ?? ($user['surname'] ?? '')) ?>" required />
                <label for="mbiemer">Mbiemër</label>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder=" "
                       value="<?php echo htmlspecialchars($old['email'] ?? ($user['email'] ?? '')) ?>" required />
                <label for="email">Email</label>
            </div>
            <div class="form-group">
                <input type="tel" id="telefoni" name="telefoni" placeholder=" "
                       value="<?php echo htmlspecialchars($old['telefoni'] ?? ($user['phone'] ?? '')) ?>" required />
                <label for="telefoni">Telefoni</label>
            </div>
            <div class="form-group">
                <input type="text" id="pozicioni" name="pozicioni" placeholder=" " required
                       value="<?php echo htmlspecialchars($old['pozicioni'] ?? '') ?>" />
                <label for="pozicioni">Pozicioni në projekt</label>
            </div>
            <div class="form-group">
                <input type="text" id="kontakti" name="kontakti" placeholder=" " required
                       value="<?php echo htmlspecialchars($old['kontakti'] ?? '') ?>" />
                <label for="kontakti">Person kontakti</label>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Informacione Kryesore</legend>
        <div class="form-group" style="width: 100% !important;">
            <input type="text" id="titulli" name="titulli" placeholder=" " required
                   value="<?php echo htmlspecialchars($old['titulli'] ?? '') ?>" />
            <label for="titulli">Titulli i aktivitetit</label>
        </div>
        <div class="form-group" style="width: 100% !important; margin-top: 20px;">
            <textarea name="tematika" id="tematika" placeholder="Tematika e aktivitetit..." required><?php echo htmlspecialchars($old['tematika'] ?? '') ?></textarea>
        </div>
        <div class="form-group" style="width: 100% !important; margin-top: 20px;">
            <textarea name="permbajtja" id="permbajtja" placeholder="Përmbajtja e aktivitetit..." required style="min-height: 100px !important;"><?php echo htmlspecialchars($old['permbajtja'] ?? '') ?></textarea>
        </div>
    </fieldset>

    <fieldset>
        <legend>Detaje mbi aktivitetin</legend>
        <div class="form-grid">
            <div class="form-group">
                <input type="text" id="data" name="data" placeholder=" "
                       value="<?php echo htmlspecialchars($old['data'] ?? '') ?>" required/>
                <label for="data">Data</label>
            </div>
            <div class="form-group">
                <input type="text" id="orari" name="orari" placeholder=" "
                       value="<?php echo htmlspecialchars($old['orari'] ?? '') ?>" required/>
                <label for="orari">Orari</label>
            </div>
            <div class="form-group">
                <input type="text" id="kohezgjatja" name="kohezgjatja" placeholder=" "
                       value="<?php echo htmlspecialchars($old['kohezgjatja'] ?? '') ?>" required/>
                <label for="kohezgjatja">Kohëzgjatja</label>
            </div>
            <div class="form-group">
                <select name="salla" id="salla" required style="margin-top: -5.5px !important;">
                    <option value="" disabled <?php if (!isset($old['salla'])) echo 'selected'; ?>>-- Zgjidh sallën --</option>
                    <option value="Shakespare" <?php if (($old['salla'] ?? '') == 'Shakespare') echo 'selected'; ?>>Shakespare</option>
                    <option value="Çehov" <?php if (($old['salla'] ?? '') == 'Çehov') echo 'selected'; ?>>Çehov</option>
                    <option value="Bodrum" <?php if (($old['salla'] ?? '') == 'Bodrum') echo 'selected'; ?>>Bodrum</option>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Specifikime Teknike</legend>
        <div class="form-group" style="width: 100% !important;">
            <input type="text" id="specifikime" name="specifikime" placeholder=" "
                   value="<?php echo htmlspecialchars($old['specifikime'] ?? '') ?>" />
            <label for="specifikime">Specifikime</label>
        </div>
    </fieldset>

    <fieldset>
        <legend>Regjisorët</legend>
        <div class="form-grid">
            <div class="form-group">
                <input type="text" id="regjisor" name="regjisor" placeholder=" " required
                       value="<?php echo htmlspecialchars($old['regjisor'] ?? '') ?>" />
                <label for="regjisor">Regjisor</label>
            </div>
            <div class="form-group">
                <input type="text" id="asregjisor" name="asregjisor" placeholder=" " required
                       value="<?php echo htmlspecialchars($old['asregjisor'] ?? '') ?>" />
                <label for="asregjisor">As.Regjisor</label>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Aktorët pjesmarrës</legend>
        <div class="form-grid">
            <?php
            $aktoret = $old['aktoret'] ?? array_fill(0, 6, '');
            for ($i = 0; $i < 6; $i++) {
                echo '<div class="form-group">
                        <input type="text" name="aktoret[]" placeholder=" " value="' . htmlspecialchars($aktoret[$i] ?? '') . '">
                        <label>' . ($i + 1) . '.</label>
                    </div>';
            }
            ?>
        </div>
    </fieldset>

    <div class="full-width">
        <button type="submit">Dërgo dhe Gjenero Dokumentin</button>
    </div>
</form>

<div class="info-container">
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='errors show'>
                <p>" . $_SESSION['error'] . "</p>
              </div>";
    }
    ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr("#data", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            locale: "sq"
        });

        flatpickr("#orari", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>
<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
<script src="/biletaria_online/assets/js/flatpickr.min.js"></script>
</body>

</html>