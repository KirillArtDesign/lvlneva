function lvlNevaGetListingPageFromUrl(url, fallbackPage = 1) {
  try {
    const parsedUrl = new URL(url, window.location.origin);
    const queryPage = Number.parseInt(
      parsedUrl.searchParams.get("paged") || parsedUrl.searchParams.get("page") || "",
      10
    );

    if (Number.isInteger(queryPage) && queryPage > 0) {
      return queryPage;
    }

    const pathMatch = parsedUrl.pathname.match(/\/page\/(\d+)\/?$/);

    if (pathMatch) {
      const pathPage = Number.parseInt(pathMatch[1], 10);

      if (Number.isInteger(pathPage) && pathPage > 0) {
        return pathPage;
      }
    }
  } catch (error) {
    console.error("Listing page parse error:", error);
  }

  return Math.max(1, Number.parseInt(fallbackPage, 10) || 1);
}

async function lvlNevaFetchListingMarkup(blogList, page, url = "") {
  const postType = blogList.dataset.postType || "";
  const taxonomy = blogList.dataset.taxonomy || "";
  const postsPerPage = blogList.dataset.postsPerPage || "";
  const currentTermId = blogList.dataset.currentTermId || "0";

  if (window.lvlNevaContentFilter && postType && taxonomy) {
    const formData = new URLSearchParams();

    formData.append("action", "lvl_neva_filter_content");
    formData.append("nonce", window.lvlNevaContentFilter.nonce);
    formData.append("post_type", postType);
    formData.append("taxonomy", taxonomy);
    formData.append("posts_per_page", postsPerPage);
    formData.append("term", currentTermId);
    formData.append("page", String(page));

    const response = await fetch(window.lvlNevaContentFilter.ajaxUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: formData.toString(),
    });
    const payload = await response.json();

    if (!response.ok || !payload.success || !payload.data?.html) {
      throw new Error(payload.data?.message || "Listing request failed.");
    }

    return payload.data.html;
  }

  const targetUrl = url || blogList.dataset.nextPageUrl;

  if (!targetUrl) {
    throw new Error("Missing listing URL.");
  }

  const response = await fetch(targetUrl, {
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
  });

  if (!response.ok) {
    throw new Error(`Failed to load ${targetUrl}`);
  }

  return response.text();
}

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

    const applyNextListState = (nextBlogList, { append = false } = {}) => {
      const nextItems = nextBlogList?.querySelectorAll("[data-blog-list-items] > *");
      const nextPagination = nextBlogList?.querySelector("[data-blog-list-pagination]");

      if (!nextBlogList) {
        throw new Error("Listing markup not found.");
      }

      if (append) {
        if (!nextItems?.length) {
          blogList.dataset.nextPageUrl = "";
          return;
        }

        nextItems.forEach((item) => {
          itemsContainer.appendChild(item.cloneNode(true));
        });
      } else {
        itemsContainer.innerHTML = "";

        nextItems?.forEach((item) => {
          itemsContainer.appendChild(item.cloneNode(true));
        });
      }

      blogList.dataset.postType = nextBlogList.dataset.postType || blogList.dataset.postType || "";
      blogList.dataset.taxonomy = nextBlogList.dataset.taxonomy || blogList.dataset.taxonomy || "";
      blogList.dataset.postsPerPage =
        nextBlogList.dataset.postsPerPage || blogList.dataset.postsPerPage || "";
      blogList.dataset.currentTermId =
        nextBlogList.dataset.currentTermId || blogList.dataset.currentTermId || "0";
      blogList.dataset.currentPage = nextBlogList.dataset.currentPage || "";
      blogList.dataset.nextPageUrl = nextBlogList.dataset.nextPageUrl || "";

      if (paginationContainer) {
        paginationContainer.innerHTML = nextPagination?.innerHTML || "";
      }
    };

    const loadPage = async ({
      page,
      url = "",
      append = false,
      historyMode = "",
      scrollToTop = false,
    }) => {
      if (isLoading) {
        return;
      }

      isLoading = true;
      blogList.classList.add("is-loading");

      try {
        const html = await lvlNevaFetchListingMarkup(blogList, page, url);
        const parser = new DOMParser();
        const nextDocument = parser.parseFromString(html, "text/html");
        const nextBlogList = nextDocument.querySelector("[data-blog-list]");

        applyNextListState(nextBlogList, { append });

        if (scrollToTop) {
          blogList.scrollIntoView({
            block: "start",
            behavior: "smooth",
          });
        }

        if (url && window.history) {
          if (historyMode === "push" && window.history.pushState) {
            window.history.pushState({}, "", url);
          } else if (historyMode === "replace" && window.history.replaceState) {
            window.history.replaceState({}, "", url);
          }
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
    };

    const observer = new IntersectionObserver(
      async (entries) => {
        const entry = entries[0];

        if (!entry?.isIntersecting || isLoading) {
          return;
        }

        const nextPageUrl = blogList.dataset.nextPageUrl || "";
        const nextPage = lvlNevaGetListingPageFromUrl(
          nextPageUrl,
          Number.parseInt(blogList.dataset.currentPage || "1", 10) + 1
        );

        if (!nextPageUrl && nextPage <= Number.parseInt(blogList.dataset.currentPage || "1", 10)) {
          observer.disconnect();
          return;
        }

        await loadPage({
          page: nextPage,
          url: nextPageUrl,
          append: true,
          historyMode: nextPageUrl ? "replace" : "",
        });
      },
      {
        rootMargin: "400px 0px",
      }
    );

    observer.observe(sentinel);

    blogList.addEventListener("click", async (event) => {
      const paginationLink = event.target.closest("[data-blog-list-pagination] a[href]");

      if (!(paginationLink instanceof HTMLAnchorElement)) {
        return;
      }

      event.preventDefault();

      await loadPage({
        page:
          Number.parseInt(paginationLink.dataset.page || "", 10) ||
          lvlNevaGetListingPageFromUrl(
            paginationLink.href,
            Number.parseInt(blogList.dataset.currentPage || "1", 10)
          ),
        url: paginationLink.href,
        append: false,
        historyMode: "push",
        scrollToTop: true,
      });
    });
  });
}

document.addEventListener("DOMContentLoaded", () => {
  initLvlNevaBlogLists(document);
});

document.addEventListener("lvlNevaResultsReplaced", (event) => {
  initLvlNevaBlogLists(event.detail?.section || document);
});
