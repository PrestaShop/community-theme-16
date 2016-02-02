CREATE TABLE IF NOT EXISTS `{{ db_prefix }}ct_top_menu_item` (
    `id_ct_top_menu_item`   INT(11)     NOT NULL AUTO_INCREMENT,
    `type`                  TINYINT(1)  NOT NULL,
    `entity_id`             VARCHAR(11) DEFAULT 0,
    `icon`                  VARCHAR(64) NULL,
    `class`                 VARCHAR(64) NULL,
    `tree_max_depth`        TINYINT(1)  DEFAULT 0,
    `no_follow`             TINYINT(1)  DEFAULT 0,
    `active`                TINYINT(1)  DEFAULT 1,

    /* Bug: allow PrestaShop to insert dummy values here */
    `position`              INT(10) DEFAULT 0,

    PRIMARY KEY (`id_ct_top_menu_item`)
) ENGINE = {{ mysql_engine }} DEFAULT CHARSET = UTF8;

CREATE TABLE IF NOT EXISTS `{{ db_prefix }}ct_top_menu_item_lang` (
    `id_ct_top_menu_item`   INT(11)     NOT NULL,
    `id_lang`               INT(11)     NOT NULL,
    `url`                   TEXT        NULL,
    `title`                 VARCHAR(64) NULL,
    `name`                  VARCHAR(64) NULL,
    PRIMARY KEY (`id_ct_top_menu_item`, `id_lang`)
) ENGINE = {{ mysql_engine }} DEFAULT CHARSET = UTF8;

CREATE TABLE IF NOT EXISTS `{{ db_prefix }}ct_top_menu_item_shop` (
    `id_ct_top_menu_item`   INT(11) NOT NULL,
    `id_shop`               INT(11) NOT NULL,
    `position`              INT(10) DEFAULT 0,
    PRIMARY KEY (`id_ct_top_menu_item`, `id_shop`)
) ENGINE = {{ mysql_engine }} DEFAULT CHARSET = UTF8;

/* Keys for sorting and indexing */
