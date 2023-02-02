
let counters = document.querySelectorAll(".row .col-lg-2 .display-4");
let container = document.querySelector("#milestone");
let started = false;

window.onscroll = function () {
  if (window.scrollY >= container.offsetTop -600) {
    if (!started) {
      counters.forEach((num) => startCount(num));
    }
    started = true;
  }
};

function startCount(el) {
  let goal = el.dataset.goal;
  let count = setInterval(() => {
    el.textContent++;
    if (el.textContent == goal) {
      clearInterval(count);
    }
  }, 5000 / goal);
}







