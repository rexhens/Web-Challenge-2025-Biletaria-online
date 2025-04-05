const changePasswordForm = document.getElementById("change-password-form");
const email = document.getElementById("email");
const emailError = document.getElementById("email-error");
const password = document.getElementById("password");
const passwordError = document.getElementById("password-error");
const passwordConfirm = document.getElementById("password-confirm");
const passwordConfirmError = document.getElementById("password-confirm-error");

const validateChangePasswordForm = (event) => {

    if(!isValidEmail(email)) {
        showError(emailError);
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

changePasswordForm.addEventListener("submit", validateChangePasswordForm);