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
