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

class Flag extends ObjectModel {
    public $id_flag;
    public $name;
    public $text;
    public $color;
    public $categories;

    public static $definition = [
        'table' => 'pk_custom_flags',
        'primary' => 'id_flag',
        'multilang' => false,
        'fields' => [
            'name' => [
                'type' => self::TYPE_STRING, 
                'size' => 255, 
                'validate' => 'isGenericName',
                'required' => true
            ],
            'text' => [
                'type' => self::TYPE_STRING, 
                'size' => 255, 
                'validate' => 'isCleanHtml',
                'required' => false
            ],
            'color' => [
                'type' => self::TYPE_STRING, 
                'size' => 7, 
                'validate' => 'isString',
                'required' => false
            ],
            'categories' => [
                'type' => self::TYPE_STRING, 
                'validate' => 'isCleanHtml',
                'required' => false
            ],
        ]
    ];

    public static function getAllFlags()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('pk_custom_flags');
        return Db::getInstance()->executeS($sql);
    }
}