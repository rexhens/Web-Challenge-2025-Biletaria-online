const loginForm = document.getElementById("login-form");
const email = document.getElementById("email");
const emailError = document.getElementById("email-error");

const validateLoginForm = (event) => {

    if(!isValidEmail(email)) {
        showError(emailError);
        event.preventDefault();
    }

}

loginForm.addEventListener("submit", validateLoginForm);