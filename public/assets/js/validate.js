/**
 * Small, reusable client-side form validation.
 * Usage: SPValidate.attach(formEl, {
 *   fieldName: [{ required: true, message: '...' }, { email: true }, ...]
 * });
 */
(function () {

    function setError(input, message) {
        clearError(input);

        if (!message) return;

        input.classList.add('input-error');

        var span = document.createElement('span');
        span.className = 'field-error';
        span.textContent = message;

        input.insertAdjacentElement('afterend', span);
    }

    function clearError(input) {
        input.classList.remove('input-error');

        var next = input.nextElementSibling;

        if (next && next.classList.contains('field-error')) {
            next.remove();
        }
    }

    function isEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function validateField(form, input, rules) {
        var value = input.value.trim();

        for (var i = 0; i < rules.length; i++) {
            var rule = rules[i];

            if (rule.required && value === '') {
                setError(input, rule.message || 'This field is required.');
                return false;
            }

            if (rule.email && value !== '' && !isEmail(value)) {
                setError(input, rule.message || 'Enter a valid email address.');
                return false;
            }

            if (rule.minLength && value !== '' && value.length < rule.minLength) {
                setError(input, rule.message || 'Must be at least ' + rule.minLength + ' characters.');
                return false;
            }

            if (rule.min !== undefined && value !== '' && Number(value) < rule.min) {
                setError(input, rule.message || 'Must be at least ' + rule.min + '.');
                return false;
            }

            if (rule.match && value !== form.elements[rule.match].value.trim()) {
                setError(input, rule.message || 'Values do not match.');
                return false;
            }
        }

        clearError(input);
        return true;
    }

    function attach(form, fieldRules) {
        if (!form) return;

        var names = Object.keys(fieldRules);

        names.forEach(function (name) {
            var input = form.elements[name];
            if (!input) return;

            input.addEventListener('blur', function () {
                validateField(form, input, fieldRules[name]);
            });
        });

        form.addEventListener('submit', function (e) {
            var valid = true;

            names.forEach(function (name) {
                var input = form.elements[name];
                if (!input) return;

                if (!validateField(form, input, fieldRules[name])) {
                    valid = false;
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    window.SPValidate = { attach: attach };

})();
