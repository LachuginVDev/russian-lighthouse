export function initContactForm() {
  const form = document.querySelector('[data-contact-form]');
  if (!form) return;

  const status = form.querySelector('[data-form-status]');

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    if (!form.checkValidity()) {
      if (status) status.textContent = 'Пожалуйста, заполните обязательные поля.';
      return;
    }

    if (status) status.textContent = 'Спасибо! Сообщение отправлено, мы ответим в ближайшее время.';
    form.reset();
  });
}
