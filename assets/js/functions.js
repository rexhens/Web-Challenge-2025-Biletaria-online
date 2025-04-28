const isValidNameOrSurname = (element) => {
    return /^[a-zA-ZëËçÇ ]+$/.test(element.value.trim());
}

const isValidEmail = (element) => {
    return /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(element.value.trim());
}

const isValidPhoneNumber = (element) => {
    return /^\+?[0-9\s\-\(\)]+$/.test(element.value.trim());
}

const isValidPassword = (element) => {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^_\-+=<>])[A-Za-z\d@$!%*?&#^_\-+=<>]{8,}$/.test(element.value.trim());
}

const checkEqualityOfPasswords = (pass, confPass) => {
    return pass.value.trim() === confPass.value.trim();
}

const showError = (elementError) => {
    elementError.classList.add("show");
    setTimeout(() => elementError.classList.remove("show"), 4500);
}

function redirectTo(page) {
    window.location.href = page;
}

function toggleMenu() {
    document.querySelector(".menu-bar").classList.toggle("open");
}

function searchShow() {
    let input = document.getElementById('search').value.toLowerCase();
    let shows = document.querySelectorAll('.show-card');

    shows.forEach(function (show) {
        let title = show.querySelector('h3').textContent.toLowerCase();
        if (title.includes(input)) {
            show.style.display = "";
        } else {
            show.style.display = "none";
        }
    });
}

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('in-view');
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1
});

function togglePassword() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.querySelector('#password-icon i');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

function toggleConfirmPassword() {
    const passwordField = document.getElementById('password-confirm');
    const eyeIcon = document.querySelector('#password-confirm-icon i');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}