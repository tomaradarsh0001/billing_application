// Alert Box Code 
document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 780);
        }, 2500);
    });
});

function confirmDelete(itemType, itemId) {
    let message = '';
        if (itemType === 'user') {
        message = 'Are you sure you want to delete this user?';
    } else if (itemType === 'permission') {
        message = 'Are you sure you want to delete this permission?';
    } else if (itemType === 'role') {
        message = 'Are you sure you want to delete this role?';
    }
    else if (itemType === 'configuration') {
        message = 'Are you sure you want to delete this Configuration?';
    }
    else if (itemType === 'customer') {
        message = 'Are you sure you want to delete this Customer?';
    }
    else if (itemType === 'occupant') {
        message = 'Are you sure you want to delete this Occupant?';
    }
    else if (itemType === 'house') {
        message = 'Are you sure you want to delete this House Detail?';
    }
    else if (itemType === 'billing_detail') {
        message = 'Are you sure you want to delete this Bill Detail?';
    }
        document.getElementById('customConfirmationMessage').innerText = message;
        $('#ModalDelete').modal('show');
        $('#confirmDelete').off('click').on('click', function() {
        $('#deleteForm-' + itemId).submit();
    });
}

// AAdhar, PAN & Phone Number Validations
function validateInput(inputId, regex) {
    const input = document.getElementById(inputId);
    const errorMessage = document.getElementById(inputId + '-error');

    if (regex.test(input.value)) {
        errorMessage.style.display = 'none';
        input.classList.remove('is-invalid');
        return true;
    } else {
        errorMessage.style.display = 'block';
        input.classList.add('is-invalid');
        return false;
    }
}

function restrictToNumbers(inputId) {
    const input = document.getElementById(inputId);
    input.addEventListener('input', function () {
        input.value = input.value.replace(/\D/g, ''); 
    });
}

function toggleSubmitButton() {
    const isPhoneValid = validateInput('phone_number', /^\d{10}$/);
    const isAadharValid = validateInput('aadhar_number', /^\d{12}$/);
    const isPanValid = /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(document.getElementById('pan_number').value);

    const submitButton = document.getElementById('submit-button');
    if (isPhoneValid && isAadharValid && isPanValid) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const phoneInput = document.getElementById('phone_number');
    phoneInput.addEventListener('input', function () {
        if (phoneInput.value.length > 0) {
            validateInput('phone_number', /^\d{10}$/);
        }
        toggleSubmitButton();
    });

    const aadharInput = document.getElementById('aadhar_number');
    aadharInput.addEventListener('input', function () {
        if (aadharInput.value.length > 0) {
            validateInput('aadhar_number', /^\d{12}$/);
        }
        toggleSubmitButton();
    });

    const panInput = document.getElementById('pan_number');
    panInput.addEventListener('input', function (e) {
        let input = e.target.value.toUpperCase(); 
        let formattedInput = '';

        for (let i = 0; i < input.length; i++) {
            const char = input[i];

            if (i < 5 && /^[A-Z]$/.test(char)) {
                formattedInput += char;
            } else if (i >= 5 && i < 9 && /^\d$/.test(char)) {
                formattedInput += char;
            } else if (i === 9 && /^[A-Z]$/.test(char)) {
                formattedInput += char;
            }
        }

        panInput.value = formattedInput;

        const isValid = validateInput('pan_number', /^[A-Z]{5}\d{4}[A-Z]{1}$/);
        toggleSubmitButton();

        const errorMessage = document.getElementById('pan_number-error');
        if (isValid) {
            errorMessage.style.display = 'none';
        } else {
            errorMessage.style.display = 'block';
        }
    });

    restrictToNumbers('phone_number');
    restrictToNumbers('aadhar_number');
});
