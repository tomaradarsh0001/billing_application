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
        document.getElementById('customConfirmationMessage').innerText = message;
        $('#ModalDelete').modal('show');
        $('#confirmDelete').off('click').on('click', function() {
        $('#deleteForm-' + itemId).submit();
    });
}
