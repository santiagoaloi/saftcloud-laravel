function now() {
  return Math.trunc(new Date().getTime() / 1000);
}

let lastActivity = now();
let handler;

function setActive(ev) {
  lastActivity = now();
  if (handler) {
    handler(ev);
  }
}

// Call only when the window is 'ready' !!!
function hook(callback) {
  handler = callback;
  window.addEventListener("mousemove", setActive, false);
  window.addEventListener("mousedown", setActive, false);
  window.addEventListener("keypress", setActive, false);
  window.addEventListener("DOMMouseScroll", setActive, false);
  window.addEventListener("mousewheel", setActive, false);
  window.addEventListener("touchmove", setActive, false);
  window.addEventListener("MSPointerMove", setActive, false);
}

function unhook() {
  window.removeEventListener("mousemove", setActive);
  window.removeEventListener("mousedown", setActive);
  window.removeEventListener("keypress", setActive);
  window.removeEventListener("DOMMouseScroll", setActive);
  window.removeEventListener("mousewheel", setActive);
  window.removeEventListener("touchmove", setActive);
  window.removeEventListener("MSPointerMove", setActive);
}

function getIdleSeconds() {
  return now() - lastActivity;
}

function getIdleText(pretty) {
  const seconds = getIdleSeconds();
  if (pretty && seconds >= 50) {
    const minutes = Math.round(seconds / 60);
    return "" + minutes + " minute" + (minutes !== 1 ? "s" : "");
  }
  return "" + seconds + " seconds";
}

export default { hook, unhook, lastActivity, getIdleSeconds, getIdleText };
