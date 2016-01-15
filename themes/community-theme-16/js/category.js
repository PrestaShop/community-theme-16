$(document).ready(function() {
  resizeCatimg();
});

$(window).resize(function() {
  resizeCatimg();
});

$(document).on('click', '.lnk_more', function(e) {
  e.preventDefault();
  $('#category_description_short').hide();
  $('#category_description_full').show();
  $(this).hide();
});

function resizeCatimg() {
  var div = $('.content_scene_cat div:first');

  if (div.css('background-image') == 'none')
    return;

  var image = new Image;

  $(image).load(function() {
    var width  = image.width;
    var height = image.height;
    var ratio = parseFloat(height / width);
    var calc = Math.round(ratio * parseInt(div.outerWidth(false)));

    div.css('min-height', calc);
  });
  if (div.length)
    image.src = div.css('background-image').replace(/url\("?|"?\)$/ig, '');
}
