<?php

/**
 * Class CTDevComponentsModuleFrontController
 *
 * @property CTDev $module
 */
class CTDevComponentsModuleFrontController extends ModuleFrontController
{
    /**
     * Controller initialization
     */
    public function init()
    {
        parent::init();

        $this->display_column_left  = false;
        $this->display_column_right = false;
    }

    /**
     * Add CSS and JS files here
     */
    public function setMedia()
    {
        parent::setMedia();

        // @TODO Queue .js scripts and .css files here
        // $this->context->controller->addJS($this->module->getLocalPath().'views/js/fo.js');
        // $this->context->controller->addCSS($this->module->getLocalPath().'views/css/fo.css');
    }

    /**
     * Initializes page content
     *
     * @throws PrestaShopException
     */
    public function initContent()
    {
        parent::initContent();

        $this->context->smarty->assign(array(
            // @TODO Assign template variables
        ));

        $this->setTemplate('components.tpl');
    }
}
