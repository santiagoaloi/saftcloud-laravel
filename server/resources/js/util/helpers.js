// Globals
import { IN_BROWSER, IS_PROD } from "@/util/globals";

export const wait = (timeout) => {
  return new Promise((resolve) => setTimeout(resolve, timeout));
};

export async function waitForReadystate() {
  if (IN_BROWSER && IS_PROD && document.readyState !== "complete") {
    await new Promise((resolve) => {
      const cb = () => {
        window.requestAnimationFrame(resolve);
        window.removeEventListener("load", cb);
      };

      window.addEventListener("load", cb);
    });
  }
}
