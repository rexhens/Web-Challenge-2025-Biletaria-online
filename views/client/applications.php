<?php
$pageTitle = "Aplikime";
$pageStyles = [
    '../assets/css/as-alert-message.min.css',
    '../assets/css/contact_us.css'
];
require '../includes/header.php';
?>

<div class="container">
    <h4>Aplikime</h4>
    <h3>Formulari i Aplikimit</h3>
    <p>Ju lutemi plotësoni formularin më poshtë për të aplikuar për bashkëpunim me ne.</p>

    <form name="application-form" action="#" onsubmit="return validateApplicationForm()" enctype="multipart/form-data">
        <!-- Përmbledhje Section -->
        <div class="form-section">
            <h3 class="section-title">Përmbledhje</h3>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox" id="titulli-inputBox">
                        <input type="text" name="your-titulli" required/>
                        <span class="text">Titulli *</span>
                        <span class="line" id="titulli-line"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="inputBox" id="autori-inputBox">
                        <input type="text" name="your-autori" required/>
                        <span class="text">Autori *</span>
                        <span class="line" id="autori-line"></span>
                    </div>
                </div>
            </div>
            
			<div class="row100 radio-group">
    <div class="col">
        <label class="radio-label">A është vënë në skenë më parë *</label>
        <div class="radio-options">
            <label class="radio-option">
                <input type="radio" name="your-skene" value="Po" checked>
                <span class="radio-custom"></span>
                <span class="radio-text">Po</span>
            </label>
            <label class="radio-option">
                <input type="radio" name="your-skene" value="Jo">
                <span class="radio-custom"></span>
                <span class="radio-text">Jo</span>
            </label>
        </div>
    </div>
</div>
        </div>

        <!-- Aplikanti Section -->
        <div class="form-section">
            <h3 class="section-title">Aplikanti</h3>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox" id="emri-inputBox">
                        <input type="text" name="your-emri" required/>
                        <span class="text">Emër *</span>
                        <span class="line" id="emri-line"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="inputBox" id="mbiemri-inputBox">
                        <input type="text" name="your-mbiemer" required/>
                        <span class="text">Mbiemër *</span>
                        <span class="line" id="mbiemri-line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox" id="tel-inputBox">
                        <input type="tel" name="your-tel" required/>
                        <span class="text">Tel/Cel *</span>
                        <span class="line" id="tel-line"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="inputBox" id="email-inputBox">
                        <input type="email" name="your-email" required/>
                        <span class="text">Email *</span>
                        <span class="line" id="email-line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox" id="zgjidh-inputBox">
                        <select name="your-zgjidh" required>
                            <option value="">Zgjidh *</option>
                            <option value="Regjizor">Regjizor</option>
                            <option value="Autor/Përkthyes">Autor/Përkthyes</option>
                            <option value="Grup artistësh">Grup artistësh</option>
                        </select>
                        <span class="line" id="zgjidh-line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100 checkbox-group">
                <div class="col">
                    <label>Publiku që targeton: *</label>
                    <div class="checkbox-options">
                        <label>
                            <input type="checkbox" name="your-target[]" value="Të rritur"> Të rritur
                        </label>
                        <label>
                            <input type="checkbox" name="your-target[]" value="Të rinj"> Të rinj
                        </label>
                        <label>
                            <input type="checkbox" name="your-target[]" value="Fëmijë"> Fëmijë
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-politika" required></textarea>
                        <span class="text">Si përputhet me politikat e teatrit *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Përshkrimi i projektit Section -->
        <div class="form-section">
            <h3 class="section-title">Përshkrimi i projektit</h3>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-stili" required></textarea>
                        <span class="text">Stili (Komedi, dramë, laborator, etj.) *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-sinopsis" required></textarea>
                        <span class="text">Sinopsis *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-vendndodhja" required></textarea>
                        <span class="text">Vendodhja (koha, vendi) *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-profili" required></textarea>
                        <span class="text">Profili i personazheve (numri, mosha, gjinia, etnia, aftësi të veçanta) *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-kerkesa" required></textarea>
                        <span class="text">Kërkesa teknike të veçanta *</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
            
            <div class="row100">
                <div class="col">
                    <div class="inputBox textarea">
                        <textarea name="your-komente"></textarea>
                        <span class="text">Komente shtesë</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materialet shoqëruese Section -->
        <div class="form-section">
            <h3 class="section-title">Materialet shoqëruese</h3>
            
			<div class="row100 file-upload">
    <div class="col">
        <div class="inputBox file-input">
            <span class="text">Teksti i veprës sipas formatit të kërkuar *</span>
            <label class="file-label">
                <span class="file-button">Zgjidhni Skedarin</span>
                <input type="file" name="your-teksti" accept=".doc,.docx" required/>
                <span class="file-name" id="teksti-file-name">Nuk është zgjedhur asnjë skedar</span>
            </label>
            <p class="info-text">Lejohen vetëm formatet doc dhe docx</p>
        </div>
    </div>
</div>
            <div class="row100 info-box">
                <div class="col">
                    <p class="info-text">Klikoni <a href="http://teatrimetropol.al/wp-content/uploads/2017/09/formative-pres-shembull.pdf" target="_blank">këtu</a> për të shkarkuar shembullin për formatin e tekstit për veprën.</p>
                </div>
            </div>
            
            <div class="row100 file-upload">
                <div class="col">
                    <div class="inputBox file-input">
                        <label class="file-label">
                            <span class="file-button">Zgjidhni Skedarin</span>
                            <input type="file" name="your-platform" accept=".doc,.docx" required/>
                            <span class="file-name" id="platform-file-name">Nuk është zgjedhur asnjë skedar</span>
                        </label>
                        <span class="text">Platforma regjisoriale *</span>
                        <p class="info-text">Ju lutemi përmbahuni informacionit të mësipërm. Lejohen vetëm formatet doc dhe docx</p>
                    </div>
                </div>
            </div>
            
            <div class="row100 file-upload">
                <div class="col">
                    <div class="inputBox file-input">
                        <label class="file-label">
                            <span class="file-button">Zgjidhni Skedarin</span>
                            <input type="file" name="your-cv" accept=".doc,.docx" required/>
                            <span class="file-name" id="cv-file-name">Nuk është zgjedhur asnjë skedar</span>
                        </label>
                        <span class="text">CV individuale *</span>
                    </div>
                </div>
            </div>
            
            <div class="row100 file-upload">
                <div class="col">
                    <div class="inputBox file-input">
                        <label class="file-label">
                            <span class="file-button">Zgjidhni Skedarin</span>
                            <input type="file" name="your-portofoli" accept=".doc,.docx,.pdf" required/>
                            <span class="file-name" id="portofoli-file-name">Nuk është zgjedhur asnjë skedar</span>
                        </label>
                        <span class="text">Portofoli i punëve *</span>
                        <p class="info-text">Lejohen vetëm formatet doc, docx dhe pdf</p>
                    </div>
                </div>
            </div>
            
            <div class="row100 file-upload">
                <div class="col">
                    <div class="inputBox file-input">
                        <label class="file-label">
                            <span class="file-button">Zgjidhni Skedarin</span>
                            <input type="file" name="your-motivimi" accept=".doc,.docx,.pdf" required/>
                            <span class="file-name" id="motivimi-file-name">Nuk është zgjedhur asnjë skedar</span>
                        </label>
                        <span class="text">Letër motivimi *</span>
                        <p class="info-text">Lejohen vetëm formatet doc, docx dhe pdf</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row100">
            <div class="col">
                <div class="submitbutton">
                    <button class="btn submitbtn" type="submit">Dërgo Aplikimin</button>
                </div>
            </div>
        </div>
    </form>
</div>



<!-- JavaScript for Applications Page -->
<script type="text/javascript" src="../../assets/js/as-alert-message.min.js"></script>
<script>
// File input display
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Nuk është zgjedhur asnjë skedar';
        const id = this.getAttribute('name') + '-file-name';
        if(document.getElementById(id)) {
            document.getElementById(id).textContent = fileName;
        }
    });
});

// Form validation
function validateApplicationForm() {
    let isValid = true;
    
    // Validate required fields
    const requiredFields = [
        'your-titulli', 'your-autori', 'your-skene', 
        'your-emri', 'your-mbiemer', 'your-tel', 'your-email',
        'your-zgjidh', 'your-politika', 'your-stili', 'your-sinopsis',
        'your-vendndodhja', 'your-profili', 'your-kerkesa',
        'your-teksti', 'your-platform', 'your-cv', 'your-portofoli', 'your-motivimi'
    ];
    
    requiredFields.forEach(field => {
        const element = document.forms["application-form"][field];
        if (!element || 
            (element.type === 'file' && !element.files.length) ||
            (element.type === 'text' && !element.value) ||
            (element.type === 'textarea' && !element.value) ||
            (element.type === 'select-one' && !element.value)) {
            showError(field, 'Kjo fushë është e detyrueshme');
            isValid = false;
        }
    });
    
    // Validate at least one checkbox is checked
    const checkboxes = document.querySelectorAll('input[name="your-target[]"]:checked');
    if (checkboxes.length === 0) {
        showError('your-target', 'Zgjidhni të paktën një opsion');
        isValid = false;
    }
    
    // Validate file types
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        if (input.files.length > 0) {
            const fileName = input.files[0].name;
            const fileExt = fileName.split('.').pop().toLowerCase();
            const allowedExts = input.getAttribute('accept').replace('.', '').split(',');
            
            if (!allowedExts.includes(fileExt)) {
                showError(input.name, 'Format i gabuar i skedarit. Lejohen vetëm: ' + allowedExts.join(', '));
                isValid = false;
            }
        }
    });
    
    if (isValid) {
        // Show success message
        ASAlertMessage.success({
            title: 'Aplikimi u dërgua!',
            message: 'Faleminderit për aplikimin. Do ju kontaktojmë së shpejti.',
            delay: 5000
        });
    }
    
    return isValid;
}

function showError(fieldId, message) {
    console.error(`Error in ${fieldId}: ${message}`);
    // You can use ASAlertMessage.error() here if you want to show error popups
}

// Animation functions from contact page
function triggerAnim(inputId) {
    const line = document.getElementById(inputId + '-line');
    const inputBox = document.getElementById(inputId + '-inputBox');
    if (line) line.style.width = '100%';
    if (inputBox) inputBox.classList.add('focus');
}

document.querySelectorAll('.inputBox input, .inputBox textarea, .inputBox select').forEach(input => {
    input.addEventListener('focus', function() {
        triggerAnim(this.getAttribute('name'));
    });
    
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
