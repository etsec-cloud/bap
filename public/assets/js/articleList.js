
var swiper = new Swiper('.swiper-container-article', {
    direction: 'horizontal',
    slidesPerView: 1,
    spaceBetween: 30,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        400: {
            slidesPerView: 2,
            spaceBetweenSlides: 20
        },
        700: {
            slidesPerView: 3,
            spaceBetweenSlides: 30
        },

        1000: {
            slidesPerView: 4,
            spaceBetweenSlides: 40
        },
        1200: {
            slidesPerView: 5,
            spaceBetweenSlides: 60
        }
      }
    });