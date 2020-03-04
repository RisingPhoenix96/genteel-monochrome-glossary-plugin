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
if (!defined('ABSPATH')) {

    exit();
}

class GenteelMonochromeGlossary
{

    function __construct()
    {
        /**
         * When a new instance of this class is created, run the custom_post_type() and add_menu() methods.
         * This will trigger the registration of the custom post type required for glossary items.
         * This will also trigger the creation of a new menu item in the WordPress menu bar.
         * 
         * add_action() is a WordPress function that runs a specific function when a specific WordPress action occurs.
         * add_action('init') runs a function on when WordPress is initialised.
         * add_action('admin_menu') will run the add_menu() method when WordPress begins to generate menus.
         */
        add_action('init', array($this, 'custom_post_type'));
        add_action('admin_menu', array($this, 'add_menu'));
    }

    function activate()
    {
        /**
         * This method simply runs the custom_post_type() method that registers the custom post type we need.
         * This method is ran when the plugin is activated in WordPress. register_activation_hook() function is required for this to work.
         */
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate()
    {

        /**
         * This method simply flushes the rewrite rules.
         * This forces WordPress to remove existing rewrite rules and generate new ones.
         * 
         * Rewrite rules determine the full URL path to specific files.
         * When the plugin is deactivated, this will also deactivate the custom post type and the URL's related to these post types need to be removed.
         */
        flush_rewrite_rules();
    }

    function custom_post_type()
    {
        /**
         * If no custom post type named 'lgm_monochrome_glossary_item' exists
         * then create it using WordPress' register_post_type() method.
         */
        if (!post_type_exists('lgm_glossary_item')) {

            register_post_type('lgm_glossary_item', ['public' => true, 'label' => 'Monochrome Glossary Items']);
        }
    }

    function add_menu()
    {
        /**
         * Add a WordPress menu page for glossary items.
         * Menu page will have sub-menu items.
         */
        add_menu_page('Monochrome Glossary', 'Monochrome Glossary', 'manage_options', 'genteel-monochrome-glossary');
        add_submenu_page('genteel-monochrome-glossary', 'Settings', 'Settings', 'manage_options', 'genteel-monochrome-glossary');
        add_submenu_page('genteel-monochrome-glossary', 'User Guide', 'User Guide', 'manage_options', 'genteel-monochrome-glossary/user-guide');
    }
}

if (class_exists('GenteelMonochromeGlossary')) {
    /**
     * If the defined class exists then create a new instance of it.
     * __construct() function runs on new instance.
     * 
     * Checking if the class exists first prevents unwanted errors.
     */
    $glossary = new GenteelMonochromeGlossary();
}

/**
 * Trigger the activate() method when the plugin is activated in WordPress.
 * This activates the plugin and registers the custom post type required for glossary items.
 */
register_activation_hook(__FILE__, array($glossary, 'activate'));

/**
 * Trigger the deactivate() method when the plugin is deactivated in WordPress.
 * This deactivates the plugin by de-registering the custom post type.
 */
register_deactivation_hook(__FILE__, array($glossary, 'deactivate'));
