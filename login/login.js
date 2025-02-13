function validateForm() {
    let username = document.getElementById('username').value.trim();
    let password = document.getElementById('password').value.trim();
    let usernameError = document.getElementById('username-error');
    let passwordError = document.getElementById('password-error');

    usernameError.textContent = "";
    passwordError.textContent = "";

    // Hardcoded credentials
    const validUsername = "admin";
    const validPassword = "admin123";

    if (username !== validUsername) {
        usernameError.textContent = "Invalid username.";
        return false; // Stop form submission
    }

    if (password !== validPassword) {
        passwordError.textContent = "Invalid password.";
        return false; // Stop form submission
    }

    return true; // Allow form submission
}
