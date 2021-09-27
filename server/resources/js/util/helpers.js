// Globals

export const wait = (timeout) => new Promise((resolve) => setTimeout(resolve, timeout));

export async function waitForReadystate() {
  if (document.readyState != 'complete') return;

  await new Promise((resolve) => {
    const cb = () => {
      window.requestAnimationFrame(resolve);
      window.removeEventListener('load', cb);
    };

    window.addEventListener('load', cb);
  });
}
