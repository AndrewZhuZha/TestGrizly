const langBtn = document.querySelector('.lang-btn');
const langMenu = document.querySelector('.lang-menu');

langBtn.addEventListener('click', () => {
  const expanded = langBtn.getAttribute('aria-expanded') === 'true';
  langBtn.setAttribute('aria-expanded', String(!expanded));
  langMenu.hidden = expanded;
});

document.addEventListener('DOMContentLoaded', () => {
  const form         = document.getElementById('offerForm');
  if (!form) return;

  const submitBtn    = document.getElementById('submitBtn');
  const addPhoneBtn  = document.getElementById('addPhone');
  const phonesWrap   = document.getElementById('phones');
  const phoneError   = document.getElementById('phoneError');
  const about        = document.getElementById('about');
  const aboutCounter = document.getElementById('aboutCounter');

  /* ---------- HELPERS ---------- */
  const showError = (field, msg) => {
    const errorDiv = field.closest('.field')?.querySelector('.error');
    if (errorDiv) errorDiv.textContent = msg || '';
    if (msg) {
      field.classList.add('invalid');
    } else {
      field.classList.remove('invalid');
    }
  };

  const updateCounter = () => {
    if (!about || !aboutCounter) return;
    if (about.value.length > 500) {
      about.value = about.value.slice(0, 500);
    }
    aboutCounter.textContent = `${about.value.length} / 500`;
  };

  const validateForm = () => {
    let valid = true;

    // обязательные поля
    form.querySelectorAll('[required]').forEach(field => {
      if (field.type === 'checkbox' && !field.checked) {
        showError(field, 'Необходимо согласие');
        valid = false;
      } else if (!field.value.trim()) {
        showError(field, 'Поле обязательно');
        valid = false;
      } else {
        showError(field, '');
      }
    });

    // email
    const emailField = form.querySelector('[name="email"]');
    if (emailField) {
      const emailValue = emailField.value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (emailValue && !emailRegex.test(emailValue)) {
        showError(emailField, 'Некорректный email');
        valid = false;
      } else if (emailValue) {
        showError(emailField, '');
      }
    }

    // телефон ИЛИ email
    const email   = emailField?.value.trim() || '';
    const hasPhone = [...form.querySelectorAll('[name="phones[]"]')]
      .some(p => p.value.replace(/\D/g, '').length >= 7);

    if (!email && !hasPhone) {
      phoneError.textContent = 'Укажите телефон или email';
      valid = false;
    } else {
      phoneError.textContent = '';
    }

    submitBtn.disabled = !valid;
    return valid;
  };

  /* ---------- EVENTS ---------- */
  about?.addEventListener('input', updateCounter);

  addPhoneBtn?.addEventListener('click', () => {
    if (phonesWrap.querySelectorAll('.phone-row').length >= 5) return;
    phonesWrap.insertAdjacentHTML('beforeend', `
      <div class="phone-row">
        <select name="country_codes[]" class="country-code">
          <option value="+375">+375</option>
          <option value="+7">+7</option>
        </select>
        <input type="tel" name="phones[]" class="phone-input" placeholder="(___) ___ __ __" />
        <button type="button" class="remove-phone">×</button>
      </div>
    `);
    validateForm();
  });

  phonesWrap.addEventListener('click', e => {
    if (e.target.classList.contains('remove-phone')) {
      e.target.closest('.phone-row').remove();
      validateForm();
    }
  });

  form.addEventListener('input', validateForm);
  form.addEventListener('change', validateForm);

  form.addEventListener('submit', async e => {
    e.preventDefault();
    if (!validateForm()) return;

    try {
      const response = await fetch('/api/submit.php', {
        method: 'POST',
        body: new FormData(form)
      });
      const result = await response.json();

      if (!result.success) {
        // показать ошибки
        Object.entries(result.errors).forEach(([field, msg]) => {
          const input = form.querySelector(`[name="${field}"]`);
          if (input) showError(input, msg);
        });

        // восстановить данные
        if (result.data) {
          Object.entries(result.data).forEach(([key, value]) => {
            const input = form.querySelector(`[name="${key}"]`);
            if (!input) return;

            if (Array.isArray(value)) {
              if (key === 'phones' || key === 'codes') {
                phonesWrap.innerHTML = '';
                value.forEach((phone, idx) => {
                  const code = result.data.codes?.[idx] || '+375';
                  phonesWrap.insertAdjacentHTML('beforeend', `
                    <div class="phone-row">
                      <select name="country_codes[]" class="country-code">
                        <option value="+375" ${code === '+375' ? 'selected' : ''}>+375</option>
                        <option value="+7" ${code === '+7' ? 'selected' : ''}>+7</option>
                      </select>
                      <input type="tel" name="phones[]" class="phone-input" value="${phone}" />
                      <button type="button" class="remove-phone">×</button>
                    </div>
                  `);
                });
              }
            } else if (input.type === 'checkbox') {
              input.checked = Boolean(value);
            } else {
              input.value = value;
            }
          });
          updateCounter();
        }
        return;
      }

      // успех
      form.reset();
      form.querySelectorAll('.error').forEach(el => el.textContent = '');
      form.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'));
      alert("✅ Данные отправлены! С вами свяжутся!");
    } catch (err) {
      alert("Ошибка соединения. Попробуйте позже.");
      console.error('Fetch error:', err);
    }
  });
});
