import Swiper, { Navigation, Autoplay } from 'swiper';
// import Swiper and modules styles
import 'swiper/scss';
import 'swiper/scss/navigation';

const swiperElement = document.querySelector('.swiper');

if (swiperElement) {
    const swiper = new Swiper(swiperElement, {
        // configure Swiper to use modules
        modules: [Navigation, Autoplay],
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        loop: true,
        grabCursor: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

    });
}