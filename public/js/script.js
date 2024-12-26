function validatePassword() {
    const password = document.getElementById('password').value;
    const message = document.getElementById('passwordMessage');
    const lengthRequirement = /.{12,}/;
    const uppercaseRequirement = /[A-Z]/;
    const lowercaseRequirement = /[a-z]/;
    const numberRequirement = /\d/;
    const specialCharRequirement = /[\W_]/;

    let messages = [];

    if (!lengthRequirement.test(password)) {
        messages.push('Password must be at least 12 characters long.');
    }
    if (!uppercaseRequirement.test(password)) {
        messages.push('Password must contain at least one uppercase letter.');
    }
    if (!lowercaseRequirement.test(password)) {
        messages.push('Password must contain at least one lowercase letter.');
    }
    if (!numberRequirement.test(password)) {
        messages.push('Password must contain at least one number.');
    }
    if (!specialCharRequirement.test(password)) {
        messages.push('Password must contain at least one special character.');
    }

    if (messages.length === 0) {
        message.innerHTML = '<span style="color: green;">Password is valid</span>';
    } else {
        message.innerHTML = '<ul style="color: red;"><li>' + messages.join('</li><li>') + '</li></ul>';
    }
}