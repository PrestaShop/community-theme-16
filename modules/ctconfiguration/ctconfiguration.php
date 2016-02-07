<?php

/**
 * Class CTConfiguration
 *
 * @property $bootstrap
 */
class CTConfiguration extends Module
{
    /**
     * CTConfiguration constructor.
     */
    public function __construct()
    {
        $this->name    = 'ctconfiguration';
        $this->tab     = 'front_office_features';
        $this->version = '1.0.0';
        $this->author  = 'PrestaShop Community';

        parent::__construct();

        $this->displayName = $this->l('Community Configuration');
        $this->description = $this->l('Configuration for community theme blocks and content.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6.1.4');

        $this->bootstrap = true;
    }

    /**
     * Installs module to PrestaShop
     *
     * @return bool
     */
    public function install()
    {
        parent::install();

        $hooksToUnhook = array(
            array('module' => 'blockcategories', 'hook' => 'footer',)
        );
        foreach ($hooksToUnhook as $unhook) {
            $this->unhookModule($unhook['module'], $unhook['hook']);
        }

        $hooksToInstall = array('displayHeader');
        foreach ($hooksToInstall as $hookName) {
            $this->registerHook($hookName);
        }

        // Translatable configuration items
        foreach (Language::getLanguages(false) as $language) {
            $id_language = (int)$language['id_lang'];

            Configuration::updateValue('CT_CFG_COPYRIGHT_CONTENT', array(
                $id_language => '&copy; Acme Corporation 2016'
            ));
        }

        return true;
    }

    /***
     * Uninstalls module from PrestaShop
     *
     * @return bool
     */
    public function uninstall()
    {
        $keysToDrop = array(
            'CT_CFG_BLOCKCATEGORIES_FOOTER',
            'CT_CFG_COPYRIGHT_CONTENT',
        );
        foreach ($keysToDrop as $key) {
            Configuration::deleteByName($key);
        }

        return parent::uninstall();
    }

    /**
     * Registers a module hook
     *
     * @param string $module
     * @param string $hook
     *
     * @return bool
     */
    protected function hookModule($module, $hook)
    {
        $module = Module::getInstanceByName($module);
        return $module->registerHook($hook);
    }

    /**
     * Unhooks a module hook
     *
     * @param string $module
     * @param string $hook
     *
     * @return bool
     */
    protected function unhookModule($module, $hook)
    {
        $id_module = Module::getModuleIdByName($module);
        $id_hook   = Hook::getIdByName($hook);

        return Db::getInstance()->delete('hook_module', 'id_module = '.(int)$id_module.' AND id_hook = '.(int)$id_hook);
    }

    /**
     * Compiles and returns module configuration page content
     *
     * @return string
     */
    public function getContent()
    {
        $this->postProcess();

        $moduleUrl = $this->context->link->getAdminLink('AdminModules').'&configure='.$this->name;

        $fieldSets = array(
            'general' => array(
                'title'  => $this->l('Module settings'),
                'fields' => array(
                    'CT_CFG_BLOCKCATEGORIES_FOOTER' => array(
                        'title' => $this->l('Show blockcategories footer block'),
                        'desc'  => $this->l('If enabled, shows category tree block in the footer.'),
                        'cast'  => 'boolval',
                        'type'  => 'bool',
                    ),
                    'CT_CFG_COPYRIGHT_CONTENT' => array(
                        'title' => $this->l('Copyright footer text'),
                        'desc'  => $this->l('Text to be displayed in the copyright footer block.')
                            .' '.$this->l('Leave empty to not displayed the block.'),
                        'hint'  => $this->l('HTML is allowed. Enter &amp;copy; for copyright symbol.'),
                        'cast'  => 'strval',
                        'type'  => 'textareaLang',
                        'size'  => 50,
                    ),
                ),
                'buttons' => array(
                    'cancelBlock' => array(
                        'title' => $this->l('Cancel'),
                        'href'  => $moduleUrl,
                        'icon'  => 'process-icon-cancel'
                    ),
                ),
                'submit' => array(
                    'name'  => 'submit'.$this->name,
                    'title' => $this->l('Save'),
                ),
            )
        );

        $h = new HelperOptions();
        $h->token = Tools::getAdminTokenLite('AdminModules');
        $h->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $h->id = Tab::getIdFromClassName('AdminTools');

        return $h->generateOptions($fieldSets);
    }

    /**
     * Processes submitted configuration variables
     */
    protected function postProcess()
    {
        $blockcategoriesFooter = (int)Tools::getValue('CT_CFG_BLOCKCATEGORIES_FOOTER');
        if ($blockcategoriesFooter) {
            $this->hookModule('blockcategories', 'footer');
        } else {
            $this->unhookModule('blockcategories', 'footer');
        }
    }

    /**
     * Adds assets to page header
     * and passes configuration variables to smarty
     */
    public function hookDisplayHeader()
    {
        // @TODO Cache configuration array with Cache::getInstance()?

        $this->context->smarty->assign(array(
            'ctheme' => array(
                'footer' => array(
                    'copyright' => array(
                        'display' => true,
                        'html'    => Configuration::get('CT_CFG_COPYRIGHT_CONTENT'),
                    ),
                ),
            ),
        ));
    }
}
