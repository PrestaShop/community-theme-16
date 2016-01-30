$(function() {

  // @TODO Mark active item

  var $menu    = $('#cttopmenu');
  var $search  = $('#search_query_cttopmenu');
  var useHover = $menu.hasClass('js-use-hover');
  var menuIsCollapsed;

  // Enables clicking inside the dropdown without closing the the drodpown (blur event)
  $(document).on('click', '.yamm .dropdown-menu', function(e) {
    console.log('prevent');
    e.stopPropagation();
  });

  // Detect when menu is collapsed
  var buffer = null;
  var $navbarHeader = $menu.find('.navbar-header');

  detectCollapsedMenu();
  $(window).on('resize', function() {
    clearTimeout(buffer);
    buffer = setTimeout(detectCollapsedMenu, 250);
  });

  function detectCollapsedMenu() {
    var collapsed = $navbarHeader.is(':visible');
    $menu.toggleClass('is-collapsed', collapsed);
    menuIsCollapsed = collapsed;
  }

  // Write the search_query with JS so we don't have to cache block for evey search
  if ($search.length) {
    var search_query = window.location.search.match(/[\?&]search_query=([^&#]*)/);
    if (search_query) {
      $search.val(search_query[1]);
    }
  }

  // Option: show dropdowns on mouse enter
  if (useHover) {
    var $links       = $menu.find('.cttm-link');
    var $linksToggle = $links.filter('.dropdown-toggle');
    var $dropdowns   = $menu.find('.dropdown');

    $links.on('mouseenter', function() {

      // In collapsed view, use the default behaviour
      if (menuIsCollapsed) {
        return true;
      }

      var isToggle = $(this).hasClass('dropdown-toggle');
      if (isToggle) {
        // Toggle only if not opened already, toggling between different dropdowns is taken care by Bootstrap
        var opened = $(this).closest('.dropdown').hasClass('open');
        !opened && $(this).dropdown('toggle');
      } else {
        // Menu item is simple link, close all opened menu dropdowns
        $dropdowns.filter('.open').removeClass('open');
      }

    });

    $dropdowns.on('mouseleave', function() {
      !menuIsCollapsed && $(this).removeClass('open');
    });

    // @TODO On click, default behaviour
    $linksToggle.on('click', function() {
      window.location = $(this).attr('href');
    });
  }

});
