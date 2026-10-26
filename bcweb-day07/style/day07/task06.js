document.addEventListener("DOMContentLoaded", () => {
  const boxes = document.querySelectorAll("footer div");
  const container = boxes[0];
  const coordinates = boxes[1];
  const square = container.querySelector("canvas");

  square.width = 20;
  square.height = 20;

  container.style.position = "relative";
  container.style.height = "100px";
  container.style.padding = "0";
  container.style.overflow = "hidden";

  square.style.position = "absolute";
  square.style.left = "0px";
  square.style.top = "0px";
  square.style.margin = "0";
  square.style.width = "20px";
  square.style.height = "20px";
  square.style.cursor = "grab";

  let dragging = false;
  let offsetX = 0;
  let offsetY = 0;

  function updateCoordinates(x, y) {
    coordinates.textContent =
      `New coordinates => {x:${x}, y:${y}}`;
  }

  square.addEventListener("mousedown", (event) => {
    dragging = true;

    const rect = square.getBoundingClientRect();

    offsetX = event.clientX - rect.left;
    offsetY = event.clientY - rect.top;

    square.style.cursor = "grabbing";
  });

  document.addEventListener("mousemove", (event) => {
    if (!dragging) return;

    const rect = container.getBoundingClientRect();

    let x = event.clientX - rect.left - offsetX;
    let y = event.clientY - rect.top - offsetY;

    x = Math.max(0, Math.min(x, rect.width - square.offsetWidth));
    y = Math.max(0, Math.min(y, rect.height - square.offsetHeight));

    square.style.left = `${x}px`;
    square.style.top = `${y}px`;

    updateCoordinates(Math.round(x), Math.round(y));
  });

  document.addEventListener("mouseup", () => {
    dragging = false;
    square.style.cursor = "grab";
  });

  updateCoordinates(0, 0);
});