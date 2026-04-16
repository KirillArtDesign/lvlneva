document.addEventListener("DOMContentLoaded", () => {
  if (!window.lvlNevaContentFilter) {
    return;
  }

  document.querySelectorAll("[data-content-filter]").forEach((section) => {
    section.addEventListener("change", async (event) => {
      const input = event.target;

      if (
        !(input instanceof HTMLInputElement) ||
        !input.classList.contains("content-tags__input")
      ) {
        return;
      }

      const formData = new URLSearchParams();
      const selectedTerm = input.value || "all";
      const archiveUrl = section.dataset.archiveUrl || "";
      const stateUrl = archiveUrl
        ? new URL(archiveUrl, window.location.origin)
        : null;

      section.classList.add("is-loading");

      try {
        const currentResults = section.querySelector("[data-content-filter-results]");
        let replacementHtml = "";

        if (selectedTerm === "all" && archiveUrl) {
          const response = await fetch(archiveUrl, {
            headers: {
              "X-Requested-With": "XMLHttpRequest",
            },
          });

          if (!response.ok) {
            throw new Error(`Failed to load ${archiveUrl}`);
          }

          const html = await response.text();
          const parser = new DOMParser();
          const documentFromResponse = parser.parseFromString(html, "text/html");
          const restoredResults = documentFromResponse.querySelector(
            "[data-content-filter-results]"
          );

          replacementHtml = restoredResults?.outerHTML || "";
        } else {
          formData.append("action", "lvl_neva_filter_content");
          formData.append("nonce", window.lvlNevaContentFilter.nonce);
          formData.append("post_type", section.dataset.postType || "");
          formData.append("taxonomy", section.dataset.taxonomy || "");
          formData.append("posts_per_page", section.dataset.postsPerPage || "");
          formData.append("term", selectedTerm);

          const response = await fetch(window.lvlNevaContentFilter.ajaxUrl, {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            },
            body: formData.toString(),
          });
          const payload = await response.json();

          if (!response.ok || !payload.success || !payload.data?.html) {
            throw new Error(payload.data?.message || "Filter request failed.");
          }

          replacementHtml = payload.data.html;
        }

        if (currentResults && replacementHtml) {
          currentResults.outerHTML = replacementHtml;

          if (stateUrl && window.history?.replaceState) {
            if (selectedTerm === "all") {
              stateUrl.searchParams.delete("content_filter_term");
            } else {
              stateUrl.searchParams.set("content_filter_term", selectedTerm);
            }

            window.history.replaceState({}, "", stateUrl.toString());
          }

          document.dispatchEvent(
            new CustomEvent("lvlNevaResultsReplaced", {
              detail: { section },
            })
          );
        }
      } catch (error) {
        console.error("Content filter error:", error);
      } finally {
        section.classList.remove("is-loading");
      }
    });
  });
});
