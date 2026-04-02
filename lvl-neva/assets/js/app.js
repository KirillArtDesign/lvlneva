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
    let headerThemeInitialized = false;
    let lastScrollTop =
        window.pageYOffset || document.documentElement.scrollTop || 0;
    let ticking = false;

    const isMobile = () => mobileMq.matches;
    const getScrollTop = () =>
        window.pageYOffset || document.documentElement.scrollTop || 0;

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

    const initHeaderThemeChange = () => {
        if (!header || headerThemeInitialized) {
            return;
        }

        const api = getGsapApi();

        if (!api) {
            return;
        }

        const darkSections = document.querySelectorAll("[section-dark-theme]");

        if (!darkSections.length) {
            return;
        }

        api.gsap.registerPlugin(api.ScrollTrigger);

        darkSections.forEach((section) => {
            api.ScrollTrigger.create({
                trigger: section,
                start: "top 20%",
                end: "bottom top",
                onEnter: () => header.classList.remove("header-light-theme"),
                onLeaveBack: () => header.classList.add("header-light-theme"),
                onEnterBack: () => header.classList.remove("header-light-theme"),
                onLeave: () => header.classList.add("header-light-theme"),
            });
        });

        headerThemeInitialized = true;
        api.ScrollTrigger.refresh();
    };

    const syncHeaderSurface = (scrollTop = getScrollTop(), forceSolid = false) => {
        if (!header) return;

        const shouldUseSolidHeader =
            header.classList.contains("section-header--light-static") || forceSolid;

        header.classList.toggle("header--solid", shouldUseSolidHeader);
    };

    const showHeader = (scrollTop = getScrollTop(), forceSolid = scrollTop > 0) => {
        if (!header) return;

        header.classList.remove("is-hidden", "header--hidden");
        header.classList.add("is-visible");
        syncHeaderSurface(scrollTop, forceSolid);
    };

    const hideHeader = () => {
        if (!header) return;

        header.classList.add("is-hidden");
        header.classList.remove("is-visible", "header--hidden");
    };

    const resetMenu = () => {
        if (!modalMenu) return;
        modalMenu.classList.remove("is-active", "is-mounted");
        modalMenu.setAttribute("aria-hidden", "true");
        setPageLock(false);
        isAnimating = false;
        showHeader(getScrollTop(), getScrollTop() > 0);
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
            showHeader(getScrollTop(), getScrollTop() > 0);
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

        const currentScrollTop = getScrollTop();
        const delta = 5;
        const headerHeight = header.offsetHeight;

        if (html.classList.contains("menu-open") || body.classList.contains("menu-open")) {
            ticking = false;
            lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
            return;
        }

        if (currentScrollTop <= 0) {
            showHeader(0, false);
            lastScrollTop = 0;
            ticking = false;
            return;
        }

        if (Math.abs(lastScrollTop - currentScrollTop) <= delta) {
            ticking = false;
            return;
        }

        if (currentScrollTop > lastScrollTop) {
            if (currentScrollTop > headerHeight) {
                hideHeader();
            } else {
                showHeader(currentScrollTop, false);
            }
        } else {
            showHeader(currentScrollTop, true);
        }

        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        ticking = false;
    };

    window.addEventListener("scroll", () => {
        if (!ticking) {
            window.requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }, { passive: true });

    initHeaderThemeChange();
    document.addEventListener("gsapReadyEvent", initHeaderThemeChange, { once: true });
    document.addEventListener("mosaicAfterInit", initHeaderThemeChange, { once: true });

    showHeader(getScrollTop(), getScrollTop() > 0);
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


// Portfolio gallery slider
document.addEventListener("DOMContentLoaded", function () {
  const galleryComponents = document.querySelectorAll(".equipment-page_slider_component");

  galleryComponents.forEach((component) => {
    if (component.dataset.sliderReady === "true") {
      return;
    }

    const preview = component.querySelector('[equipment-slider="preview"]');
    const wrapper = preview ? preview.querySelector(".swiper-wrapper") : null;
    const slides = wrapper ? Array.from(wrapper.querySelectorAll(".swiper-slide")) : [];
    const prevButton = component.querySelector('[equipment-slider="prev"]');
    const nextButton = component.querySelector('[equipment-slider="next"]');
    const thumbs = Array.from(component.querySelectorAll(".equipment-page_slider_thumb"));

    if (!preview || !wrapper || slides.length === 0) {
      return;
    }

    component.dataset.sliderReady = "true";

    let activeIndex = 0;

    preview.style.width = "100%";
    preview.style.maxWidth = "100%";
    preview.style.overflow = "hidden";

    wrapper.style.display = "flex";
    wrapper.style.flexWrap = "nowrap";
    wrapper.style.transition = "transform 600ms ease";
    wrapper.style.willChange = "transform";

    slides.forEach((slide) => {
      slide.style.width = "100%";
      slide.style.flex = "0 0 100%";
    });

    const updateActiveThumb = () => {
      thumbs.forEach((thumb, index) => {
        thumb.classList.toggle("active", index === activeIndex);
      });
    };

    const updateNavigation = () => {
      const isFirstSlide = activeIndex === 0;
      const isLastSlide = activeIndex === slides.length - 1;

      if (prevButton) {
        prevButton.classList.toggle("swiper-button-disabled", isFirstSlide);
        prevButton.setAttribute("aria-disabled", isFirstSlide ? "true" : "false");
        prevButton.tabIndex = isFirstSlide ? -1 : 0;
      }

      if (nextButton) {
        nextButton.classList.toggle("swiper-button-disabled", isLastSlide);
        nextButton.setAttribute("aria-disabled", isLastSlide ? "true" : "false");
        nextButton.tabIndex = isLastSlide ? -1 : 0;
      }
    };

    const goToSlide = (index) => {
      activeIndex = Math.max(0, Math.min(index, slides.length - 1));
      wrapper.style.transform = `translate3d(-${activeIndex * 100}%, 0, 0)`;
      updateActiveThumb();
      updateNavigation();
    };

    if (prevButton) {
      prevButton.addEventListener("click", function (event) {
        event.preventDefault();

        if (activeIndex > 0) {
          goToSlide(activeIndex - 1);
        }
      });
    }

    if (nextButton) {
      nextButton.addEventListener("click", function (event) {
        event.preventDefault();

        if (activeIndex < slides.length - 1) {
          goToSlide(activeIndex + 1);
        }
      });
    }

    thumbs.forEach((thumb, index) => {
      thumb.dataset.index = String(index);
      thumb.addEventListener("click", function () {
        goToSlide(index);
      });
    });

    goToSlide(0);
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

// Product archive card variations
document.addEventListener("DOMContentLoaded", () => {
  const initProductArchiveCardVariations = (scope = document) => {
    const root =
      scope instanceof Element || scope instanceof Document ? scope : document;
    const productCards = root.querySelectorAll(
      "[data-product-archive-card][data-variation-map], [data-product-slider-card][data-variation-map]",
    );

    productCards.forEach((card) => {
      if (card.dataset.variationReady === "true") {
        return;
      }

      let variationMap = {};

      try {
        variationMap = JSON.parse(card.dataset.variationMap || "{}");
      } catch (error) {
        return;
      }

      const price = card.querySelector("[data-product-card-price]");
      const attributeInput = card.querySelector("[data-product-card-attribute-input]");
      const variationIdInput = card.querySelector('input[name="variation_id"]');
      const radios = card.querySelectorAll("[data-product-card-option]");
      const submitButtons = card.querySelectorAll("[data-product-card-submit]");

      if (!price || !attributeInput || !variationIdInput || !radios.length) {
        return;
      }

      card.dataset.variationReady = "true";

      const setButtonState = (disabled) => {
        submitButtons.forEach((button) => {
          button.disabled = disabled;
        });
      };

      const syncVariation = () => {
        const checkedRadio = card.querySelector("[data-product-card-option]:checked");

        if (!checkedRadio) {
          variationIdInput.value = "";
          attributeInput.value = "";
          setButtonState(true);
          return;
        }

        const variation = variationMap[checkedRadio.value];

        attributeInput.value = checkedRadio.value;

        if (!variation) {
          variationIdInput.value = "";
          setButtonState(true);
          return;
        }

        price.innerHTML = variation.price_html || "";
        variationIdInput.value = variation.variation_id || "";
        setButtonState(!variation.is_purchasable);
      };

      radios.forEach((radio) => {
        radio.addEventListener("change", syncVariation);
      });

      syncVariation();
    });
  };

  initProductArchiveCardVariations();

  document.addEventListener("lvlNevaShopResultsReplaced", (event) => {
    initProductArchiveCardVariations(event.detail?.root || document);
  });
});

document.addEventListener("DOMContentLoaded", () => {
  if (typeof Swiper !== "function") {
    return;
  }

  document
    .querySelectorAll('[equipments-slider="prev"], [equipments-slider="next"]')
    .forEach((element) => {
      element.addEventListener("click", (event) => event.preventDefault());
    });

  document
    .querySelectorAll('[equipments-slider="container"]')
    .forEach((container) => {
      if (container.dataset.swiperReady === "true") {
        return;
      }

      container.dataset.swiperReady = "true";

      new Swiper(container, {
        slidesPerView: 1,
        speed: 900,
        grabCursor: true,
        watchSlidesProgress: true,
        breakpoints: {
          992: {
            slidesPerView: 2,
          },
        },
        effect: "creative",
        creativeEffect: {
          limitProgress: 2,
          prev: {
            translate: ["calc(-100% - 20px)", 0, 0],
            opacity: 1,
            scale: 1,
          },
          next: {
            translate: ["calc(100% + 20px)", 0, 0],
            opacity: 1,
            scale: 1,
          },
        },
        navigation: {
          prevEl: '[equipments-slider="prev"]',
          nextEl: '[equipments-slider="next"]',
          disabledClass: "swiper-button-disabled",
        },
      });
    });
});

// Single product variations
document.addEventListener("DOMContentLoaded", () => {
  const productPurchases = document.querySelectorAll(
    "[data-product-main-purchase][data-variation-map]",
  );

  productPurchases.forEach((purchase) => {
    if (purchase.dataset.variationReady === "true") {
      return;
    }

    let variationMap = {};

    try {
      variationMap = JSON.parse(purchase.dataset.variationMap || "{}");
    } catch (error) {
      return;
    }

    const price = purchase.querySelector("[data-product-main-price]");
    const attributeInput = purchase.querySelector(
      "[data-product-main-attribute-input]",
    );
    const variationIdInput = purchase.querySelector(
      "[data-product-main-variation-id]",
    );
    const radios = purchase.querySelectorAll("[data-product-main-option]");
    const submitButtons = purchase.querySelectorAll("[data-product-main-submit]");

    if (!price || !attributeInput || !variationIdInput || !radios.length) {
      return;
    }

    purchase.dataset.variationReady = "true";

    const setButtonState = (disabled) => {
      submitButtons.forEach((button) => {
        button.disabled = disabled;
      });
    };

    const syncVariation = () => {
      const checkedRadio = purchase.querySelector(
        "[data-product-main-option]:checked",
      );

      if (!checkedRadio) {
        variationIdInput.value = "";
        attributeInput.value = "";
        setButtonState(true);
        return;
      }

      const variation = variationMap[checkedRadio.value];

      attributeInput.value = checkedRadio.value;

      if (!variation) {
        variationIdInput.value = "";
        setButtonState(true);
        return;
      }

      price.innerHTML = variation.price_html || "";
      variationIdInput.value = variation.variation_id || "";
      setButtonState(!variation.is_purchasable);
    };

    radios.forEach((radio) => {
      radio.addEventListener("change", syncVariation);
    });

    syncVariation();
  });
});

// Video player block
document.addEventListener("DOMContentLoaded", function () {
  const videoBlocks = document.querySelectorAll(".video-player-block");

  videoBlocks.forEach((block) => {
    if (block.dataset.videoPlayerReady === "true") {
      return;
    }

    const button = block.querySelector(".video-player-block__play");
    const embedWrap = block.querySelector(".video-player-block__embed-wrap");

    if (!button || !embedWrap) {
      return;
    }

    block.dataset.videoPlayerReady = "true";

    button.addEventListener("click", function () {
      if (block.classList.contains("is-playing")) {
        return;
      }

      const type = block.dataset.videoType || "iframe";
      const src = block.dataset.videoSrc || "";

      if (!src) {
        return;
      }

      let element = null;

      if (type === "video") {
        element = document.createElement("video");
        element.className = "video-player-block__media";
        element.src = src;
        element.controls = true;
        element.autoplay = true;
        element.playsInline = true;
        element.setAttribute("webkit-playsinline", "true");
      } else {
        const hasQuery = src.includes("?");

        element = document.createElement("iframe");
        element.className = "video-player-block__embed";
        element.src = `${src}${hasQuery ? "&" : "?"}autoplay=1&rel=0`;
        element.allow =
          "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
        element.allowFullscreen = true;
        element.title = "Видео";
      }

      embedWrap.innerHTML = "";
      embedWrap.appendChild(element);
      block.classList.add("is-playing");
    });
  });
});

// Legacy GSAP animations
(() => {
  const OPACITY_SCROLL_SELECTOR = "[gsap-opacity-scroll-animation]";
  const ELEMENTS_SCROLL_SELECTOR = "[gsap-elements-scroll-animation]";
  const COVER_DESCRIPTION_SELECTOR = "[cover-description]";
  const SERVICES_SECTION_SELECTOR = "[data-services-section]";
  const SERVICES_IMAGE_SELECTOR = "[data-services-image]";
  const SERVICES_OVERLAY_SELECTOR = "[data-services-overlay]";
  const SERVICES_SCROLL_CONTENT_SELECTOR = "[data-services-scroll-content]";
  const PRODUCTION_VIDEO_CARD_SELECTOR = "[data-production-video-card]";
  const SERVICES_DESKTOP_MEDIA_QUERY = "(min-width: 992px)";
  const SMOOTH_SCROLL_MEDIA_QUERY =
    "(min-width: 992px) and (pointer: fine) and (prefers-reduced-motion: no-preference)";
  const SMOOTH_SCROLL_NORMALIZER_ID = "lvlNevaSmoothScroll";
  const PRODUCTION_VIDEO_CARD_BASE_SIZE = {
    width: "29.9rem",
    height: "17.4rem",
  };
  const PRODUCTION_VIDEO_CARD_HOVER_SIZE = {
    width: "55.5rem",
    height: "30.91rem",
  };
  const ABOUT_BENEFITS_EASE_CURVE = "0.645, 0.045, 0.355, 1";
  const ABOUT_BENEFITS_ANIMATIONS = [
    {
      selector: ".section-about .div--u-iunsh8m2b",
      delay: 0,
    },
    {
      selector: ".section-about .div--u-izfi6odmg",
      delay: 0.3,
    },
  ];
  const RESIZE_DEBOUNCE = 200;
  const animationStateMap = new WeakMap();
  const observedCardElements = new WeakSet();
  const productionVideoHoverStateMap = new WeakMap();

  let gsapRef = null;
  let scrollTriggerRef = null;
  let resizeObserver = null;
  let refreshTimer = 0;
  let resizeTimer = 0;
  let booted = false;
  let aboutBenefitsEase = null;

  const getGsapApi = () => {
    const api = window.taptop || {};
    const gsap = api.gsap || window.gsap;
    const ScrollTrigger =
      (api.gsapPlugins && api.gsapPlugins.ScrollTrigger) || window.ScrollTrigger;
    const CustomEase =
      (api.gsapPlugins && api.gsapPlugins.CustomEase) || window.CustomEase;

    if (!gsap || !ScrollTrigger) {
      return null;
    }

    return { gsap, ScrollTrigger, CustomEase };
  };

  const getAboutBenefitsEase = () => {
    if (aboutBenefitsEase) {
      return aboutBenefitsEase;
    }

    const CustomEase =
      (window.taptop &&
        window.taptop.gsapPlugins &&
        window.taptop.gsapPlugins.CustomEase) ||
      window.CustomEase;

    if (CustomEase && typeof CustomEase.create === "function") {
      aboutBenefitsEase = CustomEase.create(
        "lvlNevaAboutBenefitsEase",
        ABOUT_BENEFITS_EASE_CURVE,
      );

      return aboutBenefitsEase;
    }

    aboutBenefitsEase = "power2.out";

    return aboutBenefitsEase;
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

  const initServicesSectionAnimation = () => {
    const section = document.querySelector(SERVICES_SECTION_SELECTOR);

    if (!section) {
      return;
    }

    cleanupElementAnimations(section);

    const desktopImage = section.querySelector(SERVICES_IMAGE_SELECTOR);
    const overlay = section.querySelector(SERVICES_OVERLAY_SELECTOR);
    const scrollContent = section.querySelector(SERVICES_SCROLL_CONTENT_SELECTOR);

    if (!desktopImage || !overlay || !scrollContent) {
      return;
    }

    gsapRef.set(desktopImage, { width: "100%", height: "100%" });
    gsapRef.set(overlay, { opacity: 1 });

    if (!window.matchMedia(SERVICES_DESKTOP_MEDIA_QUERY).matches) {
      return;
    }

    const state = ensureState(section);
    const timeline = gsapRef.timeline({
      scrollTrigger: {
        trigger: scrollContent,
        start: "top+=-115% 0%",
        end: "top+=0% 100%",
        scrub: 2,
        invalidateOnRefresh: true,
      },
    });

    timeline.to(
      overlay,
      {
        opacity: 0,
        ease: "none",
      },
      0,
    );

    timeline.to(
      desktopImage,
      {
        width: "50%",
        height: "100%",
        ease: "none",
      },
      0,
    );

    state.animations.push(timeline);
  };

  const initSmoothScroll = () => {
    if (
      !scrollTriggerRef ||
      typeof scrollTriggerRef.normalizeScroll !== "function"
    ) {
      return;
    }

    const currentNormalizer = scrollTriggerRef.normalizeScroll();
    const shouldEnableSmoothScroll = window.matchMedia(
      SMOOTH_SCROLL_MEDIA_QUERY,
    ).matches;

    if (!shouldEnableSmoothScroll) {
      if (
        currentNormalizer &&
        currentNormalizer.vars &&
        currentNormalizer.vars.id === SMOOTH_SCROLL_NORMALIZER_ID
      ) {
        scrollTriggerRef.normalizeScroll(false);
      }

      return;
    }

    if (
      currentNormalizer &&
      currentNormalizer.vars &&
      currentNormalizer.vars.id === SMOOTH_SCROLL_NORMALIZER_ID
    ) {
      return;
    }

    if (currentNormalizer) {
      scrollTriggerRef.normalizeScroll(false);
    }

    scrollTriggerRef.normalizeScroll({
      id: SMOOTH_SCROLL_NORMALIZER_ID,
      allowNestedScroll: true,
      debounce: true,
      lockAxis: false,
      type: "wheel,touch",
      momentum: (self) => {
        const velocity = Math.abs(self.velocityY || 0);

        return Math.min(1.4, Math.max(0.55, velocity / 2200));
      },
    });
  };

  const cleanupProductionVideoHover = (element) => {
    const state = productionVideoHoverStateMap.get(element);

    if (!state) {
      if (gsapRef) {
        gsapRef.killTweensOf(element);
      }

      return;
    }

    element.removeEventListener("mouseenter", state.handleEnter);
    element.removeEventListener("mouseleave", state.handleLeave);

    if (state.tween && typeof state.tween.kill === "function") {
      state.tween.kill();
    }

    gsapRef.killTweensOf(element);
    productionVideoHoverStateMap.delete(element);
  };

  const animateProductionVideoCard = (element, size) => {
    gsapRef.killTweensOf(element);

    return gsapRef.to(element, {
      ...size,
      duration: 0.6,
      ease: "power1.inOut",
      overwrite: "auto",
    });
  };

  const initProductionVideoHover = () => {
    document.querySelectorAll(PRODUCTION_VIDEO_CARD_SELECTOR).forEach((element) => {
      cleanupProductionVideoHover(element);

      if (!window.matchMedia(SERVICES_DESKTOP_MEDIA_QUERY).matches) {
        element.style.width = "";
        element.style.height = "";
        return;
      }

      gsapRef.set(element, PRODUCTION_VIDEO_CARD_BASE_SIZE);

      const state = {
        handleEnter: () => {
          state.tween = animateProductionVideoCard(
            element,
            PRODUCTION_VIDEO_CARD_HOVER_SIZE,
          );
        },
        handleLeave: () => {
          state.tween = animateProductionVideoCard(
            element,
            PRODUCTION_VIDEO_CARD_BASE_SIZE,
          );
        },
        tween: null,
      };

      element.addEventListener("mouseenter", state.handleEnter);
      element.addEventListener("mouseleave", state.handleLeave);
      productionVideoHoverStateMap.set(element, state);
    });
  };

  const initAboutBenefitsAnimations = () => {
    ABOUT_BENEFITS_ANIMATIONS.forEach(({ selector, delay }) => {
      document.querySelectorAll(selector).forEach((element) => {
        cleanupElementAnimations(element);

        if (!window.matchMedia(SERVICES_DESKTOP_MEDIA_QUERY).matches) {
          element.style.transform = "translate(0px, 0px)";
          return;
        }

        const state = ensureState(element);

        state.animations.push(
          gsapRef.fromTo(
            element,
            {
              x: "0px",
              y: "23%",
              z: "0px",
            },
            {
              x: "0px",
              y: "0%",
              z: "0px",
              duration: 0.6,
              delay,
              ease: getAboutBenefitsEase(),
              immediateRender: true,
              force3D: true,
              scrollTrigger: {
                trigger: element,
                start: "center bottom",
                once: true,
                toggleActions: "play none none none",
              },
              onComplete: () => {
                element.style.transform = "translate(0px, 0px)";
              },
            },
          ),
        );
      });
    });
  };

  const rebuildResponsiveAnimations = () => {
    initSmoothScroll();
    initAboutBenefitsAnimations();
    initServicesSectionAnimation();
    initProductionVideoHover();
    document.querySelectorAll(ELEMENTS_SCROLL_SELECTOR).forEach((element) => {
      ensureCardStructure(element);
    });
    scheduleRefresh();
  };

  const initLegacyGsapAnimations = (api) => {
    gsapRef = api.gsap;
    scrollTriggerRef = api.ScrollTrigger;

    gsapRef.registerPlugin(scrollTriggerRef);

    if (api.CustomEase) {
      gsapRef.registerPlugin(api.CustomEase);
    }

    initSmoothScroll();
    initCoverDescriptionAnimation();
    initOpacityAnimations();
    initAboutBenefitsAnimations();
    initServicesSectionAnimation();
    initProductionVideoHover();
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
