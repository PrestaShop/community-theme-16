$(function() {

  var $menu    = $('#cttopmenu');
  var $search  = $('#search_query_cttopmenu');
  var useHover = $menu.hasClass('js-use-hover');
  var menuIsCollapsed;

  // Enables clicking inside the dropdown without closing the the drodpown (blur event)
  $(document).on('click', '.yamm .dropdown-menu', function(e) {
    e.stopPropagation();
  });

  var buffer = null;
  var $navbarHeader = $menu.find('.navbar-header');

  // Initial detection of collapse top menu
  detectCollapsedMenu();

  // Detect collapsed menu every 250ms using debounce
  $(window).on('resize', function() {
    clearTimeout(buffer);
    buffer = setTimeout(detectCollapsedMenu, 250);
  });

  // Write the search_query with JS so we don't have to cache block for evey search
  if ($search.length) {
    var search_query = window.location.search.match(/[\?&]search_query=([^&#]*)/);
    if (search_query) {
      $search.val(search_query[1]);
    }
  }

  // Mark active links with JS
  var $links = $menu.find('.cttm-link');
  $links.each(function() {
    if ($(this).prop('href') == window.location.href) {
      $(this).parent().addClass('active');
    }
  });

  // Option: show dropdowns on mouse enter
  // @TODO This functionality is experimental and may contain bugs. Bootstrap does not support hover dropdowns.
  if (useHover) {
    bindOnHoverMenu();
  }

  // Binds all the necessary events handlers for the menu dropdowns to work with hover events
  function bindOnHoverMenu() {
    var $linksToggle = $links.filter('.dropdown-toggle');
    var $dropdowns   = $menu.find('.dropdown');

    // On hover over dropdown links, we must open them, unless in mobile (collapsed view)
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

    // On leaving any links, make sure the dropdown (if any) is closed
    $dropdowns.on('mouseleave', function() {
      !menuIsCollapsed && $(this).removeClass('open');
    });

    // Make sure that clicking a dropdown link opens that link instead of toggling the dropdown
    $linksToggle.on('click', function(e) {
      if (menuIsCollapsed) {
        return;
      }

      // Prevent Bootstrap event handler, which closes the dropdown.
      // Default browser handler will fire (link will be opened)
      e.stopImmediatePropagation();
    });
  }

  function detectCollapsedMenu() {
    var collapsed = $navbarHeader.is(':visible');
    $menu.toggleClass('is-collapsed', collapsed);
    menuIsCollapsed = collapsed;
  }

});
