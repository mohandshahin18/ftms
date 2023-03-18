

$(document).ready(function () {
    //Owl
    if (lang == 'ar') {
        $('.hero-slider').owlCarousel({
            loop: true,
            margin: 0,
            items: 1,
            rtl: true,
            dots: false,
            navText: [next, prev],
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 15000,
            responsive: {
                0: {
                    nav: false,
                },
                768: {
                    nav: true,
                }
            }
        })
    } else {
        $('.hero-slider').owlCarousel({
            loop: false,
            margin: 0,
            items: 1,
            dots: false,
            navText: [prev, next],
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 15000,
            responsive: {
                0: {
                    nav: false,
                },
                768: {
                    nav: true,
                }
            }
        })
    }



});
