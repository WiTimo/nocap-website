(function () {
  "use strict";

  var home = document.querySelector(".nocap-modern-home");
  if (!home) {
    return;
  }

  var supportsHover = window.matchMedia("(hover: hover)").matches;

  var bindArrowSwitch = function (buttons, onActivate) {
    buttons.forEach(function (button, index) {
      button.addEventListener("keydown", function (event) {
        var key = event.key;
        if (key !== "ArrowRight" && key !== "ArrowDown" && key !== "ArrowLeft" && key !== "ArrowUp") {
          return;
        }

        event.preventDefault();
        var direction = key === "ArrowRight" || key === "ArrowDown" ? 1 : -1;
        var nextIndex = (index + direction + buttons.length) % buttons.length;
        var nextButton = buttons[nextIndex];

        nextButton.focus();
        onActivate(nextButton);
      });
    });
  };

  var initReviewSwitch = function () {
    var tabs = Array.prototype.slice.call(document.querySelectorAll("[data-review-tab]"));
    var panels = Array.prototype.slice.call(document.querySelectorAll("[data-review-panel]"));

    if (!tabs.length || !panels.length) {
      return;
    }

    var activateTab = function (tab) {
      var target = tab.getAttribute("data-review-tab");

      tabs.forEach(function (item) {
        var isActive = item === tab;
        item.classList.toggle("is-active", isActive);
        item.setAttribute("aria-selected", isActive ? "true" : "false");
        item.setAttribute("tabindex", isActive ? "0" : "-1");
      });

      panels.forEach(function (panel) {
        var isActive = panel.getAttribute("data-review-panel") === target;
        panel.classList.toggle("is-active", isActive);
        panel.setAttribute("aria-hidden", isActive ? "false" : "true");
      });
    };

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        activateTab(tab);
      });

      tab.addEventListener("focus", function () {
        activateTab(tab);
      });

      if (supportsHover) {
        tab.addEventListener("mouseenter", function () {
          activateTab(tab);
        });
      }
    });

    bindArrowSwitch(tabs, activateTab);

    var currentTab = document.querySelector(".nocap-review-chip.is-active") || tabs[0];
    activateTab(currentTab);
  };

  var initProductSwitch = function () {
    var stage = document.querySelector("[data-product-stage]");
    var stageName = stage ? stage.querySelector("[data-product-stage-name]") : null;
    var stageTag = stage ? stage.querySelector("[data-product-stage-tag]") : null;
    var stageDescription = stage ? stage.querySelector("[data-product-stage-description]") : null;
    var buttons = Array.prototype.slice.call(document.querySelectorAll("[data-product-button]"));

    if (!stage || !stageName || !stageTag || !stageDescription || !buttons.length) {
      return;
    }

    var activateProduct = function (button) {
      var image = button.getAttribute("data-product-image") || "";
      var name = button.getAttribute("data-product-name") || "";
      var tag = button.getAttribute("data-product-tag") || "";
      var description = button.getAttribute("data-product-description") || "";

      buttons.forEach(function (item) {
        var isActive = item === button;
        item.classList.toggle("is-active", isActive);
        item.setAttribute("aria-selected", isActive ? "true" : "false");
        item.setAttribute("tabindex", isActive ? "0" : "-1");
      });

      if (image) {
        stage.style.setProperty("--active-image", "url(" + image + ")");
      }

      stageName.textContent = name;
      stageTag.textContent = tag;
      stageDescription.textContent = description;
    };

    buttons.forEach(function (button) {
      button.addEventListener("click", function () {
        activateProduct(button);
      });

      button.addEventListener("focus", function () {
        activateProduct(button);
      });

      if (supportsHover) {
        button.addEventListener("mouseenter", function () {
          activateProduct(button);
        });
      }
    });

    bindArrowSwitch(buttons, activateProduct);

    var currentButton = document.querySelector(".nocap-product-track.is-active") || buttons[0];
    activateProduct(currentButton);
  };

  initReviewSwitch();
  initProductSwitch();

  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var revealNodes = document.querySelectorAll("[data-reveal]");

  if (reduceMotion || typeof IntersectionObserver === "undefined") {
    document.body.classList.add("nocap-reduced-motion");
    revealNodes.forEach(function (node) {
      node.classList.add("is-visible");
    });
  } else {
    var revealObserver = new IntersectionObserver(
      function (entries, observer) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        });
      },
      {
        threshold: 0.18,
        rootMargin: "0px 0px -9% 0px"
      }
    );

    revealNodes.forEach(function (node) {
      revealObserver.observe(node);
    });
  }

  var heroMedia = document.querySelector(".nocap-hero-media");
  if (!heroMedia) {
    return;
  }

  var heroVideo = document.querySelector("#nocap-hero-video");
  if (heroVideo) {
    var heroSource = heroVideo.querySelector("source");
    var desktopVideo = heroVideo.getAttribute("data-src-desktop");
    var mobileVideo = heroVideo.getAttribute("data-src-mobile");
    var currentMode = null;

    var updateHeroVideoSource = function () {
      var useMobile = window.innerWidth <= 900;
      var desiredSrc = useMobile ? mobileVideo : desktopVideo;
      var mode = useMobile ? "mobile" : "desktop";

      if (currentMode === mode || !heroSource || !desiredSrc) {
        return;
      }

      currentMode = mode;
      heroSource.setAttribute("src", desiredSrc);
      heroVideo.load();
    };

    var resizeTimer = null;
    var onResizeVideo = function () {
      if (resizeTimer) {
        window.clearTimeout(resizeTimer);
      }
      resizeTimer = window.setTimeout(function () {
        updateHeroVideoSource();
      }, 200);
    };

    updateHeroVideoSource();
    window.addEventListener("resize", onResizeVideo);
  }

  var ticking = false;

  var updateParallax = function () {
    var rect = heroMedia.getBoundingClientRect();
    var vh = window.innerHeight || document.documentElement.clientHeight;

    if (rect.bottom <= 0 || rect.top >= vh) {
      ticking = false;
      return;
    }

    var progress = (vh - rect.top) / (vh + rect.height);
    var shift = Math.max(-12, Math.min(12, (progress - 0.5) * 24));

    heroMedia.style.transform = "translateY(" + shift.toFixed(2) + "px)";
    ticking = false;
  };

  var requestUpdate = function () {
    if (ticking) {
      return;
    }
    ticking = true;
    window.requestAnimationFrame(updateParallax);
  };

  window.addEventListener("scroll", requestUpdate, { passive: true });
  window.addEventListener("resize", requestUpdate);
  requestUpdate();
})();
