const isValidNameOrSurname = (element) => {
    return /^[a-zA-Z\s]+$/.test(element.value.trim());
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