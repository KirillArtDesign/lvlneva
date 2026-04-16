function initLvlNevaShopLists(root = document) {
  if (!("IntersectionObserver" in window)) {
    return;
  }

  const shopArchives = [];

  if (root instanceof Element && root.matches("[data-shop-archive]")) {
    shopArchives.push(root);
  }

  if (root.querySelectorAll) {
    shopArchives.push(...root.querySelectorAll("[data-shop-archive]"));
  }

  shopArchives.forEach((archiveRoot) => {
    if (archiveRoot.dataset.shopListReady === "true") {
      return;
    }

    const sentinel = archiveRoot.querySelector("[data-shop-list-sentinel]");

    if (!sentinel) {
      return;
    }

    archiveRoot.dataset.shopListReady = "true";

    let isLoading = false;

    const observer = new IntersectionObserver(
      async (entries) => {
        const entry = entries[0];

        if (!entry?.isIntersecting || isLoading) {
          return;
        }

        const nextPageUrl = archiveRoot.dataset.nextPageUrl;
        const itemsContainer = archiveRoot.querySelector("[data-shop-list-items]");
        const paginationContainer = archiveRoot.querySelector(
          "[data-shop-filter-pagination]",
        );

        if (!nextPageUrl || !itemsContainer) {
          archiveRoot.dataset.nextPageUrl = "";
          observer.disconnect();
          return;
        }

        isLoading = true;
        archiveRoot.classList.add("is-loading");

        try {
          const response = await fetch(nextPageUrl, {
            headers: {
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (!response.ok) {
            throw new Error(`Failed to load ${nextPageUrl}`);
          }

          const html = await response.text();
          const parser = new DOMParser();
          const nextDocument = parser.parseFromString(html, "text/html");
          const nextArchiveRoot = nextDocument.querySelector("[data-shop-archive]");
          const nextItems = nextArchiveRoot?.querySelectorAll(
            "[data-shop-list-items] > *",
          );
          const nextPagination = nextArchiveRoot?.querySelector(
            "[data-shop-filter-pagination]",
          );

          if (!nextArchiveRoot || !nextItems?.length) {
            archiveRoot.dataset.nextPageUrl = "";
            observer.disconnect();
            return;
          }

          nextItems.forEach((item) => {
            itemsContainer.appendChild(item.cloneNode(true));
          });

          archiveRoot.dataset.currentPage =
            nextArchiveRoot.dataset.currentPage || "";
          archiveRoot.dataset.nextPageUrl =
            nextArchiveRoot.dataset.nextPageUrl || "";

          if (paginationContainer) {
            paginationContainer.innerHTML = nextPagination?.innerHTML || "";
          }

          document.dispatchEvent(
            new CustomEvent("lvlNevaShopItemsAppended", {
              detail: { root: archiveRoot },
            }),
          );

          if (window.history?.replaceState) {
            window.history.replaceState({}, "", nextPageUrl);
          }

          if (!archiveRoot.dataset.nextPageUrl) {
            observer.disconnect();
          }
        } catch (error) {
          console.error("Shop list load error:", error);
        } finally {
          isLoading = false;
          archiveRoot.classList.remove("is-loading");
        }
      },
      {
        rootMargin: "400px 0px",
      },
    );

    archiveRoot._lvlNevaShopListObserver = observer;
    observer.observe(sentinel);
  });
}

function destroyLvlNevaShopLists(root = document) {
  const shopArchives = [];

  if (root instanceof Element && root.matches("[data-shop-archive]")) {
    shopArchives.push(root);
  }

  if (root.querySelectorAll) {
    shopArchives.push(...root.querySelectorAll("[data-shop-archive]"));
  }

  shopArchives.forEach((archiveRoot) => {
    if (archiveRoot._lvlNevaShopListObserver) {
      archiveRoot._lvlNevaShopListObserver.disconnect();
      delete archiveRoot._lvlNevaShopListObserver;
    }

    delete archiveRoot.dataset.shopListReady;
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initLvlNevaShopLists(document);
});

document.addEventListener("lvlNevaShopResultsReplaced", (event) => {
  const archiveRoot = event.detail?.root;

  if (!(archiveRoot instanceof Element)) {
    return;
  }

  destroyLvlNevaShopLists(archiveRoot);
  initLvlNevaShopLists(archiveRoot);
});
