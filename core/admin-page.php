<?php
namespace Attributes;

if (class_exists('AdminPage')) {
    return;
}

class AdminPage
{
    private static $OVERVIEW_PAGE_NAME = ATTRIBUTES_PREFIX.'-overview';

    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', array(&$this, 'enqueueScripts'));
            add_action('add_meta_boxes', array($this, 'addMetaBox'));
        }
    }

    public function addMetaBox()
    {
        add_meta_box(
            'bulk_attributes',
            __('تغییر ویژگی‌ها', 'woo-attributes'),
            array($this, 'attributesMetaBoxContent'),
            'product',
            'advanced',
            'high'
        );
    }

    public function attributesMetaBoxContent($object)
    {
        $attributes = wc_get_attribute_taxonomies();
        global $product;
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }
        require_once('templates/bulk-attributes-block.php');
    }

     public function attributesTab($product_data_tabs)
    {

        $product_data_tabs['bulk_attributes'] = array(
            'label' => __('Bulk Attributes', 'woo-attributes'),
            'target' => 'bulk_attributes_block',
            'priority' => 60,
            'class'   => array(),
        );
        return $product_data_tabs;
    }

    public function attributesBlock()
    {
        $attributes = wc_get_attribute_taxonomies();
        global $product;
        if (!is_object($product)) {
            $product = wc_get_product(get_the_ID());
        }
        require_once('templates/bulk-attributes-block.php');
    } 

    public function enqueueScripts($hook_suffix)
    {
        
        wp_enqueue_style('semantic-style-rtl',plugins_url( 'static/semantic.rtl.min.css', __FILE__ ),array(),ATTRIBUTES_PLUGIN_VERSION);

        wp_enqueue_style('rtl-style',plugins_url( 'static/style-rtl.css',__FILE__ ),array(),ATTRIBUTES_PLUGIN_VERSION);

        wp_enqueue_style('fix-style',plugins_url( 'static/fix.css', __FILE__ ),array(),ATTRIBUTES_PLUGIN_VERSION);

        wp_register_script('jquery3.1.1','https://code.jquery.com/jquery-3.1.1.min.js',array(),ATTRIBUTES_PLUGIN_VERSION,true);


        wp_add_inline_script('jquery3.1.1', 'var jQuery3_1_1 = $.noConflict(true);');
        wp_enqueue_script('semantic-js', plugins_url('static/semantic.min.js', __FILE__), array('jquery3.1.1'));
        
    }
}