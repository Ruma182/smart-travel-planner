document.addEventListener('DOMContentLoaded', function () {

    function showMessage(message, success) {
        let box = document.getElementById('ajax-message');

        if (!box) {
            box = document.createElement('div');
            box.id = 'ajax-message';
            document.body.appendChild(box);
        }

        box.textContent = message;
        box.className = success ? 'toast success' : 'toast error';

        setTimeout(function () {
            box.classList.add('hide');
        }, 2600);
    }

    document.querySelectorAll('.ajax-form').forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            if (form.dataset.confirm && !confirm(form.dataset.confirm)) {
                return;
            }

            const button = form.querySelector('button[type="submit"], button:not([type])');
            if (button) {
                button.disabled = true;
                button.dataset.oldText = button.textContent;
                button.textContent = 'Please wait...';
            }

            try {
                const response = await fetch('ajax.php', {
                    method: 'POST',
                    body: new FormData(form)
                });

                const data = await response.json();

                showMessage(data.message || 'Done.', !!data.success);

                if (data.success) {
                    setTimeout(function () {
                        window.location.reload();
                    }, 450);
                } else if (button) {
                    button.disabled = false;
                    button.textContent = button.dataset.oldText;
                }
            } catch (error) {
                showMessage('AJAX request failed. Please try again.', false);

                if (button) {
                    button.disabled = false;
                    button.textContent = button.dataset.oldText;
                }
            }
        });
    });

    document.querySelectorAll('.edit-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const item = button.closest('.item');

            if (!item) return;

            item.classList.toggle('editing');

            if (item.classList.contains('editing')) {
                button.textContent = 'Cancel';
            } else {
                button.textContent = 'Edit';
            }
        });
    });

    const categorySelect = document.querySelector('#recommendation-category');

    if (categorySelect) {
        fetch('ajax.php?action=get_config')
            .then(response => response.json())
            .then(result => {
                if (!result.success || !result.data || !result.data.categories) return;

                const current = categorySelect.dataset.current || '';

                categorySelect.innerHTML = '<option value="">Select Category</option>';

                result.data.categories.forEach(function (category) {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category;
                    if (category === current) option.selected = true;
                    categorySelect.appendChild(option);
                });
            })
            .catch(function () {
                // Keep the normal select box usable if JSON loading fails.
            });
    }

    const menuButton = document.querySelector('.mobile-menu');

    if (menuButton) {
        menuButton.addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    }
});
