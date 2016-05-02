$(function() {

  /** @var {{ icon_list_filepath, class_list_filepath, menu_item_types }} module */
  var module = window.cttopmenu;

  var $form            = $('#ct_top_menu_item_form');
  var $rowEntityId     = $form.find('[name="entity_id"]').closest('.form-group');
  var $rowTreeMaxDepth = $form.find('[name="tree_max_depth"]').closest('.form-group');
  var $inputType       = $form.find('[name="type"]');

  $inputType.on('change', function() {
    var type             = $(this).val();
    var showEntityId     = false;
    var showTreeMaxDepth = false;

    if (module['menu_item_types'][type] && module['menu_item_types'][type]['fields']) {
      showEntityId     = !!module['menu_item_types'][type]['fields']['entity_id'];
      showTreeMaxDepth = !!module['menu_item_types'][type]['fields']['tree_max_depth'];
    }

    $rowEntityId.toggle(showEntityId);
    $rowTreeMaxDepth.toggle(showTreeMaxDepth);

  }).trigger('change');

  // Autocomplete for icons
  var iconSuggestEngine = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: module.icon_list_filepath
  });

  // Autocomplete for theme helper classes
  var classSuggestEngine = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: module.class_list_filepath
  });

  $form.find('input[name="icon"]').typeahead({
    highlight: true,
    // hint: false,
    minLength: 1
  }, {
    name : 'icon',
    source: iconSuggestEngine,
    async: true,
    limit: 10
  });

  $form.find('input[name="class"]').typeahead({
    highlight: true,
    // hint: false,
    minLength: 1
  }, {
    name : 'class',
    source: classSuggestEngine,
    async: true,
    limit: 10
  });

});
