/**
 * AJAX/JSON layer for the Listings CRUD pages.
 *
 * This does NOT change any existing server-side behaviour: every endpoint
 * (add_listing.php, edit_listing.php, delete_listing.php, listings.php)
 * still works exactly as before for plain browser requests. This script
 * simply sends the same requests with an "X-Requested-With: XMLHttpRequest"
 * header, which the controllers detect and respond to with JSON instead of
 * an HTML redirect/render, so the page can update itself without a full
 * reload. If JavaScript is unavailable, the forms/links fall back to the
 * original full-page behaviour untouched.
 */
(function () {

    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    function ajaxFetch(url, options) {
        options = options || {};
        options.headers = Object.assign(
            { 'X-Requested-With': 'XMLHttpRequest' },
            options.headers || {}
        );

        return fetch(url, options).then(function (res) {
            return res.json().then(function (data) {
                return { ok: res.ok, status: res.status, data: data };
            });
        });
    }

    function showMessage(container, type, text) {
        if (!container) return;

        var other = container.querySelector(
            '.alert.' + (type === 'success' ? 'danger' : 'success')
        );
        if (other) other.remove();

        var alert = container.querySelector('.alert.' + type);
        if (!alert) {
            alert = document.createElement('div');
            alert.className = 'alert ' + type;
            container.insertBefore(alert, container.firstChild);
        }
        alert.textContent = text;
    }

    // ---------------------------------------------------------------
    // Listings index page: delete a listing without leaving the page
    // ---------------------------------------------------------------
    ready(function () {
        var content = document.querySelector('.content');
        if (!content || !content.querySelector('.grid-list')) return;

        content.addEventListener('click', function (e) {
            var link = e.target.closest('.delete-listing');
            if (!link) return;

            e.preventDefault();

            var message = link.getAttribute('data-confirm') || 'Are you sure?';
            if (!window.confirm(message)) return;

            ajaxFetch(link.getAttribute('href'), { method: 'GET' })
                .then(function (result) {
                    if (result.data && result.data.success) {
                        var card = link.closest('.listing-card');
                        if (card) card.remove();

                        showMessage(
                            content,
                            'success',
                            result.data.message || 'Listing deleted successfully'
                        );
                    } else {
                        showMessage(
                            content,
                            'danger',
                            (result.data && result.data.error) || 'Could not delete listing.'
                        );
                    }
                })
                .catch(function () {
                    showMessage(content, 'danger', 'Network error while deleting the listing.');
                });
        });
    });

    // ---------------------------------------------------------------
    // Add / Edit listing forms: submit via fetch, expect JSON back
    // ---------------------------------------------------------------
    function attachAjaxForm(formId) {
        ready(function () {
            var form = document.getElementById(formId);
            if (!form) return;

            form.addEventListener('submit', function (e) {
                // Existing SPValidate client-side validation runs first
                // (it's attached before this script). If it already
                // prevented the submit because of an invalid field, do
                // nothing extra here.
                if (e.defaultPrevented) return;

                e.preventDefault();

                var formData = new FormData(form);
                var card = form.closest('.card');
                var submitBtn = form.querySelector('button[type="submit"]');
                var originalLabel = submitBtn ? submitBtn.textContent : null;

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Saving...';
                }

                ajaxFetch(form.getAttribute('action') || window.location.href, {
                    method: 'POST',
                    body: formData,
                })
                    .then(function (result) {
                        if (result.data && result.data.success) {
                            window.location.href =
                                'listings.php?msg=' +
                                encodeURIComponent(result.data.message || 'Saved successfully');
                            return;
                        }

                        showMessage(
                            card,
                            'danger',
                            (result.data && result.data.error) || 'Something went wrong.'
                        );
                    })
                    .catch(function () {
                        showMessage(card, 'danger', 'Network error while saving the listing.');
                    })
                    .finally(function () {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = originalLabel;
                        }
                    });
            });
        });
    }

    attachAjaxForm('addListingForm');
    attachAjaxForm('editListingForm');

    window.SPListingsAjax = { attachAjaxForm: attachAjaxForm };

})();
