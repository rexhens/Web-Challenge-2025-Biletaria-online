const signupForm = document.getElementById("signup-form");
const name = document.getElementById("name");
const nameError = document.getElementById("name-error");
const surname = document.getElementById("surname");
const surnameError = document.getElementById("surname-error");
const email = document.getElementById("email");
const emailError = document.getElementById("email-error");
const phone = document.getElementById("phone");
const phoneError = document.getElementById("phone-error");
const password = document.getElementById("password");
const passwordError = document.getElementById("password-error");
const passwordConfirm = document.getElementById("password-confirm");
const passwordConfirmError = document.getElementById("password-confirm-error");

const validateSignupForm = (event) => {

    if(!isValidNameOrSurname(name)) {
        showError(nameError);
        event.preventDefault();
    }

    if(!isValidNameOrSurname(surname)) {
        showError(surnameError);
        event.preventDefault();
    }

    if(!isValidEmail(email)) {
        showError(emailError);
        event.preventDefault();
    }

    if(!isValidPhoneNumber(phone)) {
        showError(phoneError);
        event.preventDefault();
    }

    if(!isValidPassword(password)) {
        showError(passwordError);
        event.preventDefault();
    }

    if(!checkEqualityOfPasswords(password, passwordConfirm)) {
        showError(passwordConfirmError);
        event.preventDefault();
    }
}

signupForm.addEventListener("submit", validateSignupForm);