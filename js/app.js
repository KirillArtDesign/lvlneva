// mobile product filter
document.addEventListener("DOMContentLoaded", function () {
  const drawers = document.querySelectorAll("[data-filter-drawer]");

  drawers.forEach((drawer) => {
    const openBtn = drawer.querySelector("[data-filter-open]");
    const closeBtns = drawer.querySelectorAll("[data-filter-close]");
    const panel = drawer.querySelector(".catalog-filter-drawer__panel");

    if (!openBtn || !panel) return;

    const openDrawer = () => {
      drawer.classList.add("is-open");
      openBtn.setAttribute("aria-expanded", "true");
      panel.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    };

    const closeDrawer = () => {
      drawer.classList.remove("is-open");
      openBtn.setAttribute("aria-expanded", "false");
      panel.setAttribute("aria-hidden", "true");
      document.body.style.overflow = "";
    };

    openBtn.addEventListener("click", openDrawer);

    closeBtns.forEach((btn) => {
      btn.addEventListener("click", closeDrawer);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && drawer.classList.contains("is-open")) {
        closeDrawer();
      }
    });
  });
});



// headder and mobile menu
document.addEventListener("DOMContentLoaded", () => {
    const modalMenu = document.querySelector("[modal-menu]");
    const header = document.querySelector(".section-header");

    const openButtons = document.querySelectorAll('[data-menu-trigger="open"]');
    const closeButtons = document.querySelectorAll('[menu-trigger="close"]');

    const html = document.documentElement;
    const body = document.body;

    const duration = 800;
    const mobileMq = window.matchMedia("(max-width: 991px)");

    let isAnimating = false;
    let lastScrollY = window.scrollY;
    let ticking = false;

    const isMobile = () => mobileMq.matches;

    const setDisabled = (disabled) => {
        openButtons.forEach(btn => btn.classList.toggle("pointer-events-none", disabled));
        closeButtons.forEach(btn => btn.classList.toggle("pointer-events-none", disabled));
    };

    const setPageLock = (locked) => {
        html.classList.toggle("overflow-hidden", locked);
        body.classList.toggle("overflow-hidden", locked);
        html.classList.toggle("menu-open", locked);
        body.classList.toggle("menu-open", locked);
    };

    const resetMenu = () => {
        if (!modalMenu) return;
        modalMenu.classList.remove("is-active", "is-mounted");
        modalMenu.setAttribute("aria-hidden", "true");
        setPageLock(false);
        isAnimating = false;
    };

    if (modalMenu) {
        resetMenu();
    }

    const openMenu = () => {
        if (!modalMenu || !isMobile() || isAnimating) return;

        isAnimating = true;
        setDisabled(true);

        modalMenu.classList.add("is-mounted");
        modalMenu.setAttribute("aria-hidden", "false");
        setPageLock(true);

        requestAnimationFrame(() => {
            modalMenu.classList.add("is-active");
        });

        window.setTimeout(() => {
            isAnimating = false;
            setDisabled(false);
        }, duration);
    };

    const closeMenu = () => {
        if (!modalMenu || isAnimating) return;

        isAnimating = true;
        setDisabled(true);

        modalMenu.classList.remove("is-active");
        modalMenu.setAttribute("aria-hidden", "true");

        window.setTimeout(() => {
            modalMenu.classList.remove("is-mounted");
            setPageLock(false);
            isAnimating = false;
            setDisabled(false);
        }, duration);
    };

    openButtons.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            openMenu();
        });
    });

    closeButtons.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            closeMenu();
        });
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeMenu();
        }
    });

    const handleBreakpointChange = () => {
        if (!isMobile()) {
            resetMenu();
        }
    };

    if (mobileMq.addEventListener) {
        mobileMq.addEventListener("change", handleBreakpointChange);
    } else {
        mobileMq.addListener(handleBreakpointChange);
    }

    const updateHeader = () => {
        if (!header) {
            ticking = false;
            return;
        }

        const currentScrollY = window.scrollY;
        const topThreshold = 20;
        const delta = Math.abs(currentScrollY - lastScrollY);
        const goingDown = currentScrollY > lastScrollY;

        /* если меню открыто — шапка управляется только классом menu-open */
        if (html.classList.contains("menu-open") || body.classList.contains("menu-open")) {
            ticking = false;
            lastScrollY = currentScrollY;
            return;
        }

        if (currentScrollY <= topThreshold) {
            header.classList.remove("header--hidden");
            header.classList.remove("header--solid");
        } else {
            if (delta > 4) {
                if (goingDown) {
                    header.classList.add("header--hidden");
                } else {
                    header.classList.remove("header--hidden");
                    header.classList.add("header--solid");
                }
            }
        }

        lastScrollY = currentScrollY;
        ticking = false;
    };

    window.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }, { passive: true });

    updateHeader();
});



// FAQ
document.addEventListener('DOMContentLoaded', function () {
  const accordionItems = document.querySelectorAll('.faq-accordion__item');

  accordionItems.forEach((item) => {
    const button = item.querySelector('.faq-accordion__trigger');

    button.addEventListener('click', function () {
      const isOpen = item.classList.contains('is-open');

      accordionItems.forEach((accordionItem) => {
        accordionItem.classList.remove('is-open');

        const accordionButton = accordionItem.querySelector('.faq-accordion__trigger');
        accordionButton.setAttribute('aria-expanded', 'false');
      });

      if (!isOpen) {
        item.classList.add('is-open');
        button.setAttribute('aria-expanded', 'true');
      }
    });
  });
});


// Product purchase controls
document.addEventListener("DOMContentLoaded", () => {
  const qtyControls = document.querySelectorAll("[data-qty-control]");

  qtyControls.forEach((control) => {
    const input = control.querySelector("[data-qty-input]");
    const decreaseBtn = control.querySelector("[data-qty-decrease]");
    const increaseBtn = control.querySelector("[data-qty-increase]");

    if (!input || !decreaseBtn || !increaseBtn) return;

    const getSafeValue = () => {
      const parsedValue = Number.parseInt(input.value, 10);
      return Number.isNaN(parsedValue) || parsedValue < 1 ? 1 : parsedValue;
    };

    const syncValue = (nextValue) => {
      const safeValue = Math.max(1, nextValue);
      input.value = String(safeValue);
      decreaseBtn.disabled = safeValue <= 1;
    };

    decreaseBtn.addEventListener("click", () => {
      syncValue(getSafeValue() - 1);
    });

    increaseBtn.addEventListener("click", () => {
      syncValue(getSafeValue() + 1);
    });

    input.addEventListener("input", () => {
      syncValue(getSafeValue());
    });

    input.addEventListener("blur", () => {
      syncValue(getSafeValue());
    });

    syncValue(getSafeValue());
  });
});

// Legacy GSAP animations
(() => {
  const TEXT_SCROLL_SELECTOR = "[gsap-text-scroll-animation]";
  const OPACITY_SCROLL_SELECTOR = "[gsap-opacity-scroll-animation]";
  const ELEMENTS_SCROLL_SELECTOR = "[gsap-elements-scroll-animation]";
  const COVER_TITLE_SELECTOR = "[cover-title]";
  const COVER_DESCRIPTION_SELECTOR = "[cover-description]";
  const RESIZE_DEBOUNCE = 200;
  const PREPOSITIONS = new Set([
    "в",
    "во",
    "к",
    "ко",
    "с",
    "со",
    "и",
    "а",
    "но",
    "да",
    "или",
    "либо",
    "на",
    "над",
    "по",
    "под",
    "за",
    "из",
    "изо",
    "от",
    "ото",
    "до",
    "об",
    "обо",
    "перед",
    "пред",
    "при",
    "про",
    "для",
    "ради",
    "через",
    "сквозь",
    "о",
    "у",
    "не",
    "ни",
    "же",
    "то",
    "ли",
    "бы",
    "б",
  ]);

  const sourceHtmlMap = new WeakMap();
  const animationStateMap = new WeakMap();
  const observedCardElements = new WeakSet();

  let gsapRef = null;
  let scrollTriggerRef = null;
  let resizeObserver = null;
  let refreshTimer = 0;
  let resizeTimer = 0;
  let booted = false;

  const getGsapApi = () => {
    const api = window.taptop || {};
    const gsap = api.gsap || window.gsap;
    const ScrollTrigger =
      (api.gsapPlugins && api.gsapPlugins.ScrollTrigger) || window.ScrollTrigger;

    if (!gsap || !ScrollTrigger) {
      return null;
    }

    return { gsap, ScrollTrigger };
  };

  const ensureState = (element) => {
    if (!animationStateMap.has(element)) {
      animationStateMap.set(element, { animations: [] });
    }

    return animationStateMap.get(element);
  };

  const cleanupElementAnimations = (element) => {
    const state = animationStateMap.get(element);

    if (!state) {
      return;
    }

    state.animations.forEach((animation) => {
      if (!animation) {
        return;
      }

      if (animation.scrollTrigger && typeof animation.scrollTrigger.kill === "function") {
        animation.scrollTrigger.kill();
      }

      if (typeof animation.kill === "function") {
        animation.kill();
      }
    });

    animationStateMap.delete(element);
  };

  const captureSourceHtml = (element) => {
    if (!sourceHtmlMap.has(element)) {
      sourceHtmlMap.set(element, element.innerHTML);
    }

    return sourceHtmlMap.get(element);
  };

  const restoreSourceHtml = (element) => {
    element.innerHTML = captureSourceHtml(element);
  };

  const decodeHtmlSegment = (html) => {
    const temp = document.createElement("div");
    temp.innerHTML = html;
    return temp.textContent.replace(/\u00a0/g, " ").replace(/\s+/g, " ").trim();
  };

  const getForcedLines = (element) => {
    const sourceHtml = captureSourceHtml(element);

    if (!/<br\s*\/?>/i.test(sourceHtml)) {
      return null;
    }

    const lines = sourceHtml
      .split(/<br\s*\/?>/i)
      .map((segment) => decodeHtmlSegment(segment))
      .filter(Boolean);

    return lines.length ? lines : null;
  };

  const getTextLines = (element) => {
    const text = element.textContent.replace(/\u00a0/g, " ").replace(/\s+/g, " ").trim();
    const containerWidth = element.clientWidth || element.getBoundingClientRect().width;

    if (!text) {
      return [];
    }

    if (!containerWidth) {
      return [text];
    }

    const words = text.split(/\s+/).filter(Boolean);
    const styles = window.getComputedStyle(element);
    const clone = element.cloneNode(false);

    clone.textContent = "";
    clone.style.visibility = "hidden";
    clone.style.position = "absolute";
    clone.style.left = "-9999px";
    clone.style.top = "0";
    clone.style.width = "auto";
    clone.style.height = "auto";
    clone.style.whiteSpace = "nowrap";
    clone.style.padding = "0";
    clone.style.margin = "0";
    clone.style.font = styles.font;
    clone.style.letterSpacing = styles.letterSpacing;
    clone.style.wordSpacing = styles.wordSpacing;
    clone.style.textTransform = styles.textTransform;

    document.body.appendChild(clone);

    const wordWidths = words.map((word) => {
      clone.textContent = word;
      return clone.offsetWidth;
    });

    clone.textContent = "\u00a0";
    const spaceWidth = clone.offsetWidth;

    document.body.removeChild(clone);

    const lines = [];
    let currentLine = [];
    let currentWidth = 0;

    words.forEach((word, index) => {
      const wordWidth = wordWidths[index];
      const nextWidth =
        currentWidth + (currentLine.length > 0 ? spaceWidth : 0) + wordWidth;

      if (nextWidth > containerWidth) {
        if (PREPOSITIONS.has(word.toLowerCase()) && currentLine.length > 0) {
          lines.push(currentLine.join(" "));
          currentLine = [word];
          currentWidth = wordWidth;
          return;
        }

        const lastWord = currentLine[currentLine.length - 1];
        if (currentLine.length > 1 && PREPOSITIONS.has(lastWord.toLowerCase())) {
          currentLine.pop();
          lines.push(currentLine.join(" "));
          currentLine = [lastWord, word];
          currentWidth = wordWidths[index - 1] + spaceWidth + wordWidth;
          return;
        }

        if (currentLine.length > 0) {
          lines.push(currentLine.join(" "));
        }

        currentLine = [word];
        currentWidth = wordWidth;
        return;
      }

      if (currentLine.length > 0) {
        currentWidth += spaceWidth;
      }

      currentLine.push(word);
      currentWidth += wordWidth;
    });

    if (currentLine.length > 0) {
      lines.push(currentLine.join(" "));
    }

    return lines;
  };

  const buildLineStructure = (element, lines, classes) => {
    element.textContent = "";

    lines.forEach((line) => {
      const wrapper = document.createElement("div");
      const mask = document.createElement("div");
      const lineElement = document.createElement("div");

      wrapper.className = classes.wrapperClass;
      mask.className = classes.maskClass;
      lineElement.className = classes.lineClass;

      mask.style.height = "0px";
      lineElement.textContent = line;

      mask.appendChild(lineElement);
      wrapper.appendChild(mask);
      element.appendChild(wrapper);

      wrapper.style.height = `${lineElement.offsetHeight}px`;
    });
  };

  const prepareTextLines = (element, classes) => {
    restoreSourceHtml(element);

    if (!element.querySelector(`.${classes.maskClass}`)) {
      const lines = getForcedLines(element) || getTextLines(element);

      if (!lines.length) {
        return [];
      }

      buildLineStructure(element, lines, classes);
    }

    return Array.from(element.querySelectorAll(`.${classes.maskClass}`));
  };

  const initIntroTextAnimations = (selector, classes, baseDelay) => {
    document.querySelectorAll(selector).forEach((element) => {
      cleanupElementAnimations(element);

      const masks = prepareTextLines(element, classes);

      if (!masks.length) {
        return;
      }

      const state = ensureState(element);

      masks.forEach((mask, index) => {
        const lineElement = mask.firstElementChild;
        const targetHeight = lineElement ? lineElement.offsetHeight : 0;

        if (!targetHeight) {
          return;
        }

        gsapRef.set(mask, { height: 0 });
        state.animations.push(
          gsapRef.to(mask, {
            height: targetHeight,
            duration: 0.4,
            delay: baseDelay + index * 0.1,
            ease: "power2.out",
          }),
        );
      });
    });
  };

  const initScrollTextAnimations = () => {
    document.querySelectorAll(TEXT_SCROLL_SELECTOR).forEach((element) => {
      cleanupElementAnimations(element);

      const masks = prepareTextLines(element, {
        wrapperClass: "line-wrapper",
        maskClass: "line-mask",
        lineClass: "text-line",
      });

      if (!masks.length) {
        return;
      }

      const state = ensureState(element);

      masks.forEach((mask, index) => {
        const lineElement = mask.firstElementChild;
        const targetHeight = lineElement ? lineElement.offsetHeight : 0;

        if (!targetHeight) {
          return;
        }

        gsapRef.set(mask, { height: 0 });

        const timeline = gsapRef.timeline({
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            toggleActions: "play none play none",
          },
        });

        timeline.to(mask, {
          height: targetHeight,
          duration: 0.4,
          delay: index * 0.2,
          ease: "power2.out",
        });

        state.animations.push(timeline);
      });
    });
  };

  const initCoverDescriptionAnimation = () => {
    const element = document.querySelector(COVER_DESCRIPTION_SELECTOR);

    if (!element || element.dataset.gsapCoverDescriptionReady === "true") {
      return;
    }

    element.dataset.gsapCoverDescriptionReady = "true";
    gsapRef.fromTo(
      element,
      { opacity: 0 },
      {
        opacity: 1,
        duration: 0.4,
        delay: 2.8,
        ease: "power2.out",
      },
    );
  };

  const ensureCardStructure = (element) => {
    let wrapper = element.closest(".card-wrapper");

    if (!wrapper) {
      wrapper = document.createElement("div");
      wrapper.className = "card-wrapper border-radius";
      element.parentNode.insertBefore(wrapper, element);
      wrapper.appendChild(element);
    }

    let mask = element.closest(".card-mask");
    let inner = null;

    if (mask && wrapper.contains(mask)) {
      inner = element.parentElement;
    } else {
      mask = document.createElement("div");
      mask.className = "card-mask";

      if (wrapper.classList.contains("border-radius")) {
        mask.classList.add("border-radius");
      }

      inner = document.createElement("div");

      if (element.parentNode === wrapper) {
        wrapper.insertBefore(mask, element);
      } else {
        wrapper.appendChild(mask);
      }

      mask.appendChild(inner);
      inner.appendChild(element);
    }

    const rect = element.getBoundingClientRect();
    const width = rect.width || element.offsetWidth;
    const height = rect.height || element.offsetHeight;

    inner.style.width = "100%";
    inner.style.margin = "0px";

    if (width) {
      inner.style.maxWidth = `${width}px`;
    }

    if (height) {
      wrapper.dataset.originalHeight = String(height);
      wrapper.style.height = `${height}px`;
    }

    return { wrapper, mask };
  };

  const scheduleRefresh = () => {
    clearTimeout(refreshTimer);
    refreshTimer = window.setTimeout(() => {
      if (scrollTriggerRef) {
        scrollTriggerRef.refresh();
      }
    }, 50);
  };

  const ensureResizeObserver = () => {
    if (resizeObserver || typeof ResizeObserver === "undefined") {
      return;
    }

    resizeObserver = new ResizeObserver((entries) => {
      entries.forEach((entry) => {
        if (!(entry.target instanceof HTMLElement)) {
          return;
        }

        ensureCardStructure(entry.target);
      });

      scheduleRefresh();
    });
  };

  const initCardAnimations = () => {
    ensureResizeObserver();

    document.querySelectorAll(ELEMENTS_SCROLL_SELECTOR).forEach((element) => {
      cleanupElementAnimations(element);

      const { wrapper, mask } = ensureCardStructure(element);
      const state = ensureState(element);

      if (resizeObserver && !observedCardElements.has(element)) {
        resizeObserver.observe(element);
        observedCardElements.add(element);
      }

      gsapRef.set(mask, { height: 0 });

      state.animations.push(
        gsapRef.to(mask, {
          height: () => wrapper.dataset.originalHeight || element.offsetHeight || 0,
          duration: 0.4,
          ease: "power2.out",
          scrollTrigger: {
            trigger: wrapper,
            start: "top 80%",
            toggleActions: "play none none none",
            onRefresh: () => ensureCardStructure(element),
          },
        }),
      );
    });
  };

  const initOpacityAnimations = () => {
    document.querySelectorAll(OPACITY_SCROLL_SELECTOR).forEach((element) => {
      cleanupElementAnimations(element);

      const state = ensureState(element);

      state.animations.push(
        gsapRef.from(element, {
          opacity: 0,
          duration: 0.8,
          ease: "power2.out",
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            toggleActions: "play none none none",
          },
        }),
      );
    });
  };

  const rebuildResponsiveAnimations = () => {
    initIntroTextAnimations(
      COVER_TITLE_SELECTOR,
      {
        wrapperClass: "title-line-wrapper",
        maskClass: "title-line-mask",
        lineClass: "title-text-line",
      },
      2.8,
    );
    initScrollTextAnimations();
    document.querySelectorAll(ELEMENTS_SCROLL_SELECTOR).forEach((element) => {
      ensureCardStructure(element);
    });
    scheduleRefresh();
  };

  const initLegacyGsapAnimations = (api) => {
    gsapRef = api.gsap;
    scrollTriggerRef = api.ScrollTrigger;

    gsapRef.registerPlugin(scrollTriggerRef);

    initCoverDescriptionAnimation();
    initIntroTextAnimations(
      COVER_TITLE_SELECTOR,
      {
        wrapperClass: "title-line-wrapper",
        maskClass: "title-line-mask",
        lineClass: "title-text-line",
      },
      2.8,
    );
    initScrollTextAnimations();
    initOpacityAnimations();
    initCardAnimations();
    scheduleRefresh();

    window.addEventListener("resize", () => {
      clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(rebuildResponsiveAnimations, RESIZE_DEBOUNCE);
    });
  };

  const tryBoot = () => {
    if (booted || document.readyState === "loading") {
      return;
    }

    const api = getGsapApi();

    if (!api) {
      return;
    }

    booted = true;
    initLegacyGsapAnimations(api);
  };

  document.addEventListener("gsapReadyEvent", tryBoot, { once: true });
  document.addEventListener("mosaicAfterInit", tryBoot, { once: true });
  document.addEventListener("DOMContentLoaded", () => {
    window.setTimeout(tryBoot, 0);
  });
  window.addEventListener("load", tryBoot, { once: true });
})();
