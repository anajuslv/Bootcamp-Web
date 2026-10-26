document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll("footer button");
  const bgSelect = document.querySelector("footer select");

  let currentFontSize = 16;

  buttons[0].addEventListener("click", () => {
    currentFontSize += 2;
    document.body.style.fontSize = `${currentFontSize}px`;
  });

  buttons[1].addEventListener("click", () => {
    if (currentFontSize > 6) {
      currentFontSize -= 2;
      document.body.style.fontSize = `${currentFontSize}px`;
    }
  });

  bgSelect.addEventListener("change", () => {
    if (bgSelect.value !== "") {
      document.body.style.backgroundColor = bgSelect.value;
    }
  });
});