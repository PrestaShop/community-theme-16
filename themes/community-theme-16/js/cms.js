$(document).ready(function() {
  if (typeof ad !== 'undefined' && ad && typeof adtoken !== 'undefined' && adtoken) {
    $(document).on('click', 'input[name=publish_button]', function(e) {
      e.preventDefault();
      submitPublishCMS(ad, 0, adtoken);
    });
    $(document).on('click', 'input[name=lnk_view]', function(e) {
      e.preventDefault();
      submitPublishCMS(ad, 1, adtoken);
    });
  }
});

function submitPublishCMS(url, redirect, token) {
  var id_cms = $('#admin-action-cms-id').val();

  $.ajaxSetup({async: false});
  $.post(url + '/index.php', {
      action: 'PublishCMS',
      id_cms: id_cms,
      status: 1,
      redirect: redirect,
      ajax: 1,
      tab: 'AdminCmsContent',
      token: token
    },
    function(data) {
      if (data.indexOf('error') === -1)
        document.location.href = data;
    }
  );
  return true;
}
