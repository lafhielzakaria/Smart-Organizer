const Validate_Rules = {
    name: {
        regex: /^[A-Za-zÀ-ÖØ-öø-ÿ\s'\-]{3,}$/,
        errormessage: "Invalid name (minimum 3 characters)"
    },
    type: {
        errormessage: "Please select a type"
    },
    capacity: {
        regex: /^[1-9][0-9]*$/,
        errormessage: "Invalid capacity (must be positive number)"
    },
    city: {
        regex: /^[A-Za-zÀ-ÖØ-öø-ÿ\s'\-]{2,}$/,
        errormessage: "Invalid city name"
    },
    andreas: {
        regex: /^.{5,}$/,
        errormessage: "Invalid address (minimum 5 characters)"
    },
    price: {
        regex: /^[1-9][0-9]*$/,
        errormessage: "Invalid price (must be positive number)"
    },
    description: {
        regex: /^.{10,}$/,
        errormessage: "Description too short (minimum 10 characters)"
    }
};

function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('.form-input, .form-select');
    let wronginput = 0;

    inputs.forEach(input => {
        const value = input.value.trim();
        const fieldName = input.name;
        const rule = Validate_Rules[fieldName];

        if (!rule) return;

        let errorDiv = input.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('error-message')) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-500 text-xs mt-1 hidden';
            input.parentNode.appendChild(errorDiv);
        }

        if (input.tagName === 'SELECT') {
            if (!value) {
                input.style.border = '2px solid #ff6b6b';
                errorDiv.textContent = rule.errormessage;
                errorDiv.classList.remove('hidden');
                wronginput++;
            } else {
                input.style.border = '1px solid rgba(255,255,255,0.14)';
                errorDiv.classList.add('hidden');
            }
        } else if (rule.regex) {
            if (!value.match(rule.regex)) {
                input.style.border = '2px solid #ff6b6b';
                errorDiv.textContent = rule.errormessage;
                errorDiv.classList.remove('hidden');
                wronginput++;
            } else {
                input.style.border = '1px solid rgba(255,255,255,0.14)';
                errorDiv.classList.add('hidden');
            }
        }
    });

    return wronginput;
}

window.openModal = function(id) {
    document.getElementById(id).style.display = 'flex';
    const form = document.querySelector(`#${id} form`);
    if (form) {
        form.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.addEventListener('input', function() {
                const errorDiv = this.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('error-message')) {
                    this.style.border = '1px solid rgba(255,255,255,0.14)';
                    errorDiv.classList.add('hidden');
                }
            });
        });
    }
};

window.closeModal = function(id) {
    document.getElementById(id).style.display = 'none';
    if (id === 'local-modal') {
        const imageInput = document.getElementById('imageInput');
        const fileName = document.getElementById('fileName');
        const wrapper = document.getElementById('fileUploadWrapper');
        if (imageInput) imageInput.value = '';
        if (fileName) fileName.textContent = '';
        if (wrapper) wrapper.classList.remove('has-file');
    }
    const form = document.querySelector(`#${id} form`);
    if (form) {
        form.reset();
        form.querySelectorAll('.form-input, .form-select').forEach(input => {
            input.value = '';
            input.style.border = '';
            const errorDiv = input.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('error-message')) {
                errorDiv.textContent = '';
                errorDiv.classList.add('hidden');
            }
        });
    }
};

window.handleFileSelect = function(input) {
    const wrapper = document.getElementById('fileUploadWrapper');
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        wrapper.classList.add('has-file');
    } else {
        fileName.textContent = '';
        wrapper.classList.remove('has-file');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const localForm = document.querySelector('#local-modal form');
    if (localForm) {
        localForm.addEventListener('submit', function(e) {
            const errors = validateForm('local-modal');
            if (errors > 0) {
                e.preventDefault();
                return false;
            }
        });
    }

    const offerForm = document.querySelector('#offer-modal form');
    if (offerForm) {
        offerForm.addEventListener('submit', function(e) {
            const errors = validateForm('offer-modal');
            if (errors > 0) {
                e.preventDefault();
                return false;
            }
        });
    }
});
