
var swiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    slidesPerView: 3,
    spaceBetween: 60,
    loop: true,
    
    autoplay: {
      delay: 0,
    },

    speed: 3000,

    breakpoints: {
      // when window width is <= 999px
      600: {
          slidesPerView: 6,
          spaceBetweenSlides: 50
      }
    }
    
    });