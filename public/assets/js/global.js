document.addEventListener('DOMContentLoaded', function () {
  const errorElement = document.getElementById('serverError');
  const messageElement = document.getElementById('serverMessage');

  if (errorElement) {
    setTimeout(() => {
      errorElement.style.transition = 'opacity 0.5s ease';
      errorElement.style.opacity = '0';
      setTimeout(() => {
        errorElement.remove();
      }, 500);
    }, 3000);
  }

  if (messageElement) {
    setTimeout(() => {
      messageElement.style.transition = 'opacity 0.5s ease';
      messageElement.style.opacity = '0';
      setTimeout(() => {
        messageElement.remove();
      }, 500);
    }, 3000);
  }
});
