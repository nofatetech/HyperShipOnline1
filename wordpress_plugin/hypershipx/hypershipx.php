<?php
/**
 * Plugin Name: HyperShipX
 * Plugin URI: https://hypership.online
 * Description: A WordPress plugin for HyperShip.
 * Version: 1.0.0
 * Author: NoFateTech
 * Author URI: https://hypership.online
 * Text Domain: hypershipx
 * Requires at least: 5.0
 * Requires PHP: 8+
 * WC requires at least: 7.0
 * WC tested up to: 9.3
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


/*
## post types:
- hypership-app
- hypership-route
    - Fields:
        - app_parent
        - domain_parent
- hypership-app-domain
    - Fields:
        - app_parent
- hypership-app-frapp
    - Fields:
        - app_parent
- hyp-app-registration
    - Fields:
        - hypership_app
        - user
- hypership-event?

*/



if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('HYPERSHIPX_VERSION', '0.1.0');
define('HYPERSHIPX_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HYPERSHIPX_PLUGIN_URL', plugin_dir_url(__FILE__));


require_once HYPERSHIPX_PLUGIN_DIR . 'app/core/init-core.php';

require_once HYPERSHIPX_PLUGIN_DIR . 'app/admin/init-admin.php';

require_once HYPERSHIPX_PLUGIN_DIR . 'app/frapps/init-frapps.php';

require_once HYPERSHIPX_PLUGIN_DIR . 'app/rest/init-rest.php';

require_once HYPERSHIPX_PLUGIN_DIR . 'app/fbuilder/init-fbuilder.php';







// Register Custom Post Types
function hypershipx_register_post_types() {
    // Register hypership-app post type
    register_post_type('hypership-app', array(
        'labels' => array(
            'name' => 'Apps',
            'singular_name' => 'App',
            'add_new' => 'Add New App',
            'add_new_item' => 'Add New App',
            'edit_item' => 'Edit App',
            'new_item' => 'New App',
            'view_item' => 'View App',
            'search_items' => 'Search Apps',
            'not_found' => 'No apps found',
            'not_found_in_trash' => 'No apps found in Trash'
        ),
        'public' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'apps'),
        'show_in_rest' => true
    ));

    // Register hypership-route post type
    register_post_type('hypership-route', array(
        'labels' => array(
            'name' => 'Routes',
            'singular_name' => 'Route',
            'add_new' => 'Add New Route',
            'add_new_item' => 'Add New Route',
            'edit_item' => 'Edit Route',
            'new_item' => 'New Route',
            'view_item' => 'View Route',
            'search_items' => 'Search Routes',
            'not_found' => 'No routes found',
            'not_found_in_trash' => 'No routes found in Trash'
        ),
        'public' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'routes'),
        'show_in_rest' => true
    ));

    // Register hypership-app-domain post type
    register_post_type('hypership-app-domain', array(
        'labels' => array(
            'name' => 'App Domains',
            'singular_name' => 'App Domain',
            'add_new' => 'Add New Domain',
            'add_new_item' => 'Add New Domain',
            'edit_item' => 'Edit Domain',
            'new_item' => 'New Domain',
            'view_item' => 'View Domain',
            'search_items' => 'Search Domains',
            'not_found' => 'No domains found',
            'not_found_in_trash' => 'No domains found in Trash'
        ),
        'public' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'domains'),
        'show_in_rest' => true
    ));

    // Register hypership-app-frapp post type
    register_post_type('hypership-app-frapp', array(
        'labels' => array(
            'name' => 'App Frapps',
            'singular_name' => 'App Frapp',
            'add_new' => 'Add New Frapp',
            'add_new_item' => 'Add New Frapp',
            'edit_item' => 'Edit Frapp',
            'new_item' => 'New Frapp',
            'view_item' => 'View Frapp',
            'search_items' => 'Search Frapps',
            'not_found' => 'No frapps found',
            'not_found_in_trash' => 'No frapps found in Trash'
        ),
        'public' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'frapps'),
        'show_in_rest' => true
    ));

    // Register hyp-app-registration post type
    register_post_type('hyp-app-registration', array(
        'labels' => array(
            'name' => 'App Registrations',
            'singular_name' => 'App Registration',
            'add_new' => 'Add New Registration',
            'add_new_item' => 'Add New Registration',
            'edit_item' => 'Edit Registration',
            'new_item' => 'New Registration',
            'view_item' => 'View Registration',
            'search_items' => 'Search Registrations',
            'not_found' => 'No registrations found',
            'not_found_in_trash' => 'No registrations found in Trash'
        ),
        'public' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'registrations'),
        'show_in_rest' => true
    ));
}
add_action('init', 'hypershipx_register_post_types');

// Register Custom Fields
function hypershipx_register_custom_fields() {
    // Register fields for hypership-route
    register_post_meta('hypership-route', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));
    register_post_meta('hypership-route', 'domain_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));

    // Register fields for hypership-app-domain
    register_post_meta('hypership-app-domain', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));

    // Register fields for hypership-app-frapp
    register_post_meta('hypership-app-frapp', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));

    // Register fields for hyp-app-registration
    register_post_meta('hyp-app-registration', 'hypership_app', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));
    register_post_meta('hyp-app-registration', 'user', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));
}
add_action('init', 'hypershipx_register_custom_fields');









