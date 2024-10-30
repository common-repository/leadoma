const leadoma_password_show_hide = (eyeElement) => {
  if (!eyeElement) return;
  const eyeIcon = "bi-eye";
  const eyeSlashIcon = "bi-eye-slash";
  const element = eyeElement.previousElementSibling;
  if (!element) return;
  element.type = (element.type === "password") ? "text" : "password";
  eyeElement.classList.toggle(eyeIcon);
  eyeElement.classList.toggle(eyeSlashIcon);
}

jQuery(document).ready(function () {
  jQuery('input[type="checkbox"].support-enter').on('keypress', function (event) {
    if (event.which === 13) {
      this.checked = !this.checked;
    }
  });
});