document.addEventListener("DOMContentLoaded", () => {
  const config = window.lvlNevaContactForm || null;
  const forms = document.querySelectorAll("[data-lvl-neva-contact-form]");

  if (!config?.ajaxUrl || !forms.length) {
    return;
  }

  const validateEmail = (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

  const getFieldWrapper = (form, fieldName) =>
    form.querySelector(`[data-lvl-neva-contact-field="${fieldName}"]`);

  const setFieldError = (form, fieldName, message) => {
    const field = getFieldWrapper(form, fieldName);

    if (!field) {
      return;
    }

    field.classList.add("is-error");

    const errorNode = field.querySelector("[data-lvl-neva-contact-error]");

    if (errorNode) {
      const textNode = errorNode.querySelector(".text-block-wrap-div");

      if (textNode) {
        textNode.textContent = message;
      } else {
        errorNode.textContent = message;
      }
    }
  };

  const clearFieldError = (form, fieldName) => {
    const field = getFieldWrapper(form, fieldName);

    if (!field) {
      return;
    }

    field.classList.remove("is-error");
  };

  const hideFormMessage = (form) => {
    const messageNode = form.querySelector("[data-lvl-neva-contact-message]");

    if (!messageNode) {
      return;
    }

    messageNode.hidden = true;
    messageNode.textContent = "";
  };

  const clearFormState = (form, wrap) => {
    wrap.classList.remove("is-success", "is-error");

    form
      .querySelectorAll("[data-lvl-neva-contact-field]")
      .forEach((field) => field.classList.remove("is-error"));

    const messageNode = form.querySelector("[data-lvl-neva-contact-message]");

    if (messageNode) {
      hideFormMessage(form);
    }
  };

  const showFormMessage = (form, message) => {
    const messageNode = form.querySelector("[data-lvl-neva-contact-message]");

    if (!messageNode) {
      return;
    }

    messageNode.hidden = false;
    messageNode.textContent = message;
  };

  const validateForm = (form) => {
    const formData = new FormData(form);
    const values = {
      name: String(formData.get("name") || "").trim(),
      email: String(formData.get("email") || "").trim(),
      phone: String(formData.get("phone") || "").trim(),
      comment: String(formData.get("comment") || "").trim(),
      website: String(formData.get("website") || "").trim(),
      consent: formData.get("consent") ? "1" : "",
      page_url: window.location.href,
      page_title: document.title,
    };

    const errors = {};
    const phoneDigits = values.phone.replace(/\D+/g, "");

    if (!values.name) {
      errors.name = "Укажите имя";
    }

    if (!values.phone || phoneDigits.length < 5) {
      errors.phone = "Укажите телефон";
    }

    if (values.email && !validateEmail(values.email)) {
      errors.email = "Некорректный формат почты";
    }

    if (!values.consent) {
      errors.consent = "Подтвердите согласие на обработку персональных данных";
    }

    return {
      values,
      errors,
    };
  };

  const submitForm = (form, wrap) => {
    const submitButton = form.querySelector("[data-lvl-neva-contact-submit]");
    const validation = validateForm(form);

    clearFormState(form, wrap);

    if (Object.keys(validation.errors).length) {
      Object.entries(validation.errors).forEach(([fieldName, message]) => {
        setFieldError(form, fieldName, message);
      });

      showFormMessage(form, "Проверьте заполнение формы.");
      return;
    }

    if (submitButton) {
      submitButton.disabled = true;
    }

    const payload = new FormData();
    payload.append("action", "lvl_neva_submit_contact_form");
    payload.append("nonce", config.nonce || "");

    Object.entries(validation.values).forEach(([key, value]) => {
      payload.append(key, value);
    });

    fetch(config.ajaxUrl, {
      method: "POST",
      body: payload,
    })
      .then(async (response) => {
        const data = await response.json().catch(() => null);

        return {
          ok: response.ok,
          data,
        };
      })
      .then(({ ok, data }) => {
        if (submitButton) {
          submitButton.disabled = false;
        }

        if (ok && data?.success) {
          const successText = wrap.querySelector("[data-lvl-neva-contact-success-text]");

          if (successText) {
            successText.textContent =
              data?.data?.message ||
              "Спасибо! Заявка отправлена. Мы свяжемся с вами в ближайшее время.";
          }

          form.reset();
          clearFormState(form, wrap);
          wrap.classList.add("is-success");
          return;
        }

        const errors = data?.data?.errors || {};

        Object.entries(errors).forEach(([fieldName, message]) => {
          setFieldError(form, fieldName, message);
        });

        showFormMessage(
          form,
          data?.data?.message || "Не удалось отправить форму. Попробуйте ещё раз.",
        );
      })
      .catch(() => {
        if (submitButton) {
          submitButton.disabled = false;
        }

        showFormMessage(form, "Не удалось отправить форму. Попробуйте ещё раз.");
      });
  };

  forms.forEach((form) => {
    const wrap = form.closest("[data-lvl-neva-contact-form-wrap]");

    if (!wrap) {
      return;
    }

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      submitForm(form, wrap);
    });

    form.addEventListener("input", (event) => {
      const target = event.target;

      if (!(target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement)) {
        return;
      }

      if (target.name) {
        clearFieldError(form, target.name);
        hideFormMessage(form);
      }
    });

    form.addEventListener("change", (event) => {
      const target = event.target;

      if (!(target instanceof HTMLInputElement || target instanceof HTMLTextAreaElement)) {
        return;
      }

      if (target.name) {
        clearFieldError(form, target.name);
        hideFormMessage(form);
      }
    });
  });
});
