function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPassword(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?#&]).{8,}$/;
    return regex.test(password);
}

function validateForm(fields) {
    let isValid = true;
    $('.error').text('');

    if (fields.name !== undefined && !fields.name.trim()) {
        $('#nameErr').text("Name is required.");
        isValid = false;
    }

    if (!fields.email || !validateEmail(fields.email)) {
        $('#emailErr').text("Valid email is required.");
        isValid = false;
    }

    if (!fields.password || !isValidPassword(fields.password)) {
        $('#passwordErr').text("Password must be at least 8 characters with uppercase, lowercase, number, and special character.");
        isValid = false;
    }

    if (fields.confirm !== undefined && fields.password !== fields.confirm) {
        $('#confirmErr').text("Passwords do not match.");
        isValid = false;
    }

    return isValid;
}