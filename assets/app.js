/* Machine Learning — Practical Programs. Code tabs, copy, download. */
(function () {
  "use strict";
  function copyText(text, btn) {
    var done = function () { var t = btn.textContent; btn.textContent = "Copied"; setTimeout(function () { btn.textContent = t; }, 1400); };
    if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(text).then(done, fallback); else fallback();
    function fallback() { var ta = document.createElement("textarea"); ta.value = text; document.body.appendChild(ta); ta.select(); try { document.execCommand("copy"); done(); } catch (e) {} document.body.removeChild(ta); }
  }
  window.copyText = copyText;
  document.querySelectorAll(".code").forEach(function (box) {
    var tabs = box.querySelectorAll(".code-tabs [role=tab]"), panels = box.querySelectorAll(".code-panel");
    tabs.forEach(function (t, i) {
      t.addEventListener("click", function () {
        tabs.forEach(function (x) { x.setAttribute("aria-selected", "false"); });
        panels.forEach(function (p) { p.classList.remove("active"); });
        t.setAttribute("aria-selected", "true"); panels[i].classList.add("active");
      });
    });
    var copy = box.querySelector(".copy");
    if (copy) copy.addEventListener("click", function () {
      var p = box.querySelector(".code-panel.active pre");
      copyText(Array.prototype.map.call(p.querySelectorAll(".ln"), function (l) { return l.textContent; }).join("\n"), copy);
    });
    var dl = box.querySelector(".dl");
    if (dl) dl.addEventListener("click", function () {
      var p = box.querySelector(".code-panel.active");
      var a = document.createElement("a"); a.href = p.getAttribute("data-src"); a.download = p.getAttribute("data-name");
      document.body.appendChild(a); a.click(); document.body.removeChild(a);
    });
  });
})();
