document.addEventListener("DOMContentLoaded", () => {
  const firstButton = document.querySelector("button");

  if (firstButton) {
    firstButton.addEventListener("click", () => {
      const paragraphs = document.querySelectorAll("p");

      paragraphs.forEach((paragraph) => {
        paragraph.style.display = "none";
      });
    });
  }
});