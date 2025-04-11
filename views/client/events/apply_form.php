<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <title>Formular për salla me qera</title>
</head>

<body>
    <img src="../../../assets/img/doc-header.png" alt="">
    <h2>Formular për salla me qera</h2>
    <form method="POST" action="generate_doc.php">
        <label>Emër: <input type="text" name="emer" required></label><br><br>
        <label>Mbiemër: <input type="text" name="mbiemer" required></label><br><br>
        <label>Pozicioni në projekt: <input type="text" name="pozicioni"></label><br><br>
        <label>Personi i kontaktit: <input type="text" name="kontakti"></label><br><br>
        <label>Titulli i aktivitetit: <input type="text" name="titulli" required></label><br><br>
        <label>Tematika:<br>
            <textarea name="tematika" rows="3" cols="50"></textarea>
        </label><br><br>
        <label>Përmbajtja:<br>
            <textarea name="permbajtja" rows="5" cols="50"></textarea>
        </label><br><br>
        <label>Nr Tel: <input type="text" name="telefoni"></label><br><br>
        <label>E-mail: <input type="email" name="email"></label><br><br>
        <label>Data e aktivitetit: <input type="date" name="data"></label><br><br>
        <label>Orari i aktivitetit: <input type="text" name="orari"></label><br><br>
        <label>Kohëzgjatja: <input type="text" name="kohezgjatja"></label><br><br>
        <label>Salla: <input type="text" name="salla"></label><br><br>
        <label>Specifikime Teknike:<br>
            <textarea name="specifikime" rows="3" cols="50"></textarea>
        </label><br><br>
        <label>Regjisor: <input type="text" name="regjisor"></label><br><br>
        <label>As. Regjisor: <input type="text" name="asregjisor"></label><br><br>

        <fieldset>
            <legend>Aktorët pjesëmarrës</legend>
            <label>1. <input type="text" name="aktoret[]"></label><br>
            <label>2. <input type="text" name="aktoret[]"></label><br>
            <label>3. <input type="text" name="aktoret[]"></label><br>
            <label>4. <input type="text" name="aktoret[]"></label><br>
            <label>5. <input type="text" name="aktoret[]"></label><br>
            <label>6. <input type="text" name="aktoret[]"></label><br>
        </fieldset><br>

        <button type="submit">Gjenero dokumentin Word</button>
    </form>
</body>

</html>