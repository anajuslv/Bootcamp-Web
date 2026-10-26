document.addEventListener("DOMContentLoaded", () => {
  const inputItem = document.querySelector("#listItem");
  const button = inputItem
    ? inputItem.nextElementSibling
    : document.querySelector("button");

  if (inputItem && button) {
    button.addEventListener("click", () => {
      const value = inputItem.value.trim();

      if (value !== "") {
        const newDiv = document.createElement("div");
        newDiv.textContent = value;

        // Inserir após o campo de entrada
        inputItem.parentNode.insertBefore(
          newDiv,
          inputItem.nextSibling
        );

        // Limpar o campo
        inputItem.value = "";
      }
    });
  }
});