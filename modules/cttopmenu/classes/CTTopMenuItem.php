<?php

/**
 * Class CTTopMenuItem
 */
class CTTopMenuItem extends ObjectModel
{
    /**
     * Menu item types
     */
    const TYPE_CUSTOM_LINK        = 0;
    const TYPE_PRODUCT            = 1;
    const TYPE_CATEGORY           = 2;
    const TYPE_CATEGORY_TREE      = 3;
    const TYPE_CATEGORY_FLAT_TREE = 11;
    const TYPE_CMS                = 4;
    const TYPE_CMS_CATEGORY       = 5;
    const TYPE_CMS_CATEGORY_TREE  = 6;
    const TYPE_MANUFACTURER       = 7;
    const TYPE_MANUFACTURER_LIST  = 8;
    const TYPE_SUPPLIER           = 9;
    const TYPE_SUPPLIER_LIST      = 10;

    /** @var int */
    public $type = 0;

    /** @var int */
    public $entity_id;

    /** @var string */
    public $name;

    /** @var string */
    public $icon;

    /** @var string */
    public $class;

    /** @var string */
    public $title;

    /** @var string */
    public $url;

    /** @var bool */
    public $no_follow = false;

    /** @var int */
    public $tree_max_depth = 0;

    /** @var bool */
    public $active = true;

    /** @var int */
    public $position;

    /**
     * Model definition
     *
     * @var array
     */
    public static $definition = array(
        'table'     => 'ct_top_menu_item',
        'primary'   => 'id_ct_top_menu_item',
        'multilang' => true,
        'fields'    => array(
            'type' => array(
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
                'required' => true,
                'values' => array(
                    self::TYPE_CUSTOM_LINK,
                    self::TYPE_PRODUCT,
                    self::TYPE_CATEGORY,
                    self::TYPE_CATEGORY_TREE,
                    self::TYPE_CATEGORY_FLAT_TREE,
                    self::TYPE_CMS,
                    self::TYPE_CMS_CATEGORY,
                    self::TYPE_CMS_CATEGORY_TREE,
                    self::TYPE_MANUFACTURER,
                    self::TYPE_MANUFACTURER_LIST,
                    self::TYPE_SUPPLIER,
                    self::TYPE_SUPPLIER_LIST,
                ),
                'default' => self::TYPE_CUSTOM_LINK
            ),
            'entity_id'      => array('type' => self::TYPE_INT,    'validate' => 'isUnsignedId'),
            'icon'           => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'length' => '64'),
            'class'          => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'length' => '64'),
            'tree_max_depth' => array('type' => self::TYPE_INT,    'validate' => 'isUnsignedInt'),
            'no_follow'      => array('type' => self::TYPE_BOOL,   'validate' => 'isBool'),
            'active'         => array('type' => self::TYPE_BOOL,   'validate' => 'isBool'),

            // Shop fields
            // @see Object::formatFields uses incorrect comparison operator for $data['shop'] != 'both'
            // That why we 'hack' it using 'shop' => 1
            'position'       => array('type' => self::TYPE_INT,    'validate' => 'isUnsignedInt', 'shop' => '1'),

            // Language fields
            'name'  => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName' , 'lang' => true),
            'title' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName' , 'lang' => true),
            'url'   => array('type' => self::TYPE_STRING, 'validate' => 'isUrl' ,         'lang' => true),
        ),
    );

    /**
     * Inserts new menu item to the database
     *
     * @param bool $autoDate
     * @param bool $nullValues
     *
     * @return bool
     * @throws PrestaShopException
     */
    public function add($autoDate = true, $nullValues = false)
    {
        $status = parent::add($autoDate, $nullValues);

        Hook::exec('actionCTTopMenuCompositionChanged');

        if ($status) {
            $id_shop_list = Shop::getContextListShopID();
            if (!empty($this->id_shop_list)) {
                $id_shop_list = $this->id_shop_list;
            }

            // @TODO Fix initial value
            foreach ($id_shop_list as $id_shop) {
                Db::getInstance()->update(
                    'ct_top_menu_item_shop',
                    array(
                        'position' => self::getMaxPosition($id_shop) + 1
                    ),
                    'id_ct_top_menu_item = '.(int)$this->id.' AND id_shop = '.(int)$id_shop
                );
            }
        }

        return $status;
    }

    /**
     * Clears menu cached on update event
     *
     * @param bool $nullValues
     * @return bool
     * @throws PrestaShopException
     */
    public function update($nullValues = false)
    {
        $result = parent::update($nullValues);
        Hook::exec('actionCTTopMenuCompositionChanged');
        return $result;
    }

    /**
     * Clears menu cache on delete event
     *
     * @return bool
     * @throws PrestaShopException
     */
    public function delete()
    {
        $result = parent::delete();
        Hook::exec('actionCTTopMenuCompositionChanged');
        return $result;
    }

    /**
     * Returns max position in the given shop
     *
     * @param int $id_shop
     *
     * @return int
     */
    public static function getMaxPosition($id_shop)
    {
        $sql = new DbQuery();
        $sql->select('MAX(position)');
        $sql->from('ct_top_menu_item_shop');
        $sql->where('id_shop = '.(int)$id_shop);

        $position = Db::getInstance()->getValue($sql);

        return Tools::strlen($position) ? (int)$position : -1;
    }

    /**
     * Returns all menu items for a given shop
     *
     * @param int $id_lang
     * @param int $id_shop
     *
     * @return array
     */
    public static function getMenuItems($id_lang, $id_shop)
    {
        $sql = new DbQuery();
        $sql->select('i.*, il.url, il.title, il.name');
        $sql->from('ct_top_menu_item', 'i');
        $sql->leftJoin(
            'ct_top_menu_item_lang',
            'il',
            'i.id_ct_top_menu_item = il.id_ct_top_menu_item AND il.id_lang = '.(int)$id_lang
        );

        $sql->innerJoin(
            'ct_top_menu_item_shop',
            'ishop',
            'i.id_ct_top_menu_item = ishop.id_ct_top_menu_item AND ishop.id_shop = '.(int)$id_shop
        );
        $sql->orderBy('ishop.position ASC');

        return (array)Db::getInstance()->executeS($sql);
    }
}
