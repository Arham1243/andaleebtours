/* top progress bar  */
const progressBar = document.getElementById("page-progress");
window.addEventListener("beforeunload", () => {
  progressBar.style.width = "40%";

  setTimeout(() => {
    progressBar.style.width = "70%";
  }, 150);

  setTimeout(() => {
    progressBar.style.width = "100%";
  }, 300);
});

window.addEventListener("load", () => {
  progressBar.style.width = "0";
});
/* top progress bar  */

$(document).ready(function () {
  /* travel stories slider */
  $(".ts-main-slider").slick({
    dots: false,
    infinite: false,
    speed: 600,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: false,
    autoplaySpeed: 4000,
    fade: true,
    cssEase: "linear",
  });
  /* travel stories slider */

  /* activity slider  */
  $(".activity-slider").slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow: $(".activity-prev-slide"),
    nextArrow: $(".activity-next-slide"),
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });
  /* activity slider  */


    /* travel stories slider */
  $(".banner-slider").slick({
    dots: false,
    infinite: true,
    speed: 600,
    centerMode: true,
    centerPadding: '60px',
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: false,
    autoplaySpeed: 4000,
  });
  /* travel stories slider */
});
