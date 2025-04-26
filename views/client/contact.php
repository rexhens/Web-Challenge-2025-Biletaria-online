<?php 
$pageTitle = "Kontakt";
$pageStyles = [
    'assets/css/as-alert-message.min.css',
    'assets/css/contact_us.css'
];
require 'includes/header.php';
?>

<!-- Forma e Kontaktit -->
<div class="container">
    <h4>Na Kontaktoni</h4>
    <h3>Lini një Mesazh</h3>
    <p>Nëse keni ndonjë pyetje në lidhje me shërbimet tona,
      ju lutemi na kontaktoni duke përdorur formularin më poshtë.</p>

    <form name="contact-us-form" action="#" onsubmit="return validateForm()">
      <div class="row100" id="fname-row100">
        <div class="col">
          <div class="inputBox" id="fname-inputBox">
            <input type="text" name="fname" onclick="triggerAnim('fname')"/>
            <span class="text">Emri</span>
            <span class="line" id="fname-line"></span>
          </div>
        </div>
        <div class="col">
          <div class="inputBox" id="lname-inputBox">
            <input type="text" name="lname" onclick="triggerAnim('lname')"/>
            <span class="text">Mbiemri</span>
            <span class="line" id="lname-line"></span>
          </div>
        </div>
      </div>
      <div class="row100" id="email-row100">
        <div class="col">
          <div class="inputBox" id="email-inputBox">
            <input type="email" name="email" pattern="[^ @]*@[^ @]*" onclick="triggerAnim('email')"/>
            <span class="text">Email</span>
            <span class="line" id="email-line"></span>
          </div>
        </div>
        <div class="col">
          <div class="inputBox" id="tel-inputBox">
            <input type="tel" name="m-num" onclick="triggerAnim('tel')" />
            <span class="text">Numri i Telefonit</span>
            <span class="line" id="tel-line"></span>
          </div>
        </div>
      </div>
      <div class="row100">
        <div class="col">
          <div class="inputBox textarea">
            <textarea name="msg"></textarea>
            <span class="text">Shkruani mesazhin tuaj këtu...</span>
            <span class="line"></span>
          </div>
        </div>
      </div>
      <div class="row100">
        <div class="col">
          <div class="submitbutton">
            <button class="btn submitbtn" type="submit">Dërgo</button>
          </div>
        </div>
      </div>
    </form>
  </div>



<!-- JavaScript specifik për faqen e kontaktit -->
<script type="text/javascript" src="../../assets/js/contact-us.js"></script>
<script type="text/javascript" src="../../assets/js/as-alert-message.min.js"></script>

<script>
// Funksioni për validimin e formës
function validateForm() {
    // Implementimi i validimit
    return true;
}

// Funksioni për animacionin e inputeve
function triggerAnim(inputId) {
    document.getElementById(inputId + '-line').style.width = '100%';
    document.getElementById(inputId + '-inputBox').classList.add('focus');
}

// Kontrollon nëse fusha ka vlerë kur humbet fokusi
document.querySelectorAll('.inputBox input, .inputBox textarea').forEach(input => {
    input.addEventListener('blur', function() {
        if(this.value == "") {
            this.parentNode.classList.remove('focus');
            const lineId = this.getAttribute('name') + '-line';
            if(document.getElementById(lineId)) {
                document.getElementById(lineId).style.width = '0%';
            }
        }
    });
});
</script>