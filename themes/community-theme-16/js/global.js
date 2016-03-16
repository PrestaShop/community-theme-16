//global variables
var responsiveflag = false;

$(document).ready(function() {
  highdpiInit();
  responsiveResize();
  $(window).resize(responsiveResize);
  if (navigator.userAgent.match(/Android/i)) {
    var viewport = document.querySelector('meta[name="viewport"]');
    viewport.setAttribute('content', 'initial-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,height=device-height');
    window.scrollTo(0, 1);
  }
  if (typeof quickView !== 'undefined' && quickView)
    quick_view();

  if (typeof page_name != 'undefined' && !in_array(page_name, ['index', 'product'])) {
    bindGrid();

    $(document).on('change', '.selectProductSort', function(e) {
      if (typeof request != 'undefined' && request)
        var requestSortProducts = request;
      var splitData = $(this).val().split(':');
      var url = '';
      if (typeof requestSortProducts != 'undefined' && requestSortProducts) {
        url += requestSortProducts ;
        if (typeof splitData[0] !== 'undefined' && splitData[0]) {
          url += (requestSortProducts.indexOf('?') < 0 ? '?' : '&') + 'orderby=' + splitData[0] + (splitData[1] ? '&orderway=' + splitData[1] : '');
          if (typeof splitData[1] !== 'undefined' && splitData[1])
            url += '&orderway=' + splitData[1];
        }
        document.location.href = url;
      }
    });

    $(document).on('change', 'select[name="n"]', function() {
      $(this.form).submit();
    });

    $(document).on('change', 'select[name="currency_payment"]', function() {
      setCurrency($(this).val());
    });
  }

  $(document).on('change', 'select[name="manufacturer_list"], select[name="supplier_list"]', function() {
    if (this.value != '')
      location.href = this.value;
  });

  $(document).on('click', '.back', function(e) {
    e.preventDefault();
    history.back();
  });

  jQuery.curCSS = jQuery.css;
  if (!!$.prototype.cluetip)
    $('a.cluetip').cluetip({
      local: true,
      cursor: 'pointer',
      dropShadow: false,
      dropShadowSteps: 0,
      showTitle: false,
      tracking: true,
      sticky: false,
      mouseOutClose: true,
      fx: {
        open:       'fadeIn',
        openSpeed:  'fast'
      }
    }).css('opacity', 0.8);

  if (typeof(FancyboxI18nClose) !== 'undefined' && typeof(FancyboxI18nNext) !== 'undefined' && typeof(FancyboxI18nPrev) !== 'undefined' && !!$.prototype.fancybox)
    $.extend($.fancybox.defaults.tpl, {
      closeBtn: '<a title="' + FancyboxI18nClose + '" class="fancybox-item fancybox-close" href="javascript:;"></a>',
      next: '<a title="' + FancyboxI18nNext + '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
      prev: '<a title="' + FancyboxI18nPrev + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
    });

  // Close Alert messages
  $('.alert.alert-danger').on('click', this, function(e) {
    if (e.offsetX >= 16 && e.offsetX <= 39 && e.offsetY >= 16 && e.offsetY <= 34)
      $(this).fadeOut();
  });
});

function highdpiInit() {
  if (typeof highDPI === 'undefined')
    return;
  if (highDPI && $('.replace-2x').css('font-size') == '1px') {
    var els = $('img.replace-2x').get();
    for (var i = 0; i < els.length; i++) {
      src = els[i].src;
      extension = src.substr((src.lastIndexOf('.') + 1));
      src = src.replace('.' + extension, '2x.' + extension);

      var img = new Image();
      img.src = src;
      img.height != 0 ? els[i].src = src : els[i].src = els[i].src;
    }
  }
}

// Used to compensante Chrome/Safari bug (they don't care about scroll bar for width)
function scrollCompensate() {
  var inner = document.createElement('p');
  inner.style.width = '100%';
  inner.style.height = '200px';

  var outer = document.createElement('div');
  outer.style.position = 'absolute';
  outer.style.top = '0px';
  outer.style.left = '0px';
  outer.style.visibility = 'hidden';
  outer.style.width = '200px';
  outer.style.height = '150px';
  outer.style.overflow = 'hidden';
  outer.appendChild(inner);

  document.body.appendChild(outer);
  var w1 = inner.offsetWidth;
  outer.style.overflow = 'scroll';
  var w2 = inner.offsetWidth;
  if (w1 == w2) w2 = outer.clientWidth;

  document.body.removeChild(outer);

  return (w1 - w2);
}

function responsiveResize() {
  compensante = scrollCompensate();
  if (($(window).width() + scrollCompensate()) <= 767 && responsiveflag == false) {
    responsiveflag = true;
  } else if (($(window).width() + scrollCompensate()) >= 768) {
    responsiveflag = false;
  }
}

function quick_view() {
  $(document).on('click', '.quick-view', function(e) {
    e.preventDefault();
    var url = this.rel;
    var anchor = '';

    if (url.indexOf('#') != -1) {
      anchor = url.substring(url.indexOf('#'), url.length);
      url = url.substring(0, url.indexOf('#'));
    }

    if (url.indexOf('?') != -1)
      url += '&';
    else
      url += '?';

    if (!!$.prototype.fancybox)
      $.fancybox({
        'padding':  0,
        'width':    1087,
        'height':   610,
        'type':     'iframe',
        'href':     url + 'content_only=1' + anchor
      });
  });
}

function bindGrid() {
  var storage = false;
  if (typeof(getStorageAvailable) !== 'undefined') {
    storage = getStorageAvailable();
  }
  if (!storage) {
    return;
  }

  var view = $.totalStorage('display');
  display(view);

  $(document).on('click', '#grid', function(e) {
    e.preventDefault();
    display('grid');
  });

  $(document).on('click', '#list', function(e) {
    e.preventDefault();
    display('list');
  });
}

function display(layoutType) {
  var grid = layoutType == 'grid';
  $('.product_list').toggleClass('grid', grid).toggleClass('list', !grid);
  $('#list').toggleClass('selected active', !grid);
  $('#grid').toggleClass('selected active', grid);
  $.totalStorage('display', grid ? 'grid' : 'list');
}
