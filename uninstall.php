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
 * Fetch all posts with the defined glossary item custom post type.
 * Setting numberposts to -1 fetches all posts.
 * Store all posts and post data in the $glossary variable as an array.
 */
$glossary = get_posts([
    'post_type' => 'lgm_glossary_item',
    'numberposts' => -1,
]);

/**
 * Loop through all items in the array using PHP's foreach loop.
 */
foreach ($glossary as $term) {
    /**
     * For each post in the array, run the wp_delete_post() function.
     * This delete the current post. The post's ID is required for this to work.
     * wp_delete_post() also removes the post's data from other tables in the database.
     * The parameter 'true' tells WordPress to bypass the trash and fully remove the post from the database.
     */
    wp_delete_post($term->ID, true);
}
