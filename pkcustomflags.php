<?php
/**
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Pkcustomflags extends Module
{
    const ADMINCONTROLLERS = [
        'adminConfigure' => 'AdminConfigurePkCustomFlags',
    ];

    public function __construct()
    {
        $this->name = 'pkcustomflags';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Patryk Krawczyk';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Show flags on product');
        $this->description = $this->l('This module show custom flags on product');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '8.0', 'max' => _PS_VERSION_);
        $this->registerHook('displayAfterProductThumbs');
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install(): bool
    {
        include(dirname(__FILE__).'/sql/install.php');

        return parent::install()
            && $this->installTabs()
            && $this->registerHook('displayAfterProductThumbs');
    }

    public function uninstall(): bool
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall()
            && $this->uninstallTabs();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        $link = $this->context->link->getAdminLink('AdminConfigurePkCustomFlags');

        Tools::redirectAdmin($link);
        
        return '';
    }

    /**
     * @return bool
     */
    public function installTabs(): bool
    {
        $result = true;

        foreach (static::ADMINCONTROLLERS as $controller_name) {
            if (Tab::getIdFromClassName($controller_name)) {
                continue;
            }

            $tab = new Tab();
            $tab->class_name = $controller_name;
            $tab->module = $this->name;
            $tab->active = false;
            $tab->id_parent = -1;
            $tab->name = array_fill_keys(
                Language::getIDs(false),
                $this->displayName
            );
            $result = $result && (bool) $tab->add();
        };

        return $result;
    }

    /**
     * @return bool
     */
    public function uninstallTabs(): bool
    {
        $result = true;

        foreach (Tab::getCollectionFromModule($this->name) as $tab) {
            /** @var Tab $tab */
            $result = $result && (bool) $tab->delete();
        }

        return $result;
    }

    public function hookDisplayAfterProductThumbs() 
    {
        
    }
}