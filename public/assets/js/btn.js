const hamburger = document.getElementById("hamburger");
const menu = document.getElementById("menu");

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("open"); //anima o hamburger
  menu.classList.toggle("hidden");   
});
