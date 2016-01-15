$(document).ready(function() {

  if (typeof(homeslider_speed) == 'undefined')
    homeslider_speed = 500;
  if (typeof(homeslider_pause) == 'undefined')
    homeslider_pause = 3000;
  if (typeof(homeslider_loop) == 'undefined')
    homeslider_loop = true;
  if (typeof(homeslider_width) == 'undefined')
    homeslider_width = 779;

  $('.homeslider-description').click(function() {
    window.location.href = $(this).prev('a').prop('href');
  });

  if ($('#htmlcontent_top').length > 0)
    $('#homepage-slider').addClass('col-xs-8');
  else
    $('#homepage-slider').addClass('col-xs-12');

  if (!!$.prototype.bxSlider)
    $('#homeslider').bxSlider({
      useCSS: false,
      maxSlides: 1,
      slideWidth: homeslider_width,
      infiniteLoop: homeslider_loop,
      hideControlOnEnd: true,
      pager: false,
      autoHover: true,
      auto: homeslider_loop,
      speed: parseInt(homeslider_speed),
      pause: homeslider_pause,
      controls: true
    });
});
