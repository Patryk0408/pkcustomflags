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
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pk_custom_flags` (
    `id_flag` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL,
    `text` varchar(255) NOT NULL, 
    `color` varchar(7),
    `categories` TEXT, 
    `products` TEXT
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

// $sql[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pk_custom_flag_conditions` (
//     `id_condition` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//     `id_flag` int(11) NOT NULL,
//     `categories` TEXT NOT NULL, 
//     `products` TEXT NOT NULL,
//     FOREIGN KEY (`id_flag`) REFERENCES `' . _DB_PREFIX_ . 'pk_custom_flags`(`id_flag`) ON DELETE CASCADE
// ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
