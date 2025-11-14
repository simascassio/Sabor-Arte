function toggleMenu() {
  const menu = document.getElementById("submenu-usuario");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", (e) => {
  const menu = document.getElementById("submenu-usuario");
  const icone = document.getElementById("usuario-icone");

  if (menu && !menu.contains(e.target) && e.target !== icone) {
    menu.style.display = "none";
  }
});
