document.addEventListener("DOMContentLoaded", () => {
  const whiteBox = document.querySelector("#my_box");

  if (whiteBox) {
    whiteBox.addEventListener("click", () => {
      let name = "";
      
      // Continua perguntando enquanto o nome estiver vazio ou nulo
      while (!name || name.trim() === "") {
        name = prompt("What's your name?");
      }

      const confirmed = confirm("Are you sure that name is your name?");
      
      if (confirmed) {
        const greeting = `Hello ${name}!`;
        alert(greeting);
        whiteBox.textContent = greeting;
      }
    });
  }
});