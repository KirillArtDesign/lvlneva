(function () {
  const COOKIE_MAX_AGE = 60 * 60 * 24 * 180;

  const initCookieNotice = () => {
    const notice = document.querySelector("[data-cookie-notice]");

    if (!notice || notice.dataset.cookieNoticeReady === "true") {
      return;
    }

    notice.dataset.cookieNoticeReady = "true";

    const cookieName =
      notice.getAttribute("data-cookie-name") || "lvl_neva_cookie_notice_accepted";
    const acceptButton = notice.querySelector("[data-cookie-notice-accept]");

    const hasConsent = () =>
      document.cookie
        .split(";")
        .map((item) => item.trim())
        .some((item) => item === `${cookieName}=1`);

    const hideNotice = () => {
      notice.classList.add("cookie-notice--hidden");

      window.setTimeout(() => {
        notice.remove();
      }, 320);
    };

    const setConsent = () => {
      document.cookie = `${cookieName}=1; path=/; max-age=${COOKIE_MAX_AGE}; SameSite=Lax`;
    };

    if (hasConsent()) {
      hideNotice();
      return;
    }

    if (!acceptButton) {
      return;
    }

    acceptButton.addEventListener("click", () => {
      setConsent();
      hideNotice();
    });
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCookieNotice, { once: true });
  } else {
    initCookieNotice();
  }
})();
