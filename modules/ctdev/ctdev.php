<?php

/**
 * Class CTDev
 *
 * @property $bootstrap
 */
class CTDev extends Module
{
    /**
     * CTDev constructor.
     */
    public function __construct()
    {
        $this->name    = 'ctdev';
        $this->tab     = 'others';
        $this->version = '1.0.0';
        $this->author  = 'PrestaShop Community';

        parent::__construct();

        $this->displayName = $this->l('Community Theme Development Package');
        $this->description = $this->l('Provides test pages where developers can view customized theme styles.');
        $this->ps_versions_compliancy = array('min' => '1.6.0.3', 'max' => _PS_VERSION_);

        $this->bootstrap = true;
    }

    /**
     * Installs module to PrestaShop
     *
     * @return bool
     */
    public function install()
    {
        return parent::install();
    }

    /***
     * Uninstalls module from PrestaShop
     *
     * @return bool
     */
    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Compiles and returns module configuration page content
     *
     * @return string
     */
    public function getContent()
    {
        $url = $this->context->link->getModuleLink($this->name, 'components');
        return '<a href="'.$url.'">'.$url.'</a>';
    }
}
