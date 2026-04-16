document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-shop-filter]").forEach((filterRoot) => {
    const archiveRoot = filterRoot.closest("[data-shop-archive]");

    if (!archiveRoot) {
      return;
    }

    let resultsRoot = archiveRoot.querySelector("[data-shop-filter-results]");
    let paginationRoot = archiveRoot.querySelector("[data-shop-filter-pagination]");
    const archiveUrl =
      filterRoot.dataset.shopArchiveUrl || window.location.pathname || "/";
    const filterParamNames = ["shop_width", "shop_height", "shop_length"];

    if (!resultsRoot) {
      return;
    }

    const getFilterInputs = () =>
      Array.from(filterRoot.querySelectorAll("[data-shop-filter-input]"));

    const closeDrawer = () => {
      const openButton = filterRoot.querySelector("[data-filter-open]");
      const panel = filterRoot.querySelector(".catalog-filter-drawer__panel");

      filterRoot.classList.remove("is-open");

      if (openButton) {
        openButton.setAttribute("aria-expanded", "false");
      }

      if (panel) {
        panel.setAttribute("aria-hidden", "true");
      }

      document.body.style.overflow = "";
    };

    const setLoading = (isLoading) => {
      archiveRoot.classList.toggle("is-loading", isLoading);
    };

    const syncInputsFromUrl = (urlLike) => {
      const url = new URL(urlLike, window.location.origin);
      const currentState = {
        shop_width: new Set(
          (url.searchParams.get("shop_width") || "")
            .split(",")
            .map((value) => value.trim())
            .filter(Boolean),
        ),
        shop_height: new Set(
          (url.searchParams.get("shop_height") || "")
            .split(",")
            .map((value) => value.trim())
            .filter(Boolean),
        ),
        shop_length: new Set(
          (url.searchParams.get("shop_length") || "")
            .split(",")
            .map((value) => value.trim())
            .filter(Boolean),
        ),
      };

      getFilterInputs().forEach((input) => {
        if (!(input instanceof HTMLInputElement)) {
          return;
        }

        const inputName =
          input.dataset.shopFilterKey || input.name.replace(/\[\]$/, "");
        input.checked = currentState[inputName]?.has(input.value) || false;
      });
    };

    const buildFilterUrl = () => {
      const nextUrl = new URL(archiveUrl, window.location.origin);
      const currentUrl = new URL(window.location.href);
      const selectedValues = {
        shop_width: [],
        shop_height: [],
        shop_length: [],
      };

      currentUrl.searchParams.forEach((value, key) => {
        if (!filterParamNames.includes(key) && "paged" !== key) {
          nextUrl.searchParams.append(key, value);
        }
      });

      getFilterInputs().forEach((input) => {
        if (!(input instanceof HTMLInputElement) || !input.checked) {
          return;
        }

        const inputName =
          input.dataset.shopFilterKey || input.name.replace(/\[\]$/, "");

        if (selectedValues[inputName]) {
          selectedValues[inputName].push(input.value);
        }
      });

      Object.entries(selectedValues).forEach(([key, values]) => {
        nextUrl.searchParams.delete(key);

        if (values.length) {
          nextUrl.searchParams.set(key, values.join(","));
        }
      });

      return nextUrl;
    };

    const replaceArchiveContent = (html) => {
      const parser = new DOMParser();
      const responseDocument = parser.parseFromString(html, "text/html");
      const replacementArchiveRoot = responseDocument.querySelector(
        "[data-shop-archive]",
      );
      const replacementResults = responseDocument.querySelector(
        "[data-shop-filter-results]",
      );
      const replacementPagination = responseDocument.querySelector(
        "[data-shop-filter-pagination]",
      );

      if (!replacementResults) {
        throw new Error("Shop filter results container not found.");
      }

      resultsRoot.outerHTML = replacementResults.outerHTML;
      resultsRoot = archiveRoot.querySelector("[data-shop-filter-results]");

      if (paginationRoot) {
        if (replacementPagination) {
          paginationRoot.outerHTML = replacementPagination.outerHTML;
        } else {
          paginationRoot.remove();
        }
      } else if (replacementPagination) {
        resultsRoot.insertAdjacentHTML("afterend", replacementPagination.outerHTML);
      }

      paginationRoot = archiveRoot.querySelector("[data-shop-filter-pagination]");

      if (replacementArchiveRoot) {
        archiveRoot.dataset.currentPage =
          replacementArchiveRoot.dataset.currentPage || "";
        archiveRoot.dataset.nextPageUrl =
          replacementArchiveRoot.dataset.nextPageUrl || "";
      }

      document.dispatchEvent(
        new CustomEvent("lvlNevaShopResultsReplaced", {
          detail: { root: archiveRoot },
        }),
      );
    };

    const fetchArchive = async (urlLike, options = {}) => {
      const { pushState = true, scrollToResults = false } = options;
      const requestUrl = new URL(urlLike, window.location.origin);

      setLoading(true);

      try {
        const response = await fetch(requestUrl.toString(), {
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (!response.ok) {
          throw new Error(`Failed to load ${requestUrl.toString()}`);
        }

        replaceArchiveContent(await response.text());

        if (pushState) {
          window.history.pushState({ shopFilter: true }, "", requestUrl.toString());
        }

        if (scrollToResults) {
          resultsRoot?.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }
      } catch (error) {
        console.error("Shop filter error:", error);
      } finally {
        setLoading(false);
      }
    };

    filterRoot.addEventListener("change", (event) => {
      const target = event.target;

      if (
        !(target instanceof HTMLInputElement) ||
        !target.hasAttribute("data-shop-filter-input")
      ) {
        return;
      }

      closeDrawer();
      fetchArchive(buildFilterUrl(), { pushState: true, scrollToResults: true });
    });

    archiveRoot.addEventListener("click", (event) => {
      const target = event.target;

      if (!(target instanceof Element)) {
        return;
      }

      const paginationLink = target.closest(
        "[data-shop-filter-pagination] a[href]",
      );

      if (!(paginationLink instanceof HTMLAnchorElement)) {
        return;
      }

      event.preventDefault();
      fetchArchive(paginationLink.href, { pushState: true, scrollToResults: true });
    });

    window.addEventListener("popstate", () => {
      syncInputsFromUrl(window.location.href);
      fetchArchive(window.location.href, { pushState: false, scrollToResults: false });
    });
  });
});
