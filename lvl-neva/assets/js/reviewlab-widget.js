(() => {
  const currentScript =
    document.currentScript ||
    document.querySelector('script[src*="reviewlab-widget.js"]');
  const reviewCardBgUrl = currentScript
    ? new URL("../img/lvl-newa-review-bg.svg", currentScript.src).href
    : "";

  const applyStyles = (element, styles) => {
    if (!(element instanceof HTMLElement)) {
      return;
    }

    Object.entries(styles).forEach(([property, value]) => {
      const cssProperty = property.replace(/[A-Z]/g, (letter) => `-${letter.toLowerCase()}`);
      element.style.setProperty(cssProperty, value, "important");
    });
  };

  const init = () => {
    const widgetSections = document.querySelectorAll("[data-reviewlab-widget-section]");

  if (!widgetSections.length) {
    return;
  }

  const getDirectChildren = (element) => {
    return Array.from(element.children).filter((child) => child instanceof HTMLElement);
  };

  const getDirectChildByClass = (element, className) => {
    return getDirectChildren(element).find((child) => child.classList.contains(className)) || null;
  };

  const getSliderButtonMarkup = (direction) => {
    const isPrev = direction === "prev";
    const path = isPrev
      ? '<path d="M10.8889 18L6 13.2V12M10.8889 6L6 10.8V12M6 12H18" stroke="currentColor" stroke-width="2"/>'
      : '<path d="M13.1111 18L18 13.2V12M13.1111 6L18 10.8V12M18 12H6" stroke="currentColor" stroke-width="2"/>';

    return `
      <div class="lvl-neva-reviewlab-nav__frame lvl-neva-reviewlab-nav__frame--${direction}" aria-hidden="true">
        <div class="lvl-neva-reviewlab-nav__icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            ${path}
          </svg>
        </div>
      </div>
    `;
  };

  const enhanceReviewCard = (review) => {
    if (!(review instanceof HTMLElement)) {
      return;
    }

    review.classList.add("lvl-neva-review-card");

    const footer = getDirectChildByClass(review, "review__footer");
    let body = getDirectChildByClass(review, "lvl-neva-review-card__body");
    let header = body
      ? getDirectChildByClass(body, "review__header")
      : getDirectChildByClass(review, "review__header");
    let textWrap = body
      ? getDirectChildByClass(body, "lvl-neva-review-card__text-wrap")
      : null;
    let textBlock = textWrap
      ? getDirectChildren(textWrap)[0] || null
      : getDirectChildren(review).find((child) => {
          return child !== header && child !== footer && child.querySelector(".review__text");
        }) || null;

    if (!header || !textBlock) {
      return;
    }

    if (!body) {
      body = document.createElement("div");
      body.className = "lvl-neva-review-card__body";

      if (footer) {
        review.insertBefore(body, footer);
      } else {
        review.appendChild(body);
      }
    }

    if (!body.contains(header)) {
      body.appendChild(header);
    }

    if (!textWrap) {
      textWrap = document.createElement("div");
      textWrap.className = "lvl-neva-review-card__text-wrap";
      body.appendChild(textWrap);
    }

    if (!textWrap.contains(textBlock)) {
      textWrap.appendChild(textBlock);
    }

    if (footer && review.lastElementChild !== footer) {
      review.appendChild(footer);
    }

    const isMobile = window.innerWidth <= 991;
    const reviewTexts = review.querySelectorAll(".review__text");

    applyStyles(review, {
      display: "flex",
      flexDirection: "column",
      gap: "2rem",
      minHeight: "100%",
      padding: isMobile ? "2rem" : "2.4rem",
      borderRadius: "2rem",
      backgroundColor: "#fff",
      backgroundImage: reviewCardBgUrl ? `url("${reviewCardBgUrl}")` : "",
      backgroundPosition: "center",
      backgroundRepeat: "no-repeat",
      backgroundSize: "cover",
      overflow: "hidden",
    });

    applyStyles(body, {
      display: "flex",
      flexDirection: isMobile ? "column" : "row-reverse",
      gap: "2rem",
      alignItems: "flex-start",
      flex: "1 1 auto",
    });

    applyStyles(textWrap, {
      flex: "1 1 auto",
      minWidth: "0",
    });

    applyStyles(header, {
      flex: isMobile ? "1 1 auto" : "0 0 14rem",
      width: isMobile ? "100%" : "14rem",
      minWidth: isMobile ? "0" : "14rem",
    });

    if (footer) {
      applyStyles(footer, {
        marginTop: "auto",
      });
    }

    reviewTexts.forEach((reviewText) => {
      applyStyles(reviewText, {
        fontFamily: '"Inter Tight", sans-serif',
        fontStyle: "normal",
        fontWeight: "500",
        fontSize: "2rem",
        lineHeight: "140%",
        color: "#010101",
      });
    });

    review.classList.add("lvl-neva-review-card--ready");
  };

  const enhanceCarouselControls = (section) => {
    const navContainers = section.querySelectorAll("[data-area]");

    navContainers.forEach((navContainer) => {
      const buttons = Array.from(navContainer.querySelectorAll(".widget__pag")).filter(
        (button) => button instanceof HTMLElement
      );

      if (!buttons.length) {
        return;
      }

      navContainer.classList.add("lvl-neva-reviewlab-nav");
      navContainer.setAttribute("data-area", "bottom-right");

      applyStyles(navContainer, {
        display: "flex",
        justifyContent: "flex-end",
        alignItems: "flex-end",
        gap: "0.4rem",
        width: "100%",
        maxWidth: "none",
      });

      buttons.forEach((button) => {
        const direction = button.classList.contains("widget__pag_prev") ? "prev" : "next";

        button.classList.add(
          "lvl-neva-reviewlab-nav__button",
          `lvl-neva-reviewlab-nav__button--${direction}`
        );

        if (button.dataset.reviewlabNavEnhanced !== "true") {
          button.innerHTML = getSliderButtonMarkup(direction);
          button.dataset.reviewlabNavEnhanced = "true";
        }

        applyStyles(button, {
          display: "inline-flex",
          justifyContent: "center",
          alignItems: "center",
          width: "4.8rem",
          height: "4.8rem",
          padding: "0",
          border: "0",
          borderRadius: "0.3rem",
          background: direction === "next" ? "var(--Primary, #31572C)" : "#FFFFFF",
          color: direction === "next" ? "#FFFFFF" : "var(--Primary, #31572C)",
          boxShadow: "none",
          minWidth: "0",
          minHeight: "0",
          opacity: button.disabled ? "0.45" : "1",
        });
      });
    });
  };

  const enhanceSection = (section) => {
    const widgets = section.querySelectorAll('.widget[data-layout="carousel"]');

    widgets.forEach((widget) => {
      widget.classList.add("lvl-neva-reviewlab-widget");
    });

    enhanceCarouselControls(section);

    const reviews = section.querySelectorAll(".review");

    reviews.forEach((review) => {
      enhanceReviewCard(review);
    });
  };

  const scheduleEnhancement = (section) => {
    if (section.dataset.reviewlabScheduled === "true") {
      return;
    }

    section.dataset.reviewlabScheduled = "true";

    window.requestAnimationFrame(() => {
      enhanceSection(section);
      section.dataset.reviewlabScheduled = "false";
    });
  };

    widgetSections.forEach((section) => {
      scheduleEnhancement(section);

      const observer = new MutationObserver(() => {
        scheduleEnhancement(section);
      });

      observer.observe(section, {
        childList: true,
        subtree: true,
      });
    });

    window.addEventListener("resize", () => {
      widgetSections.forEach((section) => {
        scheduleEnhancement(section);
      });
    });
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init, { once: true });
  } else {
    init();
  }

})();
