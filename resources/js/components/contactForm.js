export function initContactForm() {
  const form = document.querySelector('[data-contact-form]');
  if (!form) return;

  const status = form.querySelector('[data-form-status]');
  const submitBtn = form.querySelector('[type="submit"]');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!form.checkValidity()) {
      if (status) status.textContent = 'Пожалуйста, заполните обязательные поля.';
      return;
    }

    const payload = {
      name: form.querySelector('[name="name"]')?.value?.trim() || '',
      email: form.querySelector('[name="email"]')?.value?.trim() || '',
      message: form.querySelector('[name="message"]')?.value?.trim() || '',
      consent: Boolean(form.querySelector('[name="consent"]')?.checked),
    };

    if (status) status.textContent = 'Отправляем…';
    if (submitBtn) submitBtn.disabled = true;

    try {
      const response = await fetch('/api/v1/contact', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
      });

      const data = await response.json().catch(() => ({}));

      if (!response.ok) {
        const firstError = data?.errors
          ? Object.values(data.errors).flat()[0]
          : null;
        throw new Error(firstError || data?.message || 'Не удалось отправить сообщение.');
      }

      if (status) {
        status.textContent = data?.data?.message
          || 'Спасибо! Сообщение отправлено, мы ответим в ближайшее время.';
      }
      form.reset();
    } catch (error) {
      if (status) {
        status.textContent = error instanceof Error
          ? error.message
          : 'Ошибка отправки. Попробуйте позже.';
      }
    } finally {
      if (submitBtn) submitBtn.disabled = false;
    }
  });
}
