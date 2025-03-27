function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPassword(password) {
    // At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
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
        $('#passwordErr').text("Password must be at least 8 characters, include uppercase, lowercase, number, and special character.");
        isValid = false;
    }

    if (fields.confirm !== undefined && fields.password !== fields.confirm) {
        $('#confirmErr').text("Passwords do not match.");
        isValid = false;
    }

    return isValid;
}

//  Live validation handler (triggered on blur or input)
$(document).ready(function () {
    $('#password').on('input blur', function () {
        const password = $(this).val();
        if (!isValidPassword(password)) {
            $('#passwordErr').text("Weak password. Must include uppercase, lowercase, number, special character, and be at least 8 characters.");
        } else {
            $('#passwordErr').text('');
        }
    });

    $('#confirm').on('input blur', function () {
        const confirm = $(this).val();
        const password = $('#password').val();
        if (confirm !== password) {
            $('#confirmErr').text("Passwords do not match.");
        } else {
            $('#confirmErr').text('');
        }
    });
});
