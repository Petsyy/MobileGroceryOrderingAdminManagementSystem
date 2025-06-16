function validateForm() {
  let username = document.getElementById("username").value.trim();
  let password = document.getElementById("password").value.trim();
  let usernameError = document.getElementById("username-error");
  let passwordError = document.getElementById("password-error");

  usernameError.textContent = "";
  passwordError.textContent = "";

  if (username === "") {
    usernameError.textContent = "Username is required.";
    return false;
  }

  if (password === "") {
    passwordError.textContent = "Password is required.";
    return false;
  }

  return true; // Allow form submission
}
