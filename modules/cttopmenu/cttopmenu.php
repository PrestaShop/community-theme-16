<?php

require_once('classes/CTTopMenuItem.php');

/**
 * Class CTTopMenu
 *
 * @property $bootstrap
 *
 * @TODO Custom dropdown HTMl for custom_link
 * @TODO Consider adding TYPE_SHOP_LINK and demo data as home button
 */
class CTTopMenu extends Module
{
    /**
     * CTTopMenu constructor.
     */
    public function __construct()
    {
        $this->name    = 'cttopmenu';
        $this->tab     = 'front_office_features';
        $this->version = '1.1.0';
        $this->author  = 'PrestaShop Community';

        parent::__construct();

        $this->displayName = $this->l('Community Theme Top Menu');
        $this->description = $this->l('Adds a new horizontal menu to the top of your e-commerce website.');
        $this->ps_versions_compliancy = array('min' => '1.6.0.3', 'max' => _PS_VERSION_);

        $this->bootstrap = true;

        Shop::addTableAssociation('ct_top_menu_item', array('type' => 'shop'));
    }

    /**
     * Installs module to PrestaShop
     *
     * @return bool
     * @throws PrestaShopException
     */
    public function install()
    {
        $hooks = array(
            'displayHeader',
            'displayTop',
            'displayCtTopMenu',
            'actionCTTopMenuCompositionChanged',
            'actionObjectProductUpdateAfter',
            'actionObjectProductDeleteAfter',
            'actionObjectCategoryUpdateAfter',
            'actionObjectCategoryDeleteAfter',
            'actionObjectCategoryAddAfter',
            'actionObjectCmsUpdateAfter',
            'actionObjectCmsDeleteAfter',
            'actionObjectCmsAddAfter',
            'actionObjectCmsCategoryUpdateAfter',
            'actionObjectCmsCategoryDeleteAfter',
            'actionObjectCmsCategoryAddAfter',
            'actionObjectSupplierUpdateAfter',
            'actionObjectSupplierDeleteAfter',
            'actionObjectSupplierAddAfter',
            'actionObjectManufacturerUpdateAfter',
            'actionObjectManufacturerDeleteAfter',
            'actionObjectManufacturerAddAfter',
        );

        if (!parent::install()) {
            return false;
        }

        foreach ($hooks as $hookName) {
            if (!$this->registerHook($hookName)) {
                return false;
            }
        }

        $sql = str_replace(
            array('{{ db_prefix }}', '{{ mysql_engine }}'),
            array(_DB_PREFIX_, _MYSQL_ENGINE_),
            Tools::file_get_contents(dirname(__FILE__).'/install/up.sql')
        );
        if (!Db::getInstance()->execute($sql)) {
            return false;
        }

        $this->registerAdminController('AdminCTTopMenuItem', 'Top Menu Items', 'AdminPreferences');

        Configuration::updateValue('CT_TOP_MENU_SEARCH', false);
        Configuration::updateValue('CT_TOP_MENU_ITEM_HOVER', false);

        // Demo data
        $menuItem = new CTTopMenuItem();
        $menuItem->type = CTTopMenuItem::TYPE_CUSTOM_LINK;
        $menuItem->icon = 'home';
        $menuItem->url = $this->context->link->getPageLink('index');
        $menuItem->save();

        return true;
    }

    /**
     * Uninstalls module from PrestaShop
     *
     * @return bool
     */
    public function uninstall()
    {
        $sql = str_replace(
            array('{{ db_prefix }}'),
            array(_DB_PREFIX_),
            Tools::file_get_contents(dirname(__FILE__).'/install/down.sql')
        );
        if (!Db::getInstance()->execute($sql)) {
            return false;
        }

        // Deregister admin controller
        $id_tab = (int)Tab::getIdFromClassName('AdminCTTopMenuItem');
        $tab = new Tab($id_tab);
        if (!$tab->delete()) {
            return false;
        }

        Configuration::deleteByName('CT_TOP_MENU_SEARCH');
        Configuration::deleteByName('CT_TOP_MENU_ITEM_HOVER');

        return parent::uninstall();
    }


    /**
     * Registers a module admin controller and install a back-office tab (optional)
     *
     * @param string $class_name - Controller class name without word 'Controller' at the end
     * @param string $tab_title - single string or a language array
     * @param string|int $tab_parent - Parent tab class name or ID
     * @return int|false
     */
    protected function registerAdminController($class_name, $tab_title = '', $tab_parent = -1)
    {
        $title = empty($tab_title) ? $class_name : $tab_title;

        $tab = new Tab();
        $tab->class_name = $class_name;
        $tab->module = $this->name;
        $tab->name = is_array($title) ? $title :  array_fill_keys(Language::getIDs(), $title);

        if (!empty($tab_parent) && is_string($tab_parent)) {
            $tab->id_parent = (int)Tab::getIdFromClassName($tab_parent);
        } elseif (is_int($tab_parent)) {
            $tab->id_parent = $tab_parent;
        } else {
            $tab->id_parent = 0;
        }

        return $tab->add() ? (int)$tab->id : false;
    }

    /**
     * Returns module configuration page content
     *
     * @return string
     */
    public function getContent()
    {
        $toUrl = $this->context->link->getAdminLink('AdminCTTopMenuItem');
        Tools::redirectAdmin($toUrl);
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/fo.css');
        $this->context->controller->addJS($this->_path.'views/js/fo.js');
    }

    /**
     * Returns top menu HTML within specific template
     *
     * @param string $template - name of the smarty template for the menu
     * @return string
     */
    public function renderMenu($template = 'cttopmenu')
    {
        $cacheKey = $this->getCacheId($template.'.tpl');
        if (!$this->isCached($template.'.tpl', $cacheKey)) {
            $id_lang = $this->context->language->id;
            $id_shop = Shop::getContextShopID();

            $this->context->smarty->assign(array(
                'menu_items'       => $this->getMenu($id_lang, $id_shop),
                'use_hover'        => (bool)Configuration::get('CT_TOP_MENU_ITEM_HOVER'),
                'show_search_form' => (bool)Configuration::get('CT_TOP_MENU_SEARCH'),
            ));
        }

        return $this->display(__FILE__, $template.'.tpl', $cacheKey);
    }

    /**
     * Returns top menu HTML to be output at the page top
     *
     * @return string
     */
    public function hookDisplayTop()
    {
        return $this->renderMenu();
    }

    /**
     * Returns top menu HTML to be output wherever you want using {hook h='displayCtTopMenu'}
     *
     * @param array $params - Smarty params array
     * @return string
     */
    public function hookDisplayCtTopMenu(array $params)
    {
        $template = 'cttopmenu';

        if (array_key_exists('custom_tpl', $params)) {
            $template = $params['custom_tpl'];
        }

        return $this->renderMenu($template);
    }

    /**
     * Clears cached top menu
     */
    protected function clearMenuCache()
    {
        $this->_clearCache('*');
    }

    public function hookActionCTTopMenuCompositionChanged()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectProductUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectProductDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCategoryUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCategoryDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCategoryAddAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsAddAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsCategoryUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsCategoryDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectCmsCategoryAddAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectSupplierAddAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerUpdateAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerDeleteAfter()
    {
        $this->clearMenuCache();
    }

    public function hookActionObjectManufacturerAddAfter()
    {
        $this->clearMenuCache();
    }

    /**
     * Builds and returns menu tree, really for templates
     *
     * @param int $id_lang
     * @param int $id_shop
     *
     * @return array
     */
    public function getMenu($id_lang, $id_shop)
    {
        $menu = array();
        $menuItems = CTTopMenuItem::getMenuItems($id_lang, $id_shop);

        foreach ($menuItems as $menuItem) {
            if ($menuItem['active']) {
                $compiledMenuItem = $this->buildMenuItem($menuItem, $id_shop, $id_lang);
                if (!empty($compiledMenuItem)) {
                    $menu[] = $compiledMenuItem;
                }
            }
        }

        return $menu;
    }

    /**
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     * @return array
     */
    public function buildMenuItem(array $menuItem, $id_shop, $id_lang)
    {
        switch ($menuItem['type']) {
            case CTTopMenuItem::TYPE_CUSTOM_LINK:
                return $this->buildCustomLink($menuItem);
            case CTTopMenuItem::TYPE_PRODUCT:
                return $this->buildProductLink($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CATEGORY:
                return $this->buildCategoryLink($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CATEGORY_TREE:
                return $this->buildCategoryTree($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CATEGORY_FLAT_TREE:
                return $this->buildCategoryFlatTree($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CMS:
                return $this->buildCmsLink($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CMS_CATEGORY:
                return $this->buildCmsCategoryLink($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_CMS_CATEGORY_TREE:
                return $this->buildCmsCategoryTree($menuItem, $id_shop, $id_lang);
            case CTTopMenuItem::TYPE_MANUFACTURER:
                return $this->buildManufacturerLink($menuItem, $id_lang);
            case CTTopMenuItem::TYPE_MANUFACTURER_LIST:
                return $this->buildManufacturerList($menuItem, $id_lang);
            case CTTopMenuItem::TYPE_SUPPLIER:
                return $this->buildSupplierLink($menuItem, $id_lang);
            case CTTopMenuItem::TYPE_SUPPLIER_LIST:
                return $this->buildSupplierList($menuItem, $id_lang);
        }

        // Unknown type :(
        return array();
    }

    /**
     * Builds custom link menu item
     *
     * @param array $menuItem
     *
     * @return array
     */
    protected function buildCustomLink(array $menuItem)
    {
        return array(
            'name'      => $menuItem['name'],
            'url'       => $menuItem['url'],
            'title'     => $menuItem['title'],
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => '',
            'class'     => $menuItem['class'],
            'type'      => 'custom-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds product link menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildProductLink(array $menuItem, $id_shop, $id_lang)
    {
        $id_product = (int)$menuItem['entity_id'];
        $product = new Product($id_product, false, $id_lang, $id_shop);

        if (!$product->active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $product->name;
            }
            if (empty($url)) {
                $url = $this->context->link->getProductLink($product);
            }
            if (empty($title)) {
                $title = $product->name;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'prod-'.$id_product,
            'class'     => $menuItem['class'],
            'type'      => 'product-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildCategoryLink(array $menuItem, $id_shop, $id_lang)
    {
        $id_category = (int)$menuItem['entity_id'];
        $category = new Category($id_category, $id_lang, $id_shop);

        if (!$category-> active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $category->name;
            }
            if (empty($url)) {
                $url = $this->context->link->getCategoryLink($category);
            }
            if (empty($title)) {
                $title = $category->name;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'cat-'.$id_category,
            'class'     => $menuItem['class'],
            'type'      => 'category-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildCategoryTree(array $menuItem, $id_shop, $id_lang)
    {
        $id_category = (int)$menuItem['entity_id'];
        $category = new Category($id_category, $id_lang, $id_shop);

        if (!$category->active) {
            return false;
        }

        if ($this->context->customer->isLogged()) {
            $groups = $this->context->customer->getGroups();
        } else {
            $groups = array(Configuration::get('PS_UNIDENTIFIED_GROUP'));
        }

        $treeMaxDepth = max(0, (int)$menuItem['tree_max_depth']);

        // @TODO How is this recursive ??
        $categoryTree = Category::getNestedCategories($id_category, $id_lang, true, $groups);

        $subItems = array();
        if (!empty($categoryTree[$id_category]['children'])) {
            foreach ($categoryTree[$id_category]['children'] as $categoryTreeChild) {
                $subItems[] = $this->buildCategoryTreeItem($categoryTreeChild, $id_shop, $id_lang, 1, $treeMaxDepth);
            }
        }

        $url = empty($menuItem['url']) ? $this->context->link->getCategoryLink($category) : $menuItem['url'];

        return array(
            'name'      => empty($menuItem['name'])  ? $category->name : $menuItem['name'],
            'url'       => $url,
            'title'     => empty($menuItem['title']) ? $category->name : $menuItem['title'],
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'cat-'.$id_category,
            'class'     => $menuItem['class'],
            'type'      => 'category-tree',
            'sub_items' => $subItems,
        );
    }

    /**
     * Builds recursive category tree menu item
     *
     * @param array $category
     * @param int $id_shop
     * @param int $id_lang
     * @param int $depth
     * @param int $maxDepth
     *
     * @return array
     *
     */
    protected function buildCategoryTreeItem(array $category, $id_shop, $id_lang, $depth, $maxDepth)
    {
        $subItems = array();
        if (($maxDepth == 0 || $depth < $maxDepth) && !empty($category['children'])) {
            foreach ($category['children'] as $subCategory) {
                $subItems[] = $this->buildCategoryTreeItem($subCategory, $id_shop, $id_lang, $depth + 1, $maxDepth);
            }
        }

        return array(
            'name'      => $category['name'],
            'url'       => $this->context->link->getCategoryLink($category['id_category'], $category['link_rewrite']),
            'title'     => $category['name'],
            'icon'      => '',
            'no_follow' => false,
            'id'        => '',
            'entity_id' => 'cat-'.$category['id_category'],
            'class'     => '',
            'type'      => 'sub-category-link',
            'sub_items' => $subItems,
        );
    }

    /**
     * Builds a menu tree where subcategories of a given category
     * are a flattened
     *
     * @param array $menuItem
     * @param int   $id_shop
     * @param int   $id_lang
     *
     * @return array
     */
    protected function buildCategoryFlatTree(array $menuItem, $id_shop, $id_lang)
    {
        $tree = $this->buildCategoryTree($menuItem, $id_shop, $id_lang);
        $tree['type'] = 'category-flat-tree';

        $treeSubItems = array();
        foreach ($tree['sub_items'] as $subItemKey => $subItemTree) {
            $treeSubItems = array_merge($treeSubItems, $this->flattenMenuItemTree($subItemTree));
        }

        usort($treeSubItems, function ($a, $b) {
            return ($a['name'] < $b['name']) ? -1 : 1;
        });

        $tree['sub_items'] = $treeSubItems;

        return $tree;
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildCmsLink(array $menuItem, $id_shop, $id_lang)
    {
        $id_cms = (int)$menuItem['entity_id'];
        $cms = new CMS($id_cms, $id_lang, $id_shop);

        if (!$cms->active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $cms->meta_title;
            }
            if (empty($url)) {
                $url = $this->context->link->getCMSLink($cms);
            }
            if (empty($title)) {
                $title = $cms->meta_title;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'cms-'.$id_cms,
            'class'     => $menuItem['class'],
            'type'      => 'cms-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildCmsCategoryLink(array $menuItem, $id_shop, $id_lang)
    {
        $id_cms_category = (int)$menuItem['entity_id'];
        $cmsCategory = new CMSCategory($id_cms_category, $id_lang, $id_shop);

        if (!$cmsCategory->active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $cmsCategory->name;
            }
            if (empty($url)) {
                $url = $this->context->link->getCMSCategoryLink($cmsCategory);
            }
            if (empty($title)) {
                $title = $cmsCategory->name;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'cms-cat-'.$id_cms_category,
            'class'     => $menuItem['class'],
            'type'      => 'cms-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_shop
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildCmsCategoryTree(array $menuItem, $id_shop, $id_lang)
    {
        $treeMaxDepth = max(0, (int)$menuItem['tree_max_depth']);

        $id_cms_category = (int)$menuItem['entity_id'];
        $cmsCategory = new CMSCategory($id_cms_category, $id_lang, $id_shop);

        if (!$cmsCategory->active) {
            return false;
        }

        $url = $menuItem['url']   ? $menuItem['url']   : $this->context->link->getCMSCategoryLink($cmsCategory);

        $cmsCategoryTree = array(
            'name'      => $menuItem['name']  ? $menuItem['name']  : $cmsCategory->name,
            'url'       => $url,
            'title'     => $menuItem['title'] ? $menuItem['title'] : $cmsCategory->name,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'cms-cat-'.$id_cms_category,
            'class'     => $menuItem['class'],
            'type'      => 'cms-category-tree',
            'sub_items' => array(),
        );

        // Get the CMS Category tree (CMS included) from PrestaShop API
        $cmsCategoryTreeItem = CMSCategory::getRecurseCategory($id_lang, $id_cms_category, 1, 1);

        // Format CMSCategory item using recursive method
        $tree = $this->buildCmsCategoryTreeItem($cmsCategoryTreeItem, 1, $treeMaxDepth);

        $cmsCategoryTree['sub_items'] = $tree['sub_items'];

        return $cmsCategoryTree;
    }

    /**
     * Builds recursive CMS category menu tree item
     *
     * @param array $cmsCategory
     * @param int   $depth
     * @param int   $maxDepth
     *
     * @return array
     */
    protected function buildCmsCategoryTreeItem(array $cmsCategory, $depth, $maxDepth)
    {
        $cmsCategoryTreeItem = array(
            'name'      => $cmsCategory['name'],
            'url'       => $cmsCategory['link'],
            'title'     => $cmsCategory['name'],
            'icon'      => '',
            'no_follow' => false,
            'id'        => '',
            'entity_id' => 'cms-cat-'.$cmsCategory['id_cms_category'],
            'class'     => '',
            'type'      => 'sub-cms-category-link',
            'sub_items' => array(),
        );

        if ($maxDepth == 0 || $depth < $maxDepth) {
            foreach ($cmsCategory['cms'] as $cms) {
                $cmsCategoryTreeItem['sub_items'][] = $this->buildCmsCategoryTreeCmsItem($cms);
            }

            foreach ($cmsCategory['children'] as $subCmsCategory) {
                $cmsCategoryTreeItem['sub_items'][] = $this->buildCmsCategoryTreeItem(
                    $subCmsCategory,
                    $depth + 1,
                    $maxDepth
                );
            }
        }

        return $cmsCategoryTreeItem;
    }

    /**
     * Formats CMS item into menu item standard
     *
     * @param array $cms
     *
     * @return array
     */
    protected function buildCmsCategoryTreeCmsItem(array $cms)
    {
        return array(
            'name'      => $cms['meta_title'],
            'url'       => $cms['link'],
            'title'     => $cms['meta_title'],
            'icon'      => '',
            'no_follow' => false,
            'id'        => '',
            'entity_id' => 'cms-'.$cms['id_cms'],
            'class'     => '',
            'type'      => 'sub-cms-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildManufacturerLink(array $menuItem, $id_lang)
    {
        $id_manufacturer = (int)$menuItem['entity_id'];
        $manufacturer = new Manufacturer($id_manufacturer, $id_lang);

        if ($manufacturer->active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $manufacturer->name;
            }

            if (empty($url)) {
                $url = $this->context->link->getManufacturerLink($manufacturer);
            }

            if (empty($title)) {
                $title = $manufacturer->name;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'man-'.$id_manufacturer,
            'class'     => $menuItem['class'],
            'type'      => 'manufacturer-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildManufacturerList(array $menuItem, $id_lang)
    {
        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $this->l('Manufacturers');
            }

            if (empty($url)) {
                $url = $this->context->link->getPageLink('manufacturer');
            }

            if (empty($title)) {
                $title = $this->l('A list of all Manufacturers');
            }
        }

        $subItems = array();
        foreach (Manufacturer::getManufacturers(false, $id_lang) as $manufacturer) {
            $subItems[] = array(
                'name'      => $manufacturer['name'],
                'url'       => $this->context->link->getManufacturerLink(
                    (int)$manufacturer['id_manufacturer'],
                    $manufacturer['link_rewrite']
                ),
                'title'     => $manufacturer['name'],
                'icon'      => '',
                'no_follow' => false,
                'id'        => '',
                'entity_id' => 'man-'.$manufacturer['id_manufacturer'],
                'class'     => '',
                'type'      => 'manufacturer-list-link',
                'sub_items' => array(),
            );
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => '',
            'class'     => $menuItem['class'],
            'type'      => 'manufacturer-list',
            'sub_items' => $subItems,
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildSupplierLink(array $menuItem, $id_lang)
    {
        $id_supplier = (int)$menuItem['entity_id'];
        $supplier = new Supplier($id_supplier, $id_lang);

        if ($supplier->active) {
            return false;
        }

        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $supplier->name;
            }

            if (empty($url)) {
                $url = $this->context->link->getSupplierLink($supplier);
            }

            if (empty($title)) {
                $title = $supplier->name;
            }
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => 'sup-'.$id_supplier,
            'class'     => $menuItem['class'],
            'type'      => 'supplier-link',
            'sub_items' => array(),
        );
    }

    /**
     * Builds menu item
     *
     * @param array $menuItem
     * @param int $id_lang
     *
     * @return array
     */
    protected function buildSupplierList(array $menuItem, $id_lang)
    {
        $name  = $menuItem['name'];
        $url   = $menuItem['url'];
        $title = $menuItem['title'];

        if (empty($name) || empty($url) | empty($title)) {
            if (empty($name)) {
                $name = $this->l('Suppliers');
            }

            if (empty($url)) {
                $url = $this->context->link->getPageLink('supplier');
            }

            if (empty($title)) {
                $title = $this->l('A list of all suppliers');
            }
        }

        $subItems = array();
        foreach (Supplier::getSuppliers(false, $id_lang) as $supplier) {
            $subItems[] = array(
                'name' => $supplier['name'],
                'url'  => $this->context->link->getSupplierLink(
                    (int)$supplier['id_supplier'],
                    $supplier['link_rewrite']
                ),
                'title'     => $supplier['name'],
                'icon'      => '',
                'no_follow' => false,
                'id'        => '',
                'entity_id' => 'sup-'.$supplier['id_supplier'],
                'class'     => '',
                'type'      => 'supplier-list-link',
                'sub_items' => array(),
            );
        }

        return array(
            'name'      => $name,
            'url'       => $url,
            'title'     => $title,
            'icon'      => $menuItem['icon'],
            'no_follow' => $menuItem['no_follow'],
            'id'        => $menuItem['id_ct_top_menu_item'],
            'entity_id' => '',
            'class'     => $menuItem['class'],
            'type'      => 'supplier-list',
            'sub_items' => $subItems,
        );
    }

    /**
     * Flattens the menu tree to a flat list (array)
     *
     * @param array $menuItem
     *
     * @return array
     */
    protected function flattenMenuItemTree(array $menuItem)
    {
        $menuItemList = array();

        foreach ($menuItem['sub_items'] as $menuSubItem) {
            $menuItemList = array_merge($menuItemList, $this->flattenMenuItemTree($menuSubItem));
        }

        $menuItem['sub_items'] = array();
        $menuItemList[] = $menuItem;

        return $menuItemList;
    }
}
