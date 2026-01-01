(function () {
  function initMap() {
    const mapEl = document.getElementById("map");
    if (!mapEl || typeof L === "undefined") return;

    // Global map
    window.map = L.map("map").setView([41.0082, 28.9784], 11);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: "&copy; OpenStreetMap contributors",
    }).addTo(window.map);

    (window.MARKERS || []).forEach((m) => {
      L.marker([m.lat, m.lng])
        .addTo(window.map)
        .bindPopup(`<b>${m.title}</b><br>${m.address}`);
    });
  }

  function initFullscreen() {
    const btnFs = document.getElementById("btnOpenMapFullScreen");
    const btnExit = document.getElementById("btnExitMapFullScreen");
    const overlay = document.getElementById("modalMapFullScreen");

    const mapEl = document.getElementById("map");
    const fsSlot = document.getElementById("mapFullscreen");

    if (!btnFs || !btnExit || !overlay || !mapEl || !fsSlot) return;

    const originalParent = mapEl.parentNode;
    const originalNext = mapEl.nextSibling;

    function safeInvalidate() {
      setTimeout(() => {
        if (window.map && typeof window.map.invalidateSize === "function") {
          window.map.invalidateSize(true);
        }
      }, 50);
    }

    function openFullscreen() {
      overlay.classList.remove("hidden");
      overlay.classList.add("block");
      overlay.setAttribute("aria-hidden", "false");

      fsSlot.appendChild(mapEl);

      mapEl.classList.remove("h-[420px]");
      mapEl.classList.add("h-full");

      safeInvalidate();
    }

    function closeFullscreen() {
      overlay.classList.add("hidden");
      overlay.classList.remove("block");
      overlay.setAttribute("aria-hidden", "true");

      if (originalParent) {
        if (originalNext) originalParent.insertBefore(mapEl, originalNext);
        else originalParent.appendChild(mapEl);
      }

      mapEl.classList.remove("h-full");
      mapEl.classList.add("h-[420px]");

      safeInvalidate();
    }

    btnFs.addEventListener("click", openFullscreen);
    btnExit.addEventListener("click", closeFullscreen);

    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && !overlay.classList.contains("hidden")) {
        closeFullscreen();
      }
    });

    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) closeFullscreen();
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    initMap();
    initFullscreen();
  });
})();
