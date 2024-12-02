document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('signupForm');
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const nameError = document.getElementById('nameError');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');

  const nameRegex = /^[A-Za-z ]{3,50}$/; 
  const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/;
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;

  function validateName() {
    if(nameInput.value.trim() === '') {
      nameError.textContent = 'Name is required';
      return false;
    }
    else if (!nameRegex.test(nameInput.value)) {
      nameError.textContent = 'Name must be between 3 and 50 characters and contain only letters';
      return false;
    } else {
      nameError.textContent = '';
      return true;
    }
  }


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
        'Password must be at least 6 characters long and include a letter and a number.';
      return false;
    } else {
      passwordError.textContent = '';
      return true;
    }
  }

  nameInput.addEventListener('input', validateName);
  emailInput.addEventListener('input', validateEmail);
  passwordInput.addEventListener('input', validatePassword);

  form.addEventListener('submit', function (event) {
    const nameValid = validateName();
    const emailValid = validateEmail();
    const passwordValid = validatePassword();

    if (!nameValid || !emailValid || !passwordValid) {
      event.preventDefault();
    }
  });
});
