document.addEventListener("DOMContentLoaded", () => {
  const footer = document.querySelector("footer");
  const firstBox = footer.querySelector("div");
  const cookieLink = firstBox.querySelector("a");

  function getCookie(name) {
    const cookies = document.cookie.split("; ");

    for (const cookie of cookies) {
      const [key, ...value] = cookie.split("=");

      if (key === name) {
        return value.join("=");
      }
    }

    return null;
  }

  function deleteCookie() {
    document.cookie =
      "acceptsCookies=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
  }

  function showSecondBox() {
    if (footer.querySelector("#second_box")) return;

    const secondBox = document.createElement("div");
    secondBox.id = "second_box";

    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete the cookie";

    deleteButton.addEventListener("click", () => {
      deleteCookie();
      secondBox.remove();
      firstBox.style.display = "";
    });

    secondBox.appendChild(deleteButton);
    footer.appendChild(secondBox);
  }

  function checkCookie() {
    if (getCookie("acceptsCookies") === "true") {
      firstBox.style.display = "none";
      showSecondBox();
    } else {
      firstBox.style.display = "";
    }
  }

  cookieLink.addEventListener("click", (event) => {
    event.preventDefault();

    const date = new Date();
    date.setTime(date.getTime() + 24 * 60 * 60 * 1000);

    document.cookie =
      `acceptsCookies=true; expires=${date.toUTCString()}; path=/`;

    checkCookie();
  });

  checkCookie();
});