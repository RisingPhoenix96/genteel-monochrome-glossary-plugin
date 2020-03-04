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
 * Manually remove all plugin data from tables using the $wpdb object.
 * Using $wpdb allows me to run SQL queries on the database.
 */
global $wpdb;

// Delete all posts that have our defined glossary item post type.
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'lgm_glossary_item'");

// Delete all post metadata that have a post IDs that do not exist in the wp_posts table.
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");

// Delete all post relationships that have object IDs that do not exist in the wp_posts table.
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
