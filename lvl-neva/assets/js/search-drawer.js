document.addEventListener("DOMContentLoaded", () => {
  const drawer = document.querySelector("[data-search-drawer]");

  if (!drawer) {
    return;
  }

  const panel = drawer.querySelector("[data-search-drawer-panel]");
  const input = drawer.querySelector("[data-search-drawer-input]");
  const results = drawer.querySelector("[data-search-drawer-results]");
  const openButtons = document.querySelectorAll("[data-search-drawer-open]");
  const closeButtons = drawer.querySelectorAll("[data-search-drawer-close]");
  const html = document.documentElement;
  const body = document.body;
  const initialResultsHtml = results ? results.innerHTML : "";
  const config = window.lvlNevaSearchDrawer || null;

  if (!panel || !input || !results || !openButtons.length || !config?.ajaxUrl) {
    return;
  }

  let abortController = null;
  let searchTimeoutId = 0;

  const setOpenState = (isOpen) => {
    drawer.classList.toggle("is-open", isOpen);
    panel.setAttribute("aria-hidden", isOpen ? "false" : "true");
    html.classList.toggle("search-drawer-open", isOpen);
    body.classList.toggle("search-drawer-open", isOpen);

    openButtons.forEach((button) => {
      button.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });
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
          source: "search",
        },
      }),
    );

    setOpenState(true);
    window.setTimeout(() => {
      input.focus();
      input.select();
    }, 50);
  };

  const renderInitialState = () => {
    results.innerHTML = initialResultsHtml;
    results.classList.remove("is-loading");
  };

  const performSearch = (query) => {
    const trimmedQuery = query.trim();
    const minChars = Number.parseInt(config.minChars || "1", 10) || 1;

    if (trimmedQuery.length < minChars) {
      renderInitialState();
      return;
    }

    if (abortController) {
      abortController.abort();
    }

    abortController = new AbortController();
    results.classList.add("is-loading");

    const formData = new FormData();
    formData.append("action", "lvl_neva_search_drawer");
    formData.append("nonce", config.nonce || "");
    formData.append("query", trimmedQuery);

    fetch(config.ajaxUrl, {
      method: "POST",
      body: formData,
      signal: abortController.signal,
    })
      .then((response) => response.json())
      .then((response) => {
        results.classList.remove("is-loading");
        results.innerHTML = response?.success && response.data?.html
          ? response.data.html
          : initialResultsHtml;
      })
      .catch((error) => {
        if (error?.name === "AbortError") {
          return;
        }

        results.classList.remove("is-loading");
        results.innerHTML = initialResultsHtml;
      });
  };

  openButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      openDrawer();
      performSearch(input.value);
    });
  });

  closeButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      closeDrawer();
    });
  });

  input.addEventListener("input", () => {
    window.clearTimeout(searchTimeoutId);
    searchTimeoutId = window.setTimeout(() => {
      performSearch(input.value);
    }, 180);
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && drawer.classList.contains("is-open")) {
      closeDrawer();
    }
  });

  document.addEventListener("lvl-neva-drawer-open", (event) => {
    if (event.detail?.source && event.detail.source !== "search") {
      closeDrawer();
    }
  });
});
