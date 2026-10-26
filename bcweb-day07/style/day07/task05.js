document.addEventListener("DOMContentLoaded", () => {
  const canvas = document.querySelector("canvas");
  const audio = document.querySelector("audio");
  const buttons = document.querySelectorAll("footer button");

  audio.src = "https://universal-soundbank.com/sounds/13631.mp3";
  audio.preload = "none";

  const ctx = canvas.getContext("2d");

  ctx.strokeStyle = "white";
  ctx.lineWidth = 1;

  ctx.beginPath();
  ctx.moveTo(6, 6);
  ctx.lineTo(14, 10);
  ctx.lineTo(6, 14);
  ctx.closePath();
  ctx.stroke();

  canvas.style.cursor = "pointer";
  canvas.setAttribute("role", "button");
  canvas.setAttribute("aria-label", "Play audio");

  canvas.addEventListener("click", () => {
    audio.play().catch((error) => {
      console.error("Could not play audio:", error);
    });
  });

  buttons[0].addEventListener("click", () => {
    audio.pause();
  });

  buttons[1].addEventListener("click", () => {
    audio.pause();
    audio.currentTime = 0;
  });
});