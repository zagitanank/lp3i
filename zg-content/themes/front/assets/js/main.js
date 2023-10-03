/*$(document).ready(function () {
    $('#example').DataTable();
});
*/

var swiper = new Swiper('.kategori', {
    // init: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        '@0.00': {
            slidesPerView: 1,
            spaceBetween: 10,
        }
    },
});

var swiper = new Swiper('.kategori1', {
    // init: false,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        '@0.00': {
            slidesPerView: 1,
            spaceBetween: 30,
        },
        '@.90': {
            slidesPerView: 2,
            spaceBetween: 50,
        },
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

});