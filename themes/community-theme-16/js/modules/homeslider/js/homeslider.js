$(function() {

  if (!$.prototype.bxSlider) {
    return;
  }

  if ($('#htmlcontent_top').length > 0) {
    $('#homepage-slider').addClass('col-xs-8');
  } else {
    $('#homepage-slider').addClass('col-xs-12');
  }

  $('#homeslider').bxSlider({
    slideWidth: window.homeslider_width || 750,
    pager: true,
    pagerSelector: '#homeslider-pages',
    autoHover: true,
    randomStart: true,
    auto: typeof window.homeslider_loop != 'undefined' ? !!window.homeslider_loop : true,
    speed: window.homeslider_speed || 500,
    pause: window.homeslider_pause || 3500
  });

  $('.homeslider-wrapper').on('click', function() {
    window.location.href = $(this).prev('a').prop('href');
  });

});
