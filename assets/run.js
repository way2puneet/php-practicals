/* Runs the book's PHP programs in the browser with php-wasm (PHP 8.3 compiled to WebAssembly).
   Each request starts a fresh PHP, like a real web server. A small prelude passes in the form data,
   and keeps cookies and the session between requests, so forms, cookies and sessions work. */
(function () {
  "use strict";
  var PHP_WASM = "https://cdn.jsdelivr.net/npm/php-wasm@0.2.0/PhpWeb.mjs";
  var phpPromise = null, prelude = null, output = "";

  function loadPHP(status) {
    if (phpPromise) return phpPromise;
    status("Downloading PHP. The first run takes a little while; after that it is quick.");
    phpPromise = import(PHP_WASM).then(function (mod) {
      var php = new mod.PhpWeb({ version: "8.3" });
      php.addEventListener("output", function (e) { output += e.detail.join(""); });
      php.addEventListener("error", function (e) { output += e.detail.join(""); });
      return Promise.all([php.binary, fetch("assets/prelude.txt?v=1").then(function (r) { return r.text(); })])
        .then(function (res) { prelude = res[1]; return php; });
    });
    phpPromise.catch(function () { phpPromise = null; });
    return phpPromise;
  }

  function randomId() {
    var c = "abcdefghijklmnopqrstuv0123456789", s = "";
    for (var i = 0; i < 26; i++) s += c[Math.floor(Math.random() * c.length)];
    return s;
  }
  function esc(s) { return String(s).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;"); }

  function resolve(base, href) {
    // base: current file path such as "includes/a.php"; href: relative link such as "b.php?x=1"
    var dir = base.indexOf("/") >= 0 ? base.replace(/\/[^/]*$/, "/") : "";
    var parts = (dir + href).split("/"), out = [];
    parts.forEach(function (p) { if (p === "..") out.pop(); else if (p !== ".") out.push(p); });
    return out.join("/");
  }

  async function mkdirs(php, path) {
    var parts = path.split("/").filter(Boolean), cur = "";
    for (var i = 0; i < parts.length; i++) {
      cur += "/" + parts[i];
      var info = null;
      try { info = await php.analyzePath(cur); } catch (e) { info = null; }
      if (info && info.exists) continue;
      try { await php.mkdir(cur); } catch (e) { /* already exists */ }
    }
  }

  document.querySelectorAll(".php-runner").forEach(function (box) {
    var cfg = JSON.parse(box.querySelector("script[type='application/json']").textContent);
    var tabs = box.querySelectorAll(".pr-tabs button[data-file]");
    var areas = box.querySelectorAll("textarea[data-file]");
    var runBtn = box.querySelector(".run"), resetBtn = box.querySelector(".reset-code"), clearBtn = box.querySelector(".clear-state");
    var statusEl = box.querySelector(".status"), frame = box.querySelector("iframe"), urlEl = box.querySelector(".pr-url");
    var sourceEl = box.querySelector(".pr-source pre"), stateEl = box.querySelector(".pr-state");
    var viewBtns = box.querySelectorAll(".pr-view button");
    var entrySel = box.querySelector(".pr-entry");
    var originals = {}, cookies = {}, session = "", sessionId = randomId(), uploads = {}, current = cfg.entries[0], busy = false;
    areas.forEach(function (a) { originals[a.dataset.file] = a.value; });

    function status(t, err) { statusEl.textContent = t; statusEl.classList.toggle("err", !!err); }

    tabs.forEach(function (t) {
      t.addEventListener("click", function () {
        tabs.forEach(function (x) { x.setAttribute("aria-selected", x === t ? "true" : "false"); });
        areas.forEach(function (a) { a.hidden = a.dataset.file !== t.dataset.file; });
      });
    });
    areas.forEach(function (ta) {
      ta.addEventListener("keydown", function (e) {
        if (e.key === "Tab") {
          e.preventDefault();
          var s = ta.selectionStart, en = ta.selectionEnd;
          ta.value = ta.value.slice(0, s) + "    " + ta.value.slice(en);
          ta.selectionStart = ta.selectionEnd = s + 4;
        } else if (e.key === "Enter" && (e.ctrlKey || e.metaKey)) { e.preventDefault(); runBtn.click(); }
      });
    });
    viewBtns.forEach(function (b) {
      b.addEventListener("click", function () {
        viewBtns.forEach(function (x) { x.setAttribute("aria-selected", x === b ? "true" : "false"); });
        box.querySelector(".pr-page").hidden = b.dataset.view !== "page";
        box.querySelector(".pr-source").hidden = b.dataset.view !== "source";
      });
    });
    resetBtn.addEventListener("click", function () {
      areas.forEach(function (a) { a.value = originals[a.dataset.file]; });
      status("Code restored to the original program.");
    });
    clearBtn.addEventListener("click", function () {
      cookies = {}; session = ""; sessionId = randomId(); uploads = {}; showState();
      status("Cookies, session and uploaded files cleared, as in a new private browser window.");
    });

    function showState() {
      var now = Date.now() / 1000, c = Object.keys(cookies);
      var parts = [];
      if (c.length) parts.push("<b>Cookies in the browser:</b> " + c.map(function (k) {
        var x = cookies[k], when = x.expires ? "expires " + new Date(x.expires * 1000).toLocaleString() : "until the browser closes";
        return "<code>" + esc(k) + " = " + esc(x.value) + "</code> (" + when + ")";
      }).join(", "));
      if (session) parts.push("<b>Session data on the server:</b> <code>" + esc(session) + "</code>");
      stateEl.innerHTML = parts.join("<br>");
      stateEl.hidden = !parts.length;
    }

    async function request(php, entry, method, getQs, postQs, files) {
      await php.refresh();
      await mkdirs(php, "/app"); await mkdirs(php, "/srv");
      var dirs = (cfg.dirs || []).slice();
      for (var i = 0; i < dirs.length; i++) await mkdirs(php, "/app/" + dirs[i]);
      for (var j = 0; j < areas.length; j++) {
        var f = areas[j].dataset.file;
        if (f.indexOf("/") >= 0) await mkdirs(php, "/app/" + f.replace(/\/[^/]*$/, ""));
        await php.writeFile("/app/" + f, areas[j].value);
      }
      for (var up in uploads) { await mkdirs(php, "/app/" + up.replace(/\/[^/]*$/, "")); await php.writeFile("/app/" + up, uploads[up]); }
      var fileInfo = {};
      for (var k = 0; k < files.length; k++) {
        var fl = files[k];
        if (!fl.file || (!fl.file.name && fl.file.size === 0)) {
          fileInfo[fl.name] = { name: "", type: "", tmp_name: "", error: 4, size: 0 };
        } else {
          var tmp = "/tmp/__pk_upload_" + k;
          await php.writeFile(tmp, new Uint8Array(await fl.file.arrayBuffer()));
          fileInfo[fl.name] = { name: fl.file.name, full_path: fl.file.name, type: fl.file.type || "application/octet-stream", tmp_name: tmp, error: 0, size: fl.file.size };
        }
      }
      var now = Date.now() / 1000, jar = {};
      Object.keys(cookies).forEach(function (n) { jar[n] = cookies[n].value; });
      await php.writeFile("/tmp/__pk_req.json", JSON.stringify({
        entry: entry, method: method, get: getQs, post: postQs, cookies: jar, files: fileInfo, session: session, session_id: sessionId
      }));
      output = "";
      await php.run(prelude);
      var out = {};
      try { out = JSON.parse(new TextDecoder().decode(await php.readFile("/tmp/__pk_out.json"))); } catch (e) { out = {}; }
      (out.cookies || []).forEach(function (c) {
        var name = c[0], value = c[1], exp = c[2];
        if (value === "" || (exp && exp < Date.now() / 1000)) delete cookies[name];
        else cookies[name] = { value: value, expires: exp };
      });
      if (out.session !== null && out.session !== undefined) session = out.session;
      if (out.session_destroyed) { session = ""; }
      for (var nf = 0; nf < (out.new_files || []).length; nf++) {
        var path = out.new_files[nf];
        try { uploads[path] = await php.readFile("/app/" + path); } catch (e) { }
      }
      return { html: output, location: out.location };
    }

    async function render(php, html, entry) {
      sourceEl.textContent = html || "(The page sent no output.)";
      frame.srcdoc = html || "<p style='font:14px sans-serif;color:#777'>(The page sent no output.)</p>";
      await new Promise(function (r) { frame.onload = r; });
      var doc = frame.contentDocument;
      if (!doc) return;
      // images saved by the program (for example uploaded photos)
      doc.querySelectorAll("img[src]").forEach(function (img) {
        var src = img.getAttribute("src");
        if (/^(https?:|data:|\/\/)/.test(src)) return;
        var path = resolve(entry, src.split("?")[0]);
        if (uploads[path]) img.src = URL.createObjectURL(new Blob([uploads[path]]));
      });
      doc.addEventListener("click", function (e) {
        var a = e.target.closest && e.target.closest("a[href]");
        if (!a) return;
        var href = a.getAttribute("href");
        if (/^(https?:|mailto:|#|javascript:)/.test(href)) { if (href[0] !== "#") e.preventDefault(); return; }
        e.preventDefault();
        var target = href.split("?")[0] ? resolve(entry, href.split("?")[0]) : entry;
        go(target, "GET", href.indexOf("?") >= 0 ? href.split("?")[1] : "", "", []);
      }, true);
      doc.addEventListener("submit", function (e) {
        e.preventDefault();
        var form = e.target, fd;
        try { fd = new FormData(form, e.submitter); } catch (err) { fd = new FormData(form); }
        var method = (form.getAttribute("method") || "get").toUpperCase();
        var action = form.getAttribute("action");
        var target = action ? resolve(entry, action.split("?")[0]) : entry;
        var params = new URLSearchParams(), files = [];
        fd.forEach(function (v, k) { if (v instanceof File) files.push({ name: k, file: v }); else params.append(k, v); });
        if (method === "POST") go(target, "POST", action && action.indexOf("?") >= 0 ? action.split("?")[1] : "", params.toString(), files);
        else go(target, "GET", params.toString(), "", []);
      }, true);
    }

    async function go(entry, method, getQs, postQs, files) {
      if (busy) return;
      busy = true; runBtn.disabled = true;
      var t0 = Date.now();
      try {
        var php = await loadPHP(status);
        status("Running " + entry + " …");
        var hops = 0, res;
        while (true) {
          res = await request(php, entry, method, getQs, postQs, files);
          if (!res.location || hops++ > 3) break;   // follow header("Location: ...") like a browser
          var loc = res.location.replace(/^https?:\/\/[^/]+\//, "");
          entry = resolve(entry, loc.split("?")[0]); getQs = loc.indexOf("?") >= 0 ? loc.split("?")[1] : ""; method = "GET"; postQs = ""; files = [];
        }
        current = entry;
        urlEl.textContent = "localhost/phpbook/" + cfg.folder + "/" + entry + (getQs ? "?" + getQs : "");
        await render(php, res.html, entry);
        showState();
        status((method === "POST" ? "Form posted to " : "Opened ") + entry + " in " + ((Date.now() - t0) / 1000).toFixed(1) + " s. Use the page, or change the code and run again.");
      } catch (err) {
        status((err && err.message) || "Could not run PHP. Check your internet connection and try again.", true);
      }
      busy = false; runBtn.disabled = false;
    }

    runBtn.addEventListener("click", function () { go(entrySel ? entrySel.value : cfg.entries[0], "GET", "", "", []); });
  });
})();
