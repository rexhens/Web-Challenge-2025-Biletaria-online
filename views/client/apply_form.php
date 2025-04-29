<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Formular për salla me qera</title>
    <link rel="stylesheet" href="/biletaria_online/assets/css/styles.css">
    <link rel="stylesheet" href="/biletaria_online/assets/css/flatpickr.min.css">
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <style>
        body {
            font-family: var(--default-font, Arial, sans-serif);
            background: url('../../assets/img/background-image.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            color: var(--text-color, #333);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Flex container for two-column layout */
        .form-columns {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-column {
            flex: 1;
            min-width: 300px;
        }

        fieldset {
            margin-top: 20px;
            padding: 15px;
            border: none;
            /* Removed border from actors div */
            border-radius: 8px;
        }

        legend {
            font-weight: bold;
            padding: 0 10px;
        }

        .actors-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .actors-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* Two columns */
            grid-template-rows: repeat(3, auto);
            /* Three rows */
            gap: 20px;
            /* Space between fields */
        }

        .actors-grid label {
            width: 100%;
            /* Ensure labels take up full width in the grid */
        }
    </style>
</head>

<body>
    <h2>Formular për salla me qera</h2>
    <form method="POST" action="generate_pdf.php">
        <div class="form-columns">
            <!-- Left column -->
            <div class="form-column">
                <label>Emër:
                    <input type="text" name="emer" required>
                </label>
                <label>Mbiemër:
                    <input type="text" name="mbiemer" required>
                </label>
                <label>Pozicioni në projekt:
                    <input type="text" name="pozicioni">
                </label>
                <label>Personi i kontaktit:
                    <input type="text" name="kontakti">
                </label>
                <label>Titulli i aktivitetit:
                    <input type="text" name="titulli" required>
                </label>
                <label>Tematika:<br>
                    <textarea name="tematika" rows="3" cols="50"></textarea>
                </label>
                <label>Përmbajtja:<br>
                    <textarea name="permbajtja" rows="5" cols="50"></textarea>
                </label>
            </div>

            <!-- Right column -->
            <div class="form-column">
                <label>Nr Tel:
                    <input type="text" name="telefoni">
                </label>
                <label>E-mail:
                    <input type="email" name="email">
                </label>
                <label>Data e aktivitetit:
                    <input type="date" name="data">
                </label>
                <label>Orari i aktivitetit:
                    <input type="text" name="orari">
                </label>
                <label>Kohëzgjatja:
                    <input type="text" name="kohezgjatja">
                </label>
                <label>Salla:
                    <input type="text" name="salla">
                </label>
                <label>Specifikime Teknike:<br>
                    <textarea name="specifikime" rows="3" cols="50"></textarea>
                </label>
                <label>Regjisor:
                    <input type="text" name="regjisor">
                </label>
                <label>As. Regjisor:
                    <input type="text" name="asregjisor">
                </label>
                <div class="actors-section">
                    <fieldset>
                        <legend style="color: #8f793f;">Aktorët pjesëmarrës</legend>
                        <div class="actors-grid">
                            <label>1. <input type="text" name="aktoret[]"></label>
                            <label>2. <input type="text" name="aktoret[]"></label>
                            <label>3. <input type="text" name="aktoret[]"></label>
                            <label>4. <input type="text" name="aktoret[]"></label>
                            <label>5. <input type="text" name="aktoret[]"></label>
                            <label>6. <input type="text" name="aktoret[]"></label>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <button type="submit">Gjenero dokumentin Word</button>
    </form>
</body>

</html>