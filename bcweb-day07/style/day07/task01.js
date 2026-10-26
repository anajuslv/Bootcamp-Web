document.addEventListener("DOMContentLoaded", () => {
  const whiteBox = document.querySelector("#my_box"); // Ajuste o seletor conforme o HTML fornecido
  let clicks = 0;

  if (whiteBox) {
    whiteBox.addEventListener("click", () => {
      clicks++;
      whiteBox.textContent = `Cliques: ${clicks}`;
    });
  }
});