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
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
        }

        h1 {
            font-size: 25px;
            margin-bottom: 20px;
            color: #8f793f;
        }

        form {
            max-width: 1000px;
            margin: 0 auto;
            padding: 50px 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }

        .form-column {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .form-group {
            position: relative;
            margin-top: 10px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 12px 12px 0;
            border: none;
            border-bottom: 2px solid #ccc;
            background: transparent;
            font-size: 15px;
            outline: none;
            color: #8f793f;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #8f793f;
        }

        .form-group label {
            position: absolute;
            top: 12px;
            left: 0;
            font-size: 14px;
            color: #8f793f !important;
            pointer-events: none;
            transition: all 0.2s ease-out;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label,
        .form-group textarea:focus+label,
        .form-group textarea:not(:placeholder-shown)+label {
            top: -8px;
            left: 0;
            font-size: 12px;
            color: #8f793f;
            background: white;
            padding: 0 4px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: #8f793f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 30px;
            transition: background 0.3s;
        }

        button[type="submit"]:hover {
            background: #a18b57;
        }

        fieldset {
            border: none;
            margin-top: 30px;
        }

        legend {
            font-weight: bold;
            color: #8f793f;
            margin-bottom: 10px;
        }

        .actors-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .actors-grid .form-group {
            margin: 0;
        }
    </style>
</head>
<link rel="stylesheet" href="/biletaria_online/assets/css/flatpickr.min.css">
<script src="/biletaria_online/assets/js/flatpickr.min.js"></script>


<body>

    <!-- Main Content -->
    <div style="flex: 1; padding: 20px;">

        <h1 style="color: #8f793f; font-weight: 700;">Formular Per Salle Me Qera</h1>

        <form method="POST" action="../../client/generate_pdf.php">
            <div class="form-columns">
                <!-- Left column -->
                <div class="form-column">
                    <div class="form-group">
                        <input type="text" name="emer" required>
                        <label for="emer">Emri</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="telefoni">
                        <label for="telefoni">Nr Tel</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="pozicioni" required>
                        <label for="pozicioni">Pozicioni ne projekt</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="kontakti">
                        <label for="kontakti">Personi i kontaktit</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="titulli" required>
                        <label for="titulli">Titulli i aktivitetit</label>
                    </div>
                    <div class="form-group">
                        <textarea name="tematika" id="tematika" placeholder=" "></textarea>
                        <label for="tematika" style="color:#8f793f; font-weight:650;">Tematika</label>
                    </div>
                    <div class="form-group">
                        <textarea name="permbajtja" id="permbajtja" placeholder=" "></textarea>
                        <label for="permbajtja" style="color:#8f793f; font-weight:650;">Permbajtja</label>
                    </div>
                </div>

                <!-- Right column -->
                <div class="form-column">
                    <div class="form-group">
                        <input type="text" name="mbiemer" required>
                        <label for="mbiemer">Mbiemri</label>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="form-group">
                        <input type="date" name="data">
                        <label for="data">Data e aktivitetit</label>
                    </div>

                    <div class="form-group">
                        <input type="text" name="orari" class="flatpickr-input active">

                        <label for="orari">Orari i aktivitetit</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="kohezgjatja">
                        <label for="kohezgjatja">Kohëzgjatja</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="salla">
                        <label for="salla">Salla</label>
                    </div>
                    <div class="form-group">
                        <textarea name="specifikime" rows="3" cols="50"></textarea>
                        <label for="specifikime" style="font-weight:650;">Specifikime Teknike</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="regjisor">
                        <label for="regjisor">Regjisor</label>
                    </div>
                    <div class="form-group">
                        <input type="text" name="asregjisor">
                        <label for="asregjisor">As. Regjisor</label>
                    </div>
                </div>
            </div>

            <!-- Actors Section -->
            <div class="actors-section">
                <fieldset>
                    <legend style="color: #8f793f;">Aktorët pjesëmarrës</legend>
                    <div class="actors-grid">
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">1.</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">2.</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">3.</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">4.</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">5.</label>
                        </div>
                        <div class="form-group">
                            <input type="text" name="aktoret[]">
                            <label for="aktoret[]">6.</label>
                        </div>
                    </div>
                </fieldset>
            </div>

            <button type="submit">Gjenero dokumentin Pdf</button>
        </form>
    </div>
</body>


</html>