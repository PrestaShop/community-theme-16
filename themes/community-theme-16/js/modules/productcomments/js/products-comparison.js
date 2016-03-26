$(function() {
  $('input.star').rating();
  $('.auto-submit-star').rating();
  $('a.cluetip').cluetip({
    local: true,
    cursor: 'pointer',
    cluetipClass: 'comparison_comments',
    dropShadow: false,
    dropShadowSteps: 0,
    showTitle: false,
    tracking: true,
    sticky: false,
    mouseOutClose: true,
    width: 450,
    fx: {
      open:       'fadeIn',
      openSpeed:  'fast'
    }
  }).css('opacity', 0.8);

  $('.comparison_infos a').each(function() {
    var id_product_comment = parseInt($(this).data('id-product-comment'));
    if (id_product_comment) {
      $(this).click(function(e) {
        e.preventDefault();
      });
      var htmlContent = $('#comments_' + id_product_comment).html();
      $(this).popover({
        placement: 'bottom', //placement of the popover. also can use top, bottom, left or right
        title: false, //this is the top title bar of the popover. add some basic css
        html: 'true', //needed to show html of course
        content: htmlContent  //this is the content of the html box. add the image here or anything you want really.
      });
    }
  });
});

function closeCommentForm() {
  $('#sendComment').slideUp('fast');
  $('input#addCommentButton').fadeIn('slow');
}
