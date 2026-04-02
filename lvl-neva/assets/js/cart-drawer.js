document.addEventListener("DOMContentLoaded", () => {
  const drawer = document.querySelector("[data-cart-drawer]");

  if (!drawer) {
    return;
  }

  const panel = drawer.querySelector("[data-cart-drawer-panel]");
  const content = drawer.querySelector("[data-cart-drawer-content]");
  const openButtons = document.querySelectorAll("[data-cart-drawer-open]");
  const closeButtons = drawer.querySelectorAll("[data-cart-drawer-close]");
  const countNodes = document.querySelectorAll("[data-cart-drawer-count]");
  const html = document.documentElement;
  const body = document.body;
  const config = window.lvlNevaCartDrawer || null;

  if (!panel || !content || !openButtons.length || !config?.ajaxUrl) {
    return;
  }

  let abortController = null;

  const triggerWooRefresh = () => {
    if (!window.jQuery) {
      return;
    }

    window.jQuery(document.body).trigger("wc_fragment_refresh");
  };

  const syncCount = (countValue) => {
    const count = Number.parseInt(countValue || "0", 10) || 0;

    countNodes.forEach((node) => {
      node.textContent = String(count);
      node.hidden = count < 1;
      node.classList.toggle("is-visible", count > 0);
    });
  };

  const setOpenState = (isOpen) => {
    drawer.classList.toggle("is-open", isOpen);
    panel.setAttribute("aria-hidden", isOpen ? "false" : "true");
    html.classList.toggle("cart-drawer-open", isOpen);
    body.classList.toggle("cart-drawer-open", isOpen);

    openButtons.forEach((button) => {
      button.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
  };

  const setView = (viewName) => {
    const views = content.querySelectorAll("[data-cart-drawer-view]");

    views.forEach((view) => {
      const isActive = view.dataset.cartDrawerView === viewName;
      view.hidden = !isActive;
      view.classList.toggle("is-active", isActive);
    });
  };

  const clearFormState = (form) => {
    if (!form) {
      return;
    }

    form.querySelectorAll("[data-cart-drawer-field]").forEach((field) => {
      field.classList.remove("is-error");
      const errorNode = field.querySelector("[data-cart-drawer-field-error]");

      if (errorNode) {
        errorNode.textContent = errorNode.dataset.defaultError || errorNode.textContent;
      }
    });

    const message = form.querySelector("[data-cart-drawer-form-message]");

    if (message) {
      message.hidden = true;
      message.textContent = "";
      message.classList.remove("is-error");
    }
  };

  const applyFormErrors = (form, errors = {}, messageText = "") => {
    if (!form) {
      return;
    }

    clearFormState(form);

    Object.entries(errors).forEach(([fieldName, errorText]) => {
      const field = form.querySelector(`[data-cart-drawer-field="${fieldName}"]`);

      if (!field) {
        return;
      }

      field.classList.add("is-error");

      const errorNode = field.querySelector("[data-cart-drawer-field-error]");

      if (errorNode) {
        if (!errorNode.dataset.defaultError) {
          errorNode.dataset.defaultError = errorNode.textContent;
        }

        errorNode.textContent = errorText;
      }
    });

    const message = form.querySelector("[data-cart-drawer-form-message]");

    if (message && messageText) {
      message.hidden = false;
      message.textContent = messageText;
      message.classList.add("is-error");
    }
  };

  const validateForm = (form) => {
    const errors = {};
    const formData = new FormData(form);
    const values = {
      name: String(formData.get("name") || "").trim(),
      phone: String(formData.get("phone") || "").trim(),
      email: String(formData.get("email") || "").trim(),
      comment: String(formData.get("comment") || "").trim(),
    };

    if (!values.name) {
      errors.name = "Укажите имя";
    }

    const phoneDigits = values.phone.replace(/\D+/g, "");

    if (!values.phone || phoneDigits.length < 5) {
      errors.phone = "Укажите телефон";
    }

    if (
      values.email &&
      !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email)
    ) {
      errors.email = "Некорректный email";
    }

    return {
      values,
      errors,
    };
  };

  const request = (action, payload = {}) => {
    if (abortController) {
      abortController.abort();
    }

    abortController = new AbortController();

    const formData = new FormData();
    formData.append("action", action);
    formData.append("nonce", config.nonce || "");

    Object.entries(payload).forEach(([key, value]) => {
      formData.append(key, value);
    });

    content.classList.add("is-loading");

    return fetch(config.ajaxUrl, {
      method: "POST",
      body: formData,
      signal: abortController.signal,
    })
      .then((response) =>
        response.json().then((data) => ({
          ok: response.ok,
          data,
        })),
      )
      .then(({ ok, data }) => {
        content.classList.remove("is-loading");
        return {
          ok,
          response: data,
        };
      })
      .catch((error) => {
        content.classList.remove("is-loading");

        if (error?.name === "AbortError") {
          return {
            ok: false,
            response: null,
            aborted: true,
          };
        }

        return {
          ok: false,
          response: null,
        };
      });
  };

  const loadCart = () =>
    request("lvl_neva_get_cart_drawer").then(({ response, aborted }) => {
      if (aborted || !response?.success || !response.data) {
        return;
      }

      content.innerHTML = response.data.html || "";
      syncCount(response.data.count);
      setView("cart");
    });

  const removeItem = (cartItemKey) => {
    if (!cartItemKey) {
      return;
    }

    request("lvl_neva_remove_cart_item", {
      cart_item_key: cartItemKey,
    }).then(({ response, aborted }) => {
      if (aborted || !response?.success || !response.data) {
        return;
      }

      content.innerHTML = response.data.html || "";
      syncCount(response.data.count);
      triggerWooRefresh();
    });
  };

  const updateQuantity = (cartItemKey, quantity) => {
    if (!cartItemKey) {
      return;
    }

    const safeQuantity = Math.max(1, Number.parseInt(quantity || "1", 10) || 1);

    request("lvl_neva_update_cart_item_quantity", {
      cart_item_key: cartItemKey,
      quantity: safeQuantity,
    }).then(({ response, aborted }) => {
      if (aborted || !response?.success || !response.data) {
        return;
      }

      content.innerHTML = response.data.html || "";
      syncCount(response.data.count);
      triggerWooRefresh();
    });
  };

  const submitCheckout = (form) => {
    if (!form) {
      return;
    }

    const validation = validateForm(form);

    if (Object.keys(validation.errors).length) {
      applyFormErrors(form, validation.errors, "Проверьте заполнение формы.");
      return;
    }

    clearFormState(form);

    const submitButton = form.querySelector("[data-cart-drawer-checkout-submit]");

    if (submitButton) {
      submitButton.disabled = true;
    }

    request("lvl_neva_submit_cart_checkout", validation.values).then(
      ({ response, aborted }) => {
        if (submitButton) {
          submitButton.disabled = false;
        }

        if (aborted) {
          return;
        }

        if (response?.success && response.data) {
          content.innerHTML = response.data.html || "";
          syncCount(response.data.count);
          return;
        }

        applyFormErrors(
          form,
          response?.data?.errors || {},
          response?.data?.message || "Не удалось оформить заказ.",
        );
      },
    );
  };

  const closeDrawer = () => {
    setOpenState(false);

    if (abortController) {
      abortController.abort();
      abortController = null;
    }
  };

  const openDrawer = () => {
    document.dispatchEvent(
      new CustomEvent("lvl-neva-drawer-open", {
        detail: {
          source: "cart",
        },
      }),
    );

    setOpenState(true);
    loadCart();
  };

  openButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      openDrawer();
    });
  });

  closeButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      closeDrawer();
    });
  });

  content.addEventListener("click", (event) => {
    const closeTrigger = event.target.closest("[data-cart-drawer-close]");

    if (closeTrigger) {
      event.preventDefault();
      closeDrawer();
      return;
    }

    const openCheckoutTrigger = event.target.closest("[data-cart-drawer-open-checkout]");

    if (openCheckoutTrigger) {
      event.preventDefault();
      setView("checkout");
      return;
    }

    const backTrigger = event.target.closest("[data-cart-drawer-back]");

    if (backTrigger) {
      event.preventDefault();
      setView("cart");
      return;
    }

    const removeButton = event.target.closest("[data-cart-drawer-remove]");

    if (removeButton) {
      event.preventDefault();
      removeItem(removeButton.dataset.cartDrawerRemove || "");
      return;
    }

    const decreaseButton = event.target.closest("[data-cart-drawer-qty-decrease]");

    if (decreaseButton) {
      event.preventDefault();

      const control = decreaseButton.closest("[data-cart-drawer-qty-control]");
      const input = control?.querySelector("[data-cart-drawer-qty-input]");

      if (!control || !input) {
        return;
      }

      updateQuantity(control.dataset.cartDrawerQtyControl || "", Number.parseInt(input.value || "1", 10) - 1);
      return;
    }

    const increaseButton = event.target.closest("[data-cart-drawer-qty-increase]");

    if (increaseButton) {
      event.preventDefault();

      const control = increaseButton.closest("[data-cart-drawer-qty-control]");
      const input = control?.querySelector("[data-cart-drawer-qty-input]");

      if (!control || !input) {
        return;
      }

      updateQuantity(control.dataset.cartDrawerQtyControl || "", Number.parseInt(input.value || "1", 10) + 1);
    }
  });

  content.addEventListener("change", (event) => {
    const input = event.target.closest("[data-cart-drawer-qty-input]");

    if (!input) {
      return;
    }

    const control = input.closest("[data-cart-drawer-qty-control]");

    if (!control) {
      return;
    }

    updateQuantity(control.dataset.cartDrawerQtyControl || "", input.value);
  });

  content.addEventListener("submit", (event) => {
    const form = event.target.closest("[data-cart-drawer-checkout-form]");

    if (!form) {
      return;
    }

    event.preventDefault();
    submitCheckout(form);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && drawer.classList.contains("is-open")) {
      closeDrawer();
    }
  });

  document.addEventListener("lvl-neva-drawer-open", (event) => {
    if (event.detail?.source && event.detail.source !== "cart") {
      closeDrawer();
    }
  });

  syncCount(config.initialCount);

  if (window.jQuery) {
    window
      .jQuery(document.body)
      .on("added_to_cart removed_from_cart wc_fragments_loaded wc_fragments_refreshed", () => {
        request("lvl_neva_get_cart_drawer").then(({ response, aborted }) => {
          if (aborted || !response?.success || !response.data) {
            return;
          }

          content.innerHTML = response.data.html || "";
          syncCount(response.data.count);
        });
      });
  }
});
