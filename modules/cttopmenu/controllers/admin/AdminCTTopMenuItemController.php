<?php

/**
 * Class AdminCTTopMenuItemController
 *
 * @property CTTopMenu     $module
 * @property CTTopMenuItem $object
 */
class AdminCTTopMenuItemController extends ModuleAdminController
{
    /** @var array */
    protected $menuItemTypes;

    /**
     * AdminCTTopMenuItemController constructor.
     */
    public function __construct()
    {
        Shop::addTableAssociation('ct_top_menu_item', array('type' => 'shop'));

        parent::__construct();

        $this->className  = 'CTTopMenuItem';
        $this->table      = 'ct_top_menu_item';
        $this->identifier = 'id_ct_top_menu_item';
        $this->position_identifier = 'id_ct_top_menu_item';
        $this->lang = true;
        $this->bootstrap = true;
        $this->_defaultOrderBy  = 'id_ct_top_menu_item';
        $this->_defaultOrderWay = 'asc';

        $this->menuItemTypes = array(
            CTTopMenuItem::TYPE_CUSTOM_LINK => array(
                'name' => $this->l('Custom Link'),
            ),
            CTTopMenuItem::TYPE_PRODUCT => array(
                'name' => $this->l('Product Link'),
                'entity_name' => $this->l('Product'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CATEGORY => array(
                'name' => $this->l('Category Link'),
                'entity_name' => $this->l('Category'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CATEGORY_TREE => array(
                'name' => $this->l('Category Tree'),
                'entity_name' => $this->l('Category'),
                'fields' => array(
                    'entity_id' => true,
                    'tree_max_depth' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CATEGORY_FLAT_TREE => array(
                'name' => $this->l('Category Flat Tree'),
                'entity_name' => $this->l('Category'),
                'fields' => array(
                    'entity_id' => true,
                    'tree_max_depth' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CMS => array(
                'name' => $this->l('CMS Link'),
                'entity_name' => $this->l('CMS'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CMS_CATEGORY => array(
                'name' => $this->l('CMS Category Link'),
                'entity_name' => $this->l('CMS Category'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_CMS_CATEGORY_TREE => array(
                'name' => $this->l('CMS Category Tree'),
                'entity_name' => $this->l('CMS Category'),
                'fields' => array(
                    'entity_id' => true,
                    'tree_max_depth' => true,
                ),
            ),
            CTTopMenuItem::TYPE_MANUFACTURER => array(
                'name' => $this->l('Manufacturer Link'),
                'entity_name' => $this->l('Manufacturer'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_MANUFACTURER_LIST => array(
                'name' => $this->l('Manufacturer List'),
            ),
            CTTopMenuItem::TYPE_SUPPLIER => array(
                'name' => $this->l('Supplier Link'),
                'entity_name' => $this->l('Supplier'),
                'fields' => array(
                    'entity_id' => true,
                ),
            ),
            CTTopMenuItem::TYPE_SUPPLIER_LIST => array(
                'name' => $this->l('Supplier list'),
            ),
        );

        // Write ID column so we can use this array as option list in fields form
        foreach ($this->menuItemTypes as $menuItemTypeKey => &$menuItemType) {
            $menuItemType['id'] = $menuItemTypeKey;
        }
    }

    /**
     * @TODO Cannot move this in the constructor, list add button becomes save button :( ??
     */
    protected function initOptionFields()
    {
        $this->fields_options = array(
            'general' => array(
                'title' =>    $this->l('Top menu options'),
                'fields' =>    array(
                    'CT_TOP_MENU_SEARCH' => array(
                        'title' => $this->l('Show search form in menu'),
                        'desc' => $this->l('Puts a search input form in the menu.'),
                        'cast' => 'intval',
                        'type' => 'bool'
                    ),
                    'CT_TOP_MENU_ITEM_HOVER' => array(
                        'title' => $this->l('Open menu item dropdown on mouse hover'),
                        'desc' => $this->l('If you disable this, customers will have to click the menu item for the dropdown menu to appear.'),
                        'cast' => 'intval',
                        'type' => 'bool'
                    )
                ),
                'submit' => array('title' => $this->l('Save'))
            ),
        );
    }

    /**
     * Renders options panel
     *
     * @return string
     */
    public function renderOptions()
    {
        if (empty($this->fields_options)) {
            $this->initOptionFields();
        }

        return parent::renderOptions();
    }

    /**
     * Adds no_follow toggle action to process routing
     */
    public function initProcess()
    {
        parent::initProcess();

        // @TODO Refactor 'if' statement to match other controllers, the way they add extra actions
        if (empty($this->action) && Tools::getValue($this->identifier)) {
            if (Tools::getIsset('no_follow'.$this->table) || Tools::getIsset('no_follow')) {
                if ($this->tabAccess['edit'] === '1') {
                    $this->action = 'no_follow';
                } else {
                    $this->errors[] = Tools::displayError('You do not have permission to edit this.');
                }
            }
        }
    }

    /**
     * Clears menu cache on updating menu options
     *
     * @throws PrestaShopException
     */
    protected function processUpdateOptions()
    {
        if (empty($this->fields_options)) {
            $this->initOptionFields();
        }

        parent::processUpdateOptions();
        Hook::exec('actionCTTopMenuCompositionChanged');
    }

    /**
     * Fetches the object list to be displayed by renderList
     * This overrides formats ID fields to be more user friendly.
     *
     * @param int         $id_lang
     * @param string|null $order_by
     * @param string|null $order_way
     * @param int         $start
     * @param int|null    $limit
     * @param int|bool    $id_lang_shop
     * @throws PrestaShopException
     */
    public function getList(
        $id_lang,
        $order_by = null,
        $order_way = null,
        $start = 0,
        $limit = null,
        $id_lang_shop = false
    ) {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);

        foreach ($this->_list as &$menuItem) {
            $type = $menuItem['type'];

            // Rewrite item type "2" as "[2] Product Link"
            $menuItem['type'] = '['.$type.'] '.$this->menuItemTypes[$type]['name'];

            // Rewrite entity ID "2" as "[2] Product"
            if (!empty($this->menuItemTypes[$type]['entity_name'])) {
                $menuItem['entity_id'] = '['.$menuItem['entity_id'].'] '.$this->menuItemTypes[$type]['entity_name'];
            }
        }
    }

    /**
     * Renders a list of menu item objects.
     * Position column is only visible in the shop context
     *
     * @return false|string
     */
    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->bulk_actions = array(
            'delete' => array(
                'text'    => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
            ),
        );

        $this->fields_list = array(
            'id_ct_top_menu_item' => array('title' => $this->l('Item ID'),),
            'type'      => array('title' => $this->l('Item Type'),),
            'entity_id' => array('title' => $this->l('Entity ID'),),
            'icon'      => array('title' => $this->l('Icon'),),
            'class'     => array('title' => $this->l('CSS Class'),),
            'name'      => array('title' => $this->l('Custom Name'),),
            'title'     => array('title' => $this->l('Custom Title'),),
            'url'       => array('title' => $this->l('Custom URL'),),
            'no_follow' => array(
                'title'   => $this->l('No Follow'),
                'align'   => 'center',
                'active'  => 'no_follow',
                'type'    => 'bool',
                'class'   => 'fixed-width-sm',
                'orderby' => false,
            ),
            'active' => array(
                'title'   => $this->l('Active'),
                'align'   => 'center',
                'active'  => 'status',
                'type'    => 'bool',
                'class'   => 'fixed-width-sm',
                'orderby' => false,
            ),
        );

        if (Shop::getContext() != Shop::CONTEXT_ALL && Shop::getContext() != Shop::CONTEXT_GROUP) {
            $id_shop = Shop::getContextShopID();

            $this->_defaultOrderBy  = 'position';
            $this->_select = 'shop.position as position';

            $this->_join = 'LEFT JOIN '._DB_PREFIX_.'ct_top_menu_item_shop shop
             ON a.id_ct_top_menu_item = shop.id_ct_top_menu_item AND shop.id_shop = '.(int)$id_shop;

            $this->fields_list['position'] = array(
                'title' => $this->l('Position'),
                'filter_key' => 'shop!position',
                'align' => 'center',
                'class' => 'fixed-width-sm',
                'position' => 'position'
            );

            $this->informations[] = $this->l('If you would like to order menu items, sort the list by position.');
        } else {
            $this->informations[] = $this->l('If you would like to order menu items, select shop context.');
        }

        return parent::renderList();
    }

    /**
     * Renders menu item add/edit form
     *
     * @return string
     */
    public function renderForm()
    {
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Edit/Add page top menu item'),
            ),
            'input' => array(
                array(
                    'name'  => 'type',
                    'type'  => 'select',
                    'label' => $this->l('Item type'),
                    'desc'  => $this->l('Select menu item type. This can be a link to an page (object) in PrestaShop, a tree of objects (categories), lists (manufacturers, suppliers), or custom links.'),
                    'cast'  => 'strval',
                    'default_value' => CTTopMenuItem::TYPE_CUSTOM_LINK,
                    'options' => array(
                        'id'   => 'id',
                        'name' => 'name',
                        'query' => $this->menuItemTypes,
                    )
                ),
                array(
                    'name'  => 'entity_id',
                    'type'  => 'text',
                    'label' => $this->l('Entity ID'),
                    'desc'  => $this->l('Enter the ID of the selected item (object) type. For example, enter product ID or category ID.'),
                    'hint'  => $this->l('Must be an integer greater than 0 and must exists in the shop.'),
                ),
                array(
                    'name'  => 'tree_max_depth',
                    'type'  => 'text',
                    'label' => $this->l('Tree Max Depth'),
                    'desc'  => $this->l('For category trees, enter maximum depth of that tree. For example, you may want to display only level 2 categories in the drop down menu.'),
                    'cast'  => 'intval',
                    'hint'  => $this->l('Enter 0 for no limit.'),
                ),
                array(
                    'name'  => 'name',
                    'type'  => 'text',
                    'lang'  => true,
                    'label' => $this->l('Name'),
                    'desc'  => $this->l('Enter the menu item name for your custom link or override the link name of PrestaShop objects which are objects names.'),
                    'cast'  => 'strval',
                ),
                array(
                    'name'  => 'url',
                    'type'  => 'text',
                    'lang'  => true,
                    'label' => $this->l('URL'),
                    'desc'  => $this->l('Enter a URL for your custom link or override the menu item URL of PrestaShop object menu item.'),
                    'cast'  => 'strval',
                    'hint'  => $this->l('Can be either absolute or relative URL.'),
                ),
                array(
                    'name'  => 'title',
                    'type'  => 'text',
                    'lang'  => true,
                    'label' => $this->l('Hover Title'),
                    'desc'  => $this->l('Will be displayed on mouse hover over the menu item.'),
                    'cast'  => 'strval',
                ),
                array(
                    'name'  => 'icon',
                    'type'  => 'text',
                    'label' => $this->l('Icon'),
                    'desc'  => sprintf(
                        $this->l('You may use icons together with the menu item name. Refer to %s for font icon codes.'),
                        '<a href="https://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome</a>'
                    ),
                    'cast'  => 'strval',
                    'hint'  => $this->l('Do not enter the fa- or icon- part of the class name.'),
                ),
                array(
                    'name'  => 'class',
                    'type'  => 'text',
                    'label' => $this->l('CSS Class'),
                    'desc'  => $this->l('You may add some extra CSS classes to this menu item to give it exclusive styling.'),
                    'cast'  => 'strval',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('No Follow'),
                    'name' => 'no_follow',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array('id' => 'no_follow_on', 'value' => 1, 'label' => $this->l('Yes')),
                        array('id' => 'no_follow_off', 'value' => 0, 'label' => $this->l('No'))
                    ),
                    'desc' => $this->l('If enabled, the menu item link will have rel="nofollow" attribute.')
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'class' => 't',
                    'is_bool' => true,
                    'values' => array(
                        array('id' => 'active_on', 'value' => 1, 'label' => $this->l('Yes')),
                        array('id' => 'active_off', 'value' => 0, 'label' => $this->l('No'))
                    ),
                    'desc' => $this->l('If disabled, menu item will not be displayed.')
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
            ),
        );

        $this->addCSS($this->module->getLocalPath().'views/css/vendor/typeaheadjs.css');
        $this->addJS($this->module->getLocalPath().'views/js/vendor/typeahead.bundle.min.js');
        $this->addJS($this->module->getLocalPath().'views/js/bo.js');

        $iconListFilePath = _MODULE_DIR_.$this->module->name.'/views/json/icons.json';
        if (file_exists(_PS_THEME_DIR_.'modules/'.$this->module->name.'/views/json/icons.json')) {
            $iconListFilePath = _THEME_DIR_.'modules/'.$this->module->name.'/views/json/icons.json';
        }

        $classListFilePath = _MODULE_DIR_.$this->module->name.'/views/json/classes.json';
        if (file_exists(_PS_THEME_DIR_.'modules/'.$this->module->name.'/views/json/classes.json')) {
            $classListFilePath = _THEME_DIR_.'modules/'.$this->module->name.'/views/json/classes.json';
        }

        Media::addJsDef(array(
            'cttopmenu' => array(
                'icon_list_filepath' => $iconListFilePath,
                'class_list_filepath' => $classListFilePath,
                'menu_item_types' => $this->menuItemTypes,
            ),
        ));

        // @TODO Always show?
        if (Shop::isFeatureActive()) {
            $this->fields_form['input'][] = array(
                'type' => 'shop',
                'label' => $this->l('Shop association'),
                'name' => 'checkBoxShopAsso',
            );
        }

        return parent::renderForm();
    }

    /**
     * Processes toggling no_follow values through admin list
     *
     * @throws PrestaShopException
     */
    public function processNoFollow()
    {
        /** @var CTTopMenuItem $topMenuItem */
        $topMenuItem = $this->loadObject();

        if (!Validate::isLoadedObject($topMenuItem)) {
            $this->errors[] = Tools::displayError('An error occurred while updating menu item information.');
        }

        $topMenuItem->no_follow = !$topMenuItem->no_follow;

        if (!$topMenuItem->update()) {
            $this->errors[] = Tools::displayError('An error occurred while updating menu item information.');
        }

        Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }

    /**
     * Updates positions submitted via Ajax
     */
    public function ajaxProcessUpdatePositions()
    {
        $id_shop = Shop::getContextShopID();

        // Build an array of order IDs (could be a page!)
        $submittedIds = array();
        $rows = (array)Tools::getValue($this->table);
        foreach ($rows as $row) {
            $ids = explode('_', $row);
            $submittedIds[] = (int)$ids[2];
        }

        // Get all IDs from database
        $sql = new DbQuery();
        $sql->select('id_ct_top_menu_item');
        $sql->from('ct_top_menu_item_shop');
        $sql->where('id_shop = '.(int)$id_shop);
        $sql->orderBy('position ASC');
        $rows = (array)Db::getInstance()->executeS($sql);

        $allIds = array();
        foreach ($rows as $row) {
            $allIds[] = (int)$row['id_ct_top_menu_item'];
        }

        // Go through all IDs, if the ID exists in the sorted ID list (could be fragment (page) or sorted IDs)
        // then pick an ID from sorted ID list and overwrite the value.
        $i = 0;
        foreach ($allIds as $key1 => $id) {
            $key2 = array_search($id, $submittedIds);
            if ($key2 !== false) {
                $allIds[$key1] = $submittedIds[$i++];
            }
        }

        // Update positions of all values the way the are ordered in the array
        $position  = 0;
        $isSuccess = true;
        $shopIDs   = Shop::getContextListShopID();
        foreach ($allIds as $id_ct_top_menu_item) {
            $isSuccess &= Db::getInstance()->update(
                $this->table.'_shop',
                array('position' => $position++,),
                'id_ct_top_menu_item = '.(int)$id_ct_top_menu_item.' AND id_shop IN ('.implode(', ', $shopIDs).')'
            );
            if (!$isSuccess) {
                break;
            }
        }

        Hook::exec('actionCTTopMenuCompositionChanged');

        if ($isSuccess) {
            die(true);
        } else {
            header('Content-Type: application/json');
            die(Tools::jsonEncode(array(
                'hasError' => true,
                'errors'   => $this->l('Could not update positions in the database table.')
            )));
        }
    }
}
