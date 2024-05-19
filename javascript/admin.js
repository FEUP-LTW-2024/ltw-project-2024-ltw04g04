document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.admin-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const formData = new FormData(form);
            formData.append('action', form.getAttribute('data-action'));
            
            fetch('../actions/action_make_admin.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const userId = form.querySelector('input[name="user_id"]').value;
                    const userElement = document.getElementById('user-' + userId);
                    updateUserInfo(userElement, data.user);
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function updateUserInfo(userElement, user) {
        const adminActionDiv = userElement.querySelector('.admin-action');
        const newAdminForm = document.createElement('form');
        newAdminForm.classList.add('admin-form');
        newAdminForm.setAttribute('data-action', user.isAdmin ? 'remove_admin' : 'make_admin');

        newAdminForm.innerHTML = `
            <input type="hidden" name="csrf" value="${user.csrf}">
            <input type="hidden" name="user_id" value="${user.id}">
            <input type="submit" value="${user.isAdmin ? 'Remove Admin' : 'Make Admin'}" class="${user.isAdmin ? 'remove-admin' : 'make-admin'}">
        `;

        adminActionDiv.innerHTML = '';
        adminActionDiv.appendChild(newAdminForm);

        newAdminForm.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const formData = new FormData(newAdminForm);
            formData.append('action', newAdminForm.getAttribute('data-action'));
            
            fetch('../actions/action_make_admin.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateUserInfo(userElement, data.user);
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});