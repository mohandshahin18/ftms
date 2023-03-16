

$(document).ready(function () {
    //Owl
    if (lang == 'ar') {
        $('.hero-slider').owlCarousel({
            loop: false,
            margin: 0,
            items: 1,
            rtl: true,
            dots: false,
            navText: ['PREV', 'NEXT'],
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 10000,
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
            navText: ['PREV', 'NEXT'],
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 10000,
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
