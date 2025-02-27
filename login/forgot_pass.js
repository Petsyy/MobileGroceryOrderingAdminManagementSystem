function validateForm() {
    let newPassword = document.getElementById("new_password").value;
    let confirmPassword = document.getElementById("confirm_password").value;

    if (newPassword !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}