<?php

/**
 * Script is triggered when the user uninstalls the plugin
 */

if (!defined('WP_UNISTALL_PLUGIN')) {
    /**
     * Immediately end the script's execution if the WP_UNINSTALL_PLUGIN constant is not defined by WordPress.
     * This prevents unwanted uninstallation/deletion of the plugin.
     */
    die;
}

/**
 * Alternative method of deleting database storage using wpdb
 * Use carefully, has the potential to destroy
 */
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'lgm_glossary_item'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
