//v1.8.0
import { initialize as iframeResizeInitialize } from "https://cdn.jsdelivr.net/npm/@open-iframe-resizer/core@latest/dist/index.js";
import lodashIsequal from "https://cdn.jsdelivr.net/npm/lodash.isequal@4.5.0/+esm";

document.addEventListener("DOMContentLoaded", function () {
  initGlobalForm();
});

function initGlobalForm() {

  //check if should use usercentrics
  const useUC = window?.globalFormData?.useUC ?? false;
  //iframeSelector
  let iframeSelector = window?.globalFormData?.iframeSelector;
  if (!iframeSelector || !document.querySelector(iframeSelector)) {
    iframeSelector = "#global-form-iframe";
  }
  const iframeContainerSelector =
    window?.globalFormData?.iframeContainerSelector;
  const replaceSelector = window?.globalFormData?.replaceSelector;
  const replaceShouldClone =
    window?.globalFormData?.replaceShouldClone ?? false;
  const ignoreHeight = window?.globalFormData?.ignoreHeight ?? false;
  let iframeList = document.querySelectorAll(iframeSelector);

  //loadingSelector, loaderList
  const loadingSelector = window?.globalFormData?.loadingSelector || false;
  let loaderList = [];
  if (loadingSelector) {
    loaderList = document.querySelectorAll(loadingSelector);
  }
  //iframeUrl
  const iframeUrl = window?.globalFormData?.iframeUrl;
  if (!iframeUrl) {
    log("window.globalFormData.iframeUrl not found", true);
    return;
  }
  //framework
  const framework = window?.globalFormData?.framework || "vanilla";

  //variables
  let controllerId = null;
  let consent = null;

  //setup default parameters for this form
  let params = new URLSearchParams(window?.globalFormData?.params || {});
  //list of parameters that can be overwritten by the page url
  const paramList = [
    "test",
    "id",
    "eid",
    "cid",
    "gclid",
    "fbclid",
    "msclkid",
    "utm_content",
    "utm_term",
    ["utm_medium", "utm_campaign", "utm_source"],
  ];
  const urlParams = new URLSearchParams(window.location.search);
  //add or overwrite existing params if in window.location.search (page url)
  paramList.forEach((item) => {
    if (Array.isArray(item)) {
      //if item is array then check all keys in item array have values in urlParams
      const list = [];
      item.forEach((key) => {
        const value = urlParams.get(key);
        if (!isBlank(value)) {
          list.push(key);
        }
      });
      //if all keys in item array are present then set param for each key
      if (list.length == item.length) {
        list.map((key) => setParam(urlParams, params, key));
      }
    } else {
      //if item is a string just set the param
      const key = item;
      setParam(urlParams, params, key);
    }
  });
  //pass current page url
  params.set("href", window.location.href);

  function loopIframes(callback) {
    iframeList.forEach((el) => {
      callback(el);
    });
  }

  function loopLoaders(callback) {
    loaderList.forEach((el) => {
      callback(el);
    });
  }

  function initIframe() {
    log("⏳ Loading global form...");
    //setup iframe element
    loopIframes((el) => {
      el.setAttribute("frameBorder", "0");
      el.style.width = "100%";
      if (!ignoreHeight) {
        if (isBlank(el.style.height)) el.style.height = "820px";
      }
      //add src attribute to iframe element (containing iframeUrl and our parameters)
      el.setAttribute("src", `${iframeUrl}?${params.toString()}`);
    });
  }

  function initIframeWithUC() {
    log("⏳ Waiting for usercentrics init...");

    if (loadingSelector) {
      loaderList = document.querySelectorAll(loadingSelector);
    } else {
      //create simple loader overlay if there is not a custom loader present
      loopIframes((el) => {
        loaderList.push(createLoader(el));
      });
    }

    //handle page routing in nextjs where browser does not reload
    if (framework == "nextjs" && !window?.globalFormReady) {
      try {
        const loaded = UC_UI?.isInitialized?.();
        window.globalFormReady = loaded;
      } catch {
        window.globalFormReady = false;
      }
    }

    if (window?.globalFormReady) {
      log("✅ Usercentrics init");
      checkControllerIdChanged();
      checkConsentChanged();
      initIframe();
    } else {
      //wait for usercentrics to load before init iframe (max 5 seconds)
      window.addEventListener("UC_UI_INITIALIZED", function (event) {
        if (window?.globalFormReady) return;
        log("✅ Usercentrics init");
        checkControllerIdChanged();
        checkConsentChanged();
        initIframe();
        window.globalFormReady = true;
      });
    }

    //init iframe if it has been > 5 seconds
    let waitTime = 5000;
    window.setTimeout(() => {
      if (window?.globalFormReady) return;
      log(`❌ Usercentrics did not load within ${waitTime}ms`);
      initIframe();
      window.globalFormReady = true;
    }, waitTime);

    //if usercentrics session restore then reload form IF controllerId is different
    window.addEventListener("userCentricsEvent", (event) => {
      if (!window?.globalFormReady) return;
      log(`⚠️ usercentrics:${event?.detail?.action}`);
      const isControllerIdChanged =
        checkControllerIdChanged() == 1 ? true : false;
      const isConsentChanged = checkConsentChanged() == 1 ? true : false;
      if (isControllerIdChanged || isConsentChanged) {
        log("🔄 Reloading form...");
        loopLoaders((el) => {
          el.style.display = "flex";
        });
        if (isControllerIdChanged) {
          initIframe();
        } else {
          loopIframes((el) => {
            el.src = el.src; //reloads the iframe
          });
        }
      }
    });
  }

  function checkConsentChanged() {
    let lastestConsent;
    let status = 0; //0=no change | 1=changed | 2=init
    const list = new Map();
    const services = window?.UC_UI?.getServicesBaseInfo?.();

    if (services && services.length > 0) {
      services.forEach((service) => {
        list.set(service.name, service.consent.status);
      });
      lastestConsent = Object.fromEntries(list);
    }
    if (consent === null) {
      status = 2;
    } else if (lastestConsent) {
      status = lodashIsequal(consent, lastestConsent) ? 0 : 1;
      if (status == 0) log(`✅ No consent changes`);
      if (status == 1) log(`⚠️ Consent changed`);
    }

    if (lastestConsent) consent = lastestConsent;
    return status;
  }

  function checkControllerIdChanged() {
    let status = 0; //0=no change | 1=changed | 2=init
    const _controllerId = window?.UC_UI?.getControllerId?.();
    //if controllerId is new (init or changed)
    if (!isBlank(_controllerId) && _controllerId != controllerId) {
      if (controllerId === null) {
        status = 2;
      } else {
        status = 1;
        log(`⚠️ ControllerId changed`);
      }

      controllerId = _controllerId;
      params.set("controller_id", controllerId);
    } else if (status == 0) {
      //if controllerId has not changed
      log("✅ No new controllerId");
    }
    return status;
  }

  function replaceExistingEmbed() {
    if (replaceSelector) {
      const els = document.querySelectorAll(replaceSelector);
      for (let i = 0; i < els.length; i++) {
        const existingEl = els[i];
        let source;
        if (iframeContainerSelector) {
          source = document.querySelector(iframeContainerSelector);
        } else {
          source = iframeList[0];
        }
        if (replaceShouldClone) {
          source = source.cloneNode(true);
        }
        if (source.contains(existingEl)) return;
        existingEl.replaceWith(source);
        log("⚠️ Replaced an existing form");
      }
      iframeList = document.querySelectorAll(iframeSelector);
    }
  }

  //--- start running things
  replaceExistingEmbed();

  //listen for iframe form to be loaded
  loopIframes((el) => {
    el.addEventListener("load", function () {
      if (isBlank(el.src)) return;
      log("🚀 Global form loaded");
      //hide loaders
      loopLoaders((el_loader) => {
        el_loader.style.display = "none";
      });
      //intialize iframe resizer
      iframeResizeInitialize({}, this);
    });
  });

  //main init
  if (useUC) {
    initIframeWithUC();
  } else {
    initIframe();
  }

  //--- utility functions
  function log(x, error = false) {
    const prefix = "##global-form##";
    if (error) {
      console.error(prefix, x);
    } else {
      if (Array.isArray(x)) {
        console.log(prefix, ...x);
      } else {
        console.log(prefix, x);
      }
    }
  }

  function setParam(source, destination, key) {
    const value = source.get(key);
    if (!isBlank(value)) {
      destination.set(key, value);
    }
  }

  function isBlank(str) {
    return !str || /^\s*$/.test(str);
  }

  function createLoader(element) {
    const wrapper = document.createElement("div");
    const parent = element.parentNode;
    const nextSibling = element.nextSibling;
    parent.insertBefore(wrapper, nextSibling);
    wrapper.appendChild(element);
    wrapper.style.width = "100%";
    wrapper.style.position = "relative";
    const el = document.createElement("div");
    el.setAttribute("data-loader", true);
    el.innerHTML = "Loading form...";
    el.style.display = "flex";
    el.style.justifyContent = "center";
    el.style.backgroundColor = "#f7f7f7";
    el.style.padding = "20px";
    el.style.textAlign = "center";
    el.style.position = "absolute";
    el.style.top = "0";
    el.style.width = "100%";
    el.style.height = "100%";
    wrapper.appendChild(el);
    return el;
  }
}
window.initGlobalForm = initGlobalForm;
