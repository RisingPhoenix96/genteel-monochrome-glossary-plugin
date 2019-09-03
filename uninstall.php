<?php

/**
 * Script is triggered when the user deletes/uninstalls the plugin
 */

if (!defined('WP_UNISTALL_PLUGIN')) {

    die;
}

// Clear database storage
/*$args = array(

    'post_type' => 'lgm_glossary_item',
    'numberposts' => -1,

);
$posts = get_posts($args);

foreach ($posts as $post) {

    wp_delete_post($post->ID, true);
}*/

/**
 * Alternative method of deleting database storage using wpdb
 * Use carefully, has the potential to destroy
 */
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'lgm_glossary_item'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
