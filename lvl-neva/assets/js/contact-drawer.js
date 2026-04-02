document.addEventListener("DOMContentLoaded", () => {
  const drawer = document.querySelector("[data-contact-drawer]");

  if (!drawer) {
    return;
  }

  const panel = drawer.querySelector("[data-contact-drawer-panel]");
  const openButtons = document.querySelectorAll("[data-contact-drawer-open]");
  const closeButtons = drawer.querySelectorAll("[data-contact-drawer-close]");
  const html = document.documentElement;
  const body = document.body;

  if (!panel || !openButtons.length) {
    return;
  }

  const resetDrawerFormState = () => {
    const wrap = drawer.querySelector("[data-lvl-neva-contact-form-wrap]");
    const form = drawer.querySelector("[data-lvl-neva-contact-form]");

    if (!wrap || !form) {
      return;
    }

    if (wrap.classList.contains("is-success")) {
      form.reset();
    }

    wrap.classList.remove("is-success", "is-error");

    form.querySelectorAll("[data-lvl-neva-contact-field]").forEach((field) => {
      field.classList.remove("is-error");
    });

    const messageNode = form.querySelector("[data-lvl-neva-contact-message]");

    if (messageNode) {
      messageNode.hidden = true;
      messageNode.textContent = "";
    }
  };

  const closeMobileMenuImmediately = () => {
    const modalMenu = document.querySelector("[modal-menu]");

    if (!modalMenu || modalMenu.getAttribute("aria-hidden") === "true") {
      return;
    }

    modalMenu.classList.remove("is-active", "is-mounted");
    modalMenu.setAttribute("aria-hidden", "true");

    html.classList.remove("overflow-hidden", "menu-open");
    body.classList.remove("overflow-hidden", "menu-open");
  };

  const setOpenState = (isOpen) => {
    drawer.classList.toggle("is-open", isOpen);
    panel.setAttribute("aria-hidden", isOpen ? "false" : "true");
    html.classList.toggle("contact-drawer-open", isOpen);
    body.classList.toggle("contact-drawer-open", isOpen);

    openButtons.forEach((button) => {
      button.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
  };

  const closeDrawer = () => {
    setOpenState(false);
  };

  const openDrawer = () => {
    closeMobileMenuImmediately();

    document.dispatchEvent(
      new CustomEvent("lvl-neva-drawer-open", {
        detail: {
          source: "contact",
        },
      }),
    );

    resetDrawerFormState();
    setOpenState(true);

    window.setTimeout(() => {
      const firstInput = drawer.querySelector(
        '[data-lvl-neva-contact-form] input:not([type="hidden"])',
      );

      if (firstInput) {
        firstInput.focus();
      }
    }, 50);
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

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && drawer.classList.contains("is-open")) {
      closeDrawer();
    }
  });

  document.addEventListener("lvl-neva-drawer-open", (event) => {
    if (event.detail?.source && event.detail.source !== "contact") {
      closeDrawer();
    }
  });
});
