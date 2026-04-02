function initLvlNevaBlogLists(root = document) {
  if (!("IntersectionObserver" in window)) {
    return;
  }

  root.querySelectorAll("[data-blog-list]").forEach((blogList) => {
    if (blogList.dataset.blogListReady === "true") {
      return;
    }

    const itemsContainer = blogList.querySelector("[data-blog-list-items]");
    const sentinel = blogList.querySelector("[data-blog-list-sentinel]");
    const paginationContainer = blogList.querySelector("[data-blog-list-pagination]");

    if (!itemsContainer || !sentinel) {
      return;
    }

    blogList.dataset.blogListReady = "true";

    let isLoading = false;

    const observer = new IntersectionObserver(
      async (entries) => {
        const entry = entries[0];

        if (!entry?.isIntersecting || isLoading) {
          return;
        }

        const nextPageUrl = blogList.dataset.nextPageUrl;

        if (!nextPageUrl) {
          observer.disconnect();
          return;
        }

        isLoading = true;
        blogList.classList.add("is-loading");

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
          const nextBlogList = nextDocument.querySelector("[data-blog-list]");
          const nextItems = nextBlogList?.querySelectorAll(
            "[data-blog-list-items] > *"
          );
          const nextPagination = nextBlogList?.querySelector(
            "[data-blog-list-pagination]"
          );

          if (!nextBlogList || !nextItems?.length) {
            blogList.dataset.nextPageUrl = "";
            observer.disconnect();
            return;
          }

          nextItems.forEach((item) => {
            itemsContainer.appendChild(item.cloneNode(true));
          });

          blogList.dataset.currentPage = nextBlogList.dataset.currentPage || "";
          blogList.dataset.nextPageUrl = nextBlogList.dataset.nextPageUrl || "";

          if (paginationContainer) {
            paginationContainer.innerHTML = nextPagination?.innerHTML || "";
          }

          if (window.history?.replaceState) {
            window.history.replaceState({}, "", nextPageUrl);
          }

          if (!blogList.dataset.nextPageUrl) {
            observer.disconnect();
          }
        } catch (error) {
          console.error("Blog list load error:", error);
        } finally {
          isLoading = false;
          blogList.classList.remove("is-loading");
        }
      },
      {
        rootMargin: "400px 0px",
      }
    );

    observer.observe(sentinel);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initLvlNevaBlogLists(document);
});

document.addEventListener("lvlNevaResultsReplaced", (event) => {
  initLvlNevaBlogLists(event.detail?.section || document);
});
