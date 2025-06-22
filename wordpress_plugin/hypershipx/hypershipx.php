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
 * Woo: 12345:342928dfsfhsf2349842374wdf4234sfd
 * WooCommerce: true
 * WooCommerce HPOS: true
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




// Check if running in CLI mode
if (defined('WP_CLI') && WP_CLI) {
    // Load the CLI app
    // require_once plugin_dir_path(__FILE__) . 'cli/cli_app.php';
}


if (defined('WP_CLI') && WP_CLI) {
    class WooCommerceCliCommand extends WP_CLI_Command {
        public function run() {
            require_once plugin_dir_path(__FILE__) . 'cli/cli_app.php';
            $app = new WooCommerceCliApp();
            $app->run();
        }
    }
    WP_CLI::add_command('woo-cli', 'WooCommerceCliCommand');
}



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
            'singular_name' => 'HyperShip App',
            'add_new' => 'Add New HyperShip App',
            'add_new_item' => 'Add New HyperShip App',
            'edit_item' => 'Edit HyperShip App',
            'new_item' => 'New HyperShip App',
            'view_item' => 'View HyperShip App',
            'search_items' => 'Search HyperShip Apps',
            'not_found' => 'No HyperShip Apps found',
            'not_found_in_trash' => 'No HyperShip Apps found in Trash'
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-admin-appearance',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'apps'),
        'show_in_rest' => true
    ));

    // Register hypership-route post type
    register_post_type('hypership-route', array(
        'labels' => array(
            'name' => 'HyperShip Routes',
            'singular_name' => 'HyperShip Route',
            'add_new' => 'Add New HyperShip Route',
            'add_new_item' => 'Add New HyperShip Route',
            'edit_item' => 'Edit HyperShip Route',
            'new_item' => 'New HyperShip Route',
            'view_item' => 'View HyperShip Route',
            'search_items' => 'Search HyperShip Routes',
            'not_found' => 'No HyperShip Routes found',
            'not_found_in_trash' => 'No HyperShip Routes found in Trash'
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-admin-links',
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'routes'),
        'show_in_rest' => true
    ));

    // Register hypership-app-domain post type
    register_post_type('hypership-domain', array(
        'labels' => array(
            'name' => 'HyperShip App Domains',
            'singular_name' => 'HyperShip App Domain',
            'add_new' => 'Add New HyperShip App Domain',
            'add_new_item' => 'Add New HyperShip App Domain',
            'edit_item' => 'Edit HyperShip App Domain',
            'new_item' => 'New HyperShip App Domain',
            'view_item' => 'View HyperShip App Domain',
            'search_items' => 'Search Domains',
            'not_found' => 'No HyperShip App Domains found',
            'not_found_in_trash' => 'No HyperShip App Domains found in Trash'
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 22,
        'menu_icon' => 'dashicons-admin-site',
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'domains'),
        'show_in_rest' => true
    ));

    // Register hypership-app-frapp post type
    register_post_type('hypership-frapp', array(
        'labels' => array(
            'name' => 'HypShip Frontend App',
            'singular_name' => 'HypShip Frontend App',
            'add_new' => 'Add New HypShip Frontend App',
            'add_new_item' => 'Add New HypShip Frontend App',
            'edit_item' => 'Edit HypShip Frontend App',
            'new_item' => 'New HypShip Frontend App',
            'view_item' => 'View HypShip Frontend App',
            'search_items' => 'Search HypShip Frontend Apps',
            'not_found' => 'No HypShip Frontend Apps found',
            'not_found_in_trash' => 'No HypShip Frontend Apps found in Trash'
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 23,
        'menu_icon' => 'dashicons-admin-generic',
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'hypership-frapps'),
        'show_in_rest' => true
    ));

    // Register hyp-app-registration post type
    register_post_type('hyp-app-registration', array(
        'labels' => array(
            'name' => 'HypShip App Registrations',
            'singular_name' => 'HypShip App Registration',
            'add_new' => 'Add New HypShip App Registration',
            'add_new_item' => 'Add New HypShip App Registration',
            'edit_item' => 'Edit HypShip App Registration',
            'new_item' => 'New HypShip App Registration',
            'view_item' => 'View HypShip App Registration',
            'search_items' => 'Search HypShip App Registrations',
            'not_found' => 'No HypShip App Registrations found',
            'not_found_in_trash' => 'No HypShip App Registrations found in Trash'
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 24,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => array('title', 'editor'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'hyp-app-registrations'),
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
        'sanitize_callback' => 'absint',
        'description' => 'The parent HyperShip App ID this route belongs to'
    ));
    register_post_meta('hypership-route', 'domain_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));

    // Register fields for hypership-app-domain
    register_post_meta('hypership-domain', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));

    // Register fields for hypership-app-frapp
    register_post_meta('hypership-frapp', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'description' => 'The parent HyperShip App ID this frontend app belongs to'
    ));

    // Register fields for hyp-app-registration
    register_post_meta('hyp-app-registration', 'app_parent', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint',
        'description' => 'The parent HyperShip App ID this registration belongs to'
    ));
    register_post_meta('hyp-app-registration', 'user', array(
        'type' => 'integer',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'absint'
    ));
}
add_action('init', 'hypershipx_register_custom_fields');









