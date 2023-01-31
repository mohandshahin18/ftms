

$(document).ready(function () {
    //Owl
    $('.hero-slider').owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        navText: ['PREV', 'NEXT'],
        smartSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 7000,
        responsive: {
            0: {
                nav: false,
            },
            768: {
                nav: true,
            }
        }
    })

    $('#projects-slider').owlCarousel({
        loop: true,
        nav: false,
        items: 2,
        dots: true,
        smartSpeed: 600,
        center: true,
        autoplay: true,
        autoplayTimeout: 4000,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2,
                margin: 8,
            }
        }
    })

    $('.reviews-slider').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        smartSpeed: 900,
        items: 1,
        margin: 24,
        autoplay: true,
        autoplayTimeout: 4000,
    })
});


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



$(document).ready(function(){


    var headerProfileAvatar = document.getElementById("avatarWrapper")
    var headerProfileDropdownArrow = document.getElementById("dropdownWrapperArrow");
    var headerProfileDropdown = document.getElementById("dropdownWrapper");

    document.addEventListener("click", function(event) {
    var headerProfileDropdownClickedWithin = headerProfileDropdown.contains(event.target);

      if (!headerProfileDropdownClickedWithin) {
        if (headerProfileDropdown.classList.contains("active")) {
          headerProfileDropdown.classList.remove("active");
          headerProfileDropdownArrow.classList.remove("active");
        }
      }
    });

    headerProfileAvatar.addEventListener("click", function(event) {
      headerProfileDropdown.classList.toggle("active");
      headerProfileDropdownArrow.classList.toggle("active");
      event.stopPropagation();
    });




    });



