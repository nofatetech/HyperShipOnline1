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
















