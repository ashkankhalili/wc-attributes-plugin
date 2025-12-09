<?php
/**
 * @package   Attributes
 * @author    Ashkan Khalili
 * @copyright 2025 NovinWebSaz
 * @license   GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WC Attributes Manager
 * Plugin URI: https://github.com/ashkankhalili/wc-attributes-plugin
 * 
 * Description:       This plugin makes changing attributes of products easier and much faster than the default products attribute manager on product edit page for woocommerce
 * Version:           1.0.4
 */

namespace Attributes;

if (!defined('ATTRIBUTES_PLUGIN_PATH')) {
    define('ATTRIBUTES_PLUGIN_PATH', dirname(__FILE__).'/');
    define('ATTRIBUTES_PLUGIN_VERSION', '1.0.4');
    define('ATTRIBUTES_PREFIX', 'attr');
}


require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/ashkankhalili/wc-attributes-plugin',
    __FILE__,
    'attributes-plugin'
);

require_once ATTRIBUTES_PLUGIN_PATH.'core/admin-page.php';

$admin_page = new AdminPage();

