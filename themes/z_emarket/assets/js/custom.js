/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */

document.addEventListener('DOMContentLoaded', function () {
  const signInRadio = document.getElementById('sign-in');
  const continueGuestRadio = document.getElementById('continue-guest');
  const signInForm = document.querySelector('.sign-in-form');
  const guestForm = document.querySelector('.guest-form');

  signInRadio.addEventListener('change', function () {
    if (signInRadio.checked) {
      signInForm.style.display = 'block';
      guestForm.style.display = 'none';
    }
  });

  continueGuestRadio.addEventListener('change', function () {
    if (continueGuestRadio.checked) {
      signInForm.style.display = 'none';
      guestForm.style.display = 'block';
    }
  });
});

