<?php
/*
 *Plugin Name: Woo Attributes 
 *Plugin URI: https://novinwebsaz.net/
 *Description: This plugin makes changing attributes of products easier and much faster than the default products attribute manager on product edit page for woocommerce
 *Version: 1.1.5
 *Author: Ashkan Khalili
 *@copyright 2025 NovinWebSaz
 *License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
namespace Attributes;

if (!defined('ATTRIBUTES_PLUGIN_PATH')) {
    define('ATTRIBUTES_PLUGIN_PATH', dirname(__FILE__).'/');
    define('ATTRIBUTES_PLUGIN_VERSION', '1.1.5');
    define('ATTRIBUTES_PREFIX', 'attr');
}


require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/ashkankhalili/woo-attributes',
    __FILE__,
    'woo-attributes'
);
$myUpdateChecker->setBranch('main');
require_once ATTRIBUTES_PLUGIN_PATH.'core/admin-page.php';

$admin_page = new AdminPage();

