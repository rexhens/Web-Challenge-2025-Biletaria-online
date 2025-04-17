<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Formular për salla me qera</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="../../../assets/css/flatpickr.min.css">
    <meta property="og:image" content="../../../assets/img/metropol_icon.png">
    <style>
        body {
            font-family: var(--default-font, Arial, sans-serif);
            background: url('../../../assets/img/background-image.png') no-repeat center center fixed;
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

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 2px solid rgba(143, 121, 63, 0.5);
            border-radius: 5px;
            outline: none;
            background: none;
            backdrop-filter: blur(5px);
            font-family: var(--default-font, Arial, sans-serif);
            font-size: 15px;
            color: var(--text-color, #333);
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        fieldset {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        legend {
            font-weight: bold;
            padding: 0 10px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #3e6cf5;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #2a54d4;
        }
    </style>
</head>

<body>
    <h2>Formular për salla me qera</h2>
    <form method="POST" action="generate_doc.php">
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
                <fieldset>
                    <legend>Aktorët pjesëmarrës</legend>
                    <label>1. <input type="text" name="aktoret[]"></label><br>
                    <label>2. <input type="text" name="aktoret[]"></label><br>
                    <label>3. <input type="text" name="aktoret[]"></label><br>
                    <label>4. <input type="text" name="aktoret[]"></label><br>
                    <label>5. <input type="text" name="aktoret[]"></label><br>
                    <label>6. <input type="text" name="aktoret[]"></label>
                </fieldset>
            </div>
        </div>
        <button type="submit">Gjenero dokumentin Word</button>
    </form>
</body>

</html>