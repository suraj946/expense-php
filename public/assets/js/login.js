document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');

  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/; 
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
  
  function validateEmail() {
    if (emailInput.value.trim() === '') {
      emailError.textContent = 'Email is required';
      return false;
    } else if (!emailRegex.test(emailInput.value)) {
      emailError.textContent = 'Please enter a valid email address';
      return false;
    } else {
      emailError.textContent = '';
      return true;
    }
  }

  function validatePassword() {
    if (passwordInput.value.trim() === '') {
      passwordError.textContent = 'Password is required';
      return false;
    } else if (!passwordRegex.test(passwordInput.value)) {
      passwordError.textContent =
        'Password must be at least 6 characters long and include a letter, a number, and a special character.';
      return false;
    } else {
      passwordError.textContent = '';
      return true;
    }
  }

  emailInput.addEventListener('input', validateEmail);
  passwordInput.addEventListener('input', validatePassword);

  form.addEventListener('submit', function (event) {
    const emailValid = validateEmail();
    const passworValid = validatePassword();
    if (!emailValid || !passworValid) {
      event.preventDefault();
    }
  });
});
