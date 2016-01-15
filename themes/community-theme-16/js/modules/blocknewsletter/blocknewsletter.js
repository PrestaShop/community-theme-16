$(document).ready(function() {

  $('#newsletter-input').on({
    focus: function() {
      if ($(this).val() == placeholder_blocknewsletter || $(this).val() == msg_newsl)
        $(this).val('');
    },
    blur: function() {
      if ($(this).val() == '')
        $(this).val(placeholder_blocknewsletter);
    }
  });

  var cssClass = 'alert alert-danger';
  if (typeof nw_error != 'undefined' && !nw_error)
    cssClass = 'alert alert-success';

  if (typeof msg_newsl != 'undefined' && msg_newsl) {
    $('#columns').prepend('<div class="clearfix"></div><p class="' + cssClass + '"> ' + alert_blocknewsletter + '</p>');
    $('html, body').animate({scrollTop: $('#columns').offset().top}, 'slow');
  }
});
