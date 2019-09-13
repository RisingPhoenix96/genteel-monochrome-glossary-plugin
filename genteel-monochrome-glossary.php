<?php

/**
 * Plugin Name: Genteel Monochome Glossary
 * Plugin URI: https://lgm.design/
 * Description: A glossary page plugin for the Genteel Monochrome theme.
 * Version: 1.0
 * Author: LGM
 * Author URI: https://lgm.design/about/
 * Text Domain: /
 * Contributors: LGM
 */

/**
 * Block direct access to plugin files
 */
/*if (!defined('ABSPATH')) {

    exit();
}*/

/**
 * Create custom post type on plugin activation
 */
/*function genteel_monochrome_glossary_setup_post_type()
{

    // register custon post type named "genteel_monochrome_glossary_item"
    if (!post_type_exists('genteel_monochrome_glossary_item')) {

        register_post_type('lgm_glossary_item', ['public' => 'true']);
    }
}

add_action('init', 'genteel_monochrome_glossary_setup_post_type');*/

/**
 * Add custom menu page to the WordPress sidebar
 */
/*function genteel_monochrome_glossary_add_menu()
{

    add_menu_page('Monochrome Glossary', 'Monochrome Glossary', 'manage_options', 'genteel-monochrome-glossary');
    //add_submenu_page( $parent_slug:string, $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $function:callable );
    add_submenu_page('genteel-monochrome-glossary', 'Add A New Term', 'Add A New Term', 'manage_options', 'genteel-monochrome-glossary/add-new');
    add_submenu_page('genteel-monochrome-glossary', 'User Guide', 'User Guide', 'manage_options', 'genteel-monochrome-glossary/user-guide');
}

add_action('admin_menu', 'genteel_monochrome_glossary_add_menu');*/

class GenteelMonochromeGlossary
{

    function __construct()
    {
        /**
         * On a new instance of the class,
         * trigger the creation of a custom post type
         * */
        add_action('init', array($this, 'custom_post_type'));
        add_action('admin_menu', array($this, 'add_menu'));
    }

    function activate()
    {

        /**
         * We have generated a custom post type in the __constructor
         * So now we need to flush rewrite rules
         * i.e make WordPress aware of the new custom post type and read them fresh from the database
         * */
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate()
    {

        // Flush rewrite rules (make WordPress aware of the deactivation of the custom post type)
        flush_rewrite_rules();
    }

    function uninstall()
    {

        // Delete all plugin data from the database

    }

    function custom_post_type()
    {

        if (!post_type_exists('lgm_monochrome_glossary_item')) {

            register_post_type('lgm_glossary_item', ['public' => true, 'label' => 'Monochrome Glossary Items']);
        }
    }

    function add_menu()
    {

        add_menu_page('Monochrome Glossary', 'Monochrome Glossary', 'manage_options', 'genteel-monochrome-glossary');
        add_submenu_page('genteel-monochrome-glossary', 'Settings', 'Settings', 'manage_options', 'genteel-monochrome-glossary');
        add_submenu_page('genteel-monochrome-glossary', 'User Guide', 'User Guide', 'manage_options', 'genteel-monochrome-glossary/user-guide');
    }
}

if (class_exists('GenteelMonochromeGlossary')) {

    $glossary = new GenteelMonochromeGlossary();
}

// Activate plugin
register_activation_hook(__FILE__, array($glossary, 'activate'));

// Deactivate plugin
register_deactivation_hook(__FILE__, array($glossary, 'deactivate'));

// Uninstall plugin
