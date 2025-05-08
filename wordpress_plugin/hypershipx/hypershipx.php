<?php
/**
 * Plugin Name: HyperShipX
 * Plugin URI: https://example.com/hypershipx
 * Description: A WordPress plugin to connect external apps to WooCommerce sites via REST API, providing authentication, CRUD, and e-commerce functionality.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL-2.0+
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

// Include the loader
// require_once HYPERSHIPX_PLUGIN_DIR . 'includes/class-hypershipx-loader.php';

// require_once HYPERSHIPX_PLUGIN_DIR . 'includes/class-hypershipx-app.php';


$__HYPERSHIPX_APPS = [];
// define('__HYPERSHIPX_APPS', []);

//
// require_once HYPERSHIPX_PLUGIN_DIR . 'myapps/myapps-init.php';


// Initialize the plugin
add_action('plugins_loaded', function () {
    // Check for WooCommerce dependency
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>' . esc_html__('HyperShipX requires WooCommerce to be installed and active.', 'hypershipx') . '</p></div>';
        });
        return;
    }

    require_once HYPERSHIPX_PLUGIN_DIR . 'myapps/myapps-init.php';




});

// Activation hook
register_activation_hook(__FILE__, function () {
    // Generate API key if not exists
    if (!get_option('hypershipx_api_key')) {
        update_option('hypershipx_api_key', wp_generate_password(32, false));
    }
});

// Deactivation hook
register_deactivation_hook(__FILE__, function () {
    // Clean up if needed
});












// Hook into admin_menu to add the custom menu
add_action('admin_menu', 'hypership_register_admin_menu');

function hypership_register_admin_menu() {
    // Add top-level menu: HyperShip
    add_menu_page(
        'HyperShip',              // Page title
        'HyperShip',              // Menu title
        'manage_options',         // Capability required
        'hypership-dashboard',    // Menu slug
        'hypership_dashboard_page', // Callback function for the main page
        'dashicons-star-filled',  // Icon (using WordPress dashicon)
        6                         // Menu position
    );

    // Add submenu: Apps (links to the hypership-app post type)
    add_submenu_page(
        'hypership-dashboard',    // Parent slug
        'Apps',                   // Page title
        'Apps',                   // Menu title
        'manage_options',         // Capability required
        'edit.php?post_type=hypership-app' // Links to the post type admin page
    );

    // Add submenu: App Details (hidden from menu, accessed via button)
    add_submenu_page(
        'hypership-dashboard',    // Parent slug
        'App Details',            // Page title
        'App Details',            // Menu title (not visible)
        'manage_options',         // Capability required
        'hypership-app-details',  // Menu slug
        'hypershipx_app_dashboard_page' // Callback function for the app details page
    );
}

// Callback function for the HyperShip dashboard page
function hypership_dashboard_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p>Welcome to the HyperShip Dashboard. Manage your apps from the <a href="<?php echo admin_url('edit.php?post_type=hypership-app'); ?>">Apps</a> page.</p>
    </div>
    <?php
}

// Callback function for the App Details page
function hypershipx_app_dashboard_page() {
    $app_id = isset($_GET['app_id']) ? intval($_GET['app_id']) : 0;
    if (!$app_id || get_post_type($app_id) !== 'hypership-app') {
        wp_die('Invalid or missing app ID.');
    }
    $app = get_post($app_id);
    ?>
    <div class="wrap">
        <h1>App Dashboard: <?php echo esc_html($app->post_title); ?></h1>
        <p><a href="<?php echo admin_url('edit.php?post_type=hypership-app'); ?>" class="button">Back to Apps</a></p>

        <style>
            .hypership-dashboard {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }
            .hypership-card {
                background: #fff;
                border: 1px solid #c3c4c7;
                border-radius: 4px;
                padding: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .hypership-card h2 {
                margin: 0 0 15px;
                font-size: 18px;
                color: #1d2327;
            }
            .hypership-card p {
                margin: 0 0 10px;
                color: #3c434a;
            }
            .hypership-card .status {
                font-weight: bold;
                color: #007cba;
            }
            .hypership-card .status.warning {
                color: #d63638;
            }
        </style>

        <div class="hypership-dashboard">

          <?php
          $tf = HYPERSHIPX_PLUGIN_DIR . "myapps/" . $app->post_name . "/includes/hook__app_dashboard_page__before.php";
          if (is_file($tf)) {
              require_once $tf;
          }
          ?>




            <!-- Users Section -->
            <div class="hypership-card">
                <h2>Users</h2>

                <?php
                $tf = HYPERSHIPX_PLUGIN_DIR . "myapps/" . $app->post_name . "/includes/hook__app_dashboard_page__card_users__before.php";
                if (is_file($tf)) {
                    require_once $tf;
                }
                ?>

                <div style="xxbackground-color: #999;">
                  <p>Total Users: <span class="status"><?php echo esc_html(get_post_meta($app_id, 'total_users', true) ?: '0'); ?></span></p>
                  <p>Active Users (Last 30 Days): <?php echo esc_html(get_post_meta($app_id, 'active_users', true) ?: '0'); ?></p>
                  <p>New Registrations: <?php echo esc_html(get_post_meta($app_id, 'new_users', true) ?: '0'); ?></p>

                </div>


                <div style="border: 1px solid black; margin-bottom: 11px;">


                <h4>App User Registrations</h4>
                <?php

                // update_post_meta($app_id, 'users_json', json_encode([]));


                $tappinfo = hypershipx_helper_app_get_info($app_id);
                // var_dump($tappinfo['data']);


                // // Get existing users list from post meta
                // $tusers = json_decode( get_post_meta($app_id, 'users_json', true) );
                // // $tusers = get_field( "users", $app_id );
                // if (!is_array($tusers)) {
                //   $tusers = [];
                // }
                // $wp_users = get_users(['include' => $tusers]);
                foreach ([
                  [
                    'id' => 1,
                    'username' => "user1",
                    'email' => "user1@test.com",
                    'created_at' => "2025-03-03 00:00:00",
                  ],
                  [
                    'id' => 2,
                    'username' => "user7",
                    'email' => "user7@test.com",
                    'created_at' => "2025-03-03 00:00:00",
                  ],
                ] as $titem) { // ($tappinfo['data']['registrations'] as $titem) {
                  // var_dump($titem);
                    ?>
                    <div style="border: 0px solid black; margin-bottom: 11px;">

                      <div>
                        <strong>
                          <?php echo esc_html($titem['username']); ?>
                        </strong>
                      </div>
                      <!-- <div><?php //echo esc_html($titem['email']); ?></div> -->
                      <div>
                        Points: 33
                      </div>
                      <div>
                        <a href="#">Deactivate</a>
                        \
                        <a href="/wp-admin/post.php?post=<?php echo $titem['id']; ?>&action=edit">Edit</a>
                        \
                        <a href="#">Send notice</a>
                      </div>
                      <div><?php //echo esc_html($user->user_email); ?></div>
                      <div><?php //echo esc_html($user->display_name); ?></div>
                    </div>
                    <?php
                }
                // var_dump($tusers);//die();
                ?>

</div>
                <?php
                $tf = HYPERSHIPX_PLUGIN_DIR . "myapps/" . $app->post_name . "/includes/hook__app_dashboard_page__card_users__after.php";
                if (is_file($tf)) {
                    require_once $tf;
                }
                ?>


            </div>


            <!-- Events Section -->
            <div class="hypership-card">
                <h2>Events</h2>

                <div style="border: 0px solid black;">
                  <strong>Past Events</strong>
                  <div>Total: 11</div>
                  <div>Attendees: 33</div>
                  <div>Revenue: $333</div>
                </div>
                <div style="border: 0px solid black;">
                  <strong>Coming Events</strong>
                  <div>Attendees: 33 (15 not sold yet)</div>
                  <div>Total: 33</div>
                </div>
            </div>



            <!-- Mutiplayer Section -->
            <div class="hypership-card">
                <h2>Mutiplayer</h2>

                <div style="border: 0px solid black;">
                  <strong>Rooms</strong>
                  <div>Total: 11</div>
                  <div>Attendees: 33</div>
                  <div>Revenue: $333</div>
                </div>
            </div>


            <!-- Monetization & Ecommerce Section -->
            <div class="hypership-card">
                <h2>Monetization & Ecommerce</h2>
                <p>Total Revenue: <span class="status"><?php echo esc_html(get_post_meta($app_id, 'total_revenue', true) ?: '$0.00'); ?></span></p>
                <p>Total Orders: <?php echo esc_html(get_post_meta($app_id, 'total_orders', true) ?: '0'); ?></p>
                <p>Average Order Value: <?php echo esc_html(get_post_meta($app_id, 'avg_order_value', true) ?: '$0.00'); ?></p>
            </div>




            <!-- Data Types Section -->
            <div class="hypership-card">
                <h2>Data Types</h2>

                <div style="border: 0px solid black;">
                  <strong>Piano Lesson</strong>
                  <div>Total: 11</div>
                </div>
                <div style="border: 0px solid black;">
                  <strong>Piano Lesson Recording</strong>
                  <div>Total: 33</div>
                </div>
                <!-- <p>Piano Lesson: <span class="status"> dd</span></p> -->
                <!-- <p>Piano Lesson: <span class="status"><?php echo esc_html(get_post_meta($app_id, 'total_revenue', true) ?: '$0.00'); ?></span></p> -->
                <!-- <p>Total Orders: <?php echo esc_html(get_post_meta($app_id, 'total_orders', true) ?: '0'); ?></p> -->
                <!-- <p>Average Order Value: <?php echo esc_html(get_post_meta($app_id, 'avg_order_value', true) ?: '$0.00'); ?></p> -->
            </div>



            <!-- Monetization & Ecommerce Section -->
            <div class="hypership-card">
                <h2>Monetization & Ecommerce</h2>
                <p>Total Revenue: <span class="status"><?php echo esc_html(get_post_meta($app_id, 'total_revenue', true) ?: '$0.00'); ?></span></p>
                <p>Total Orders: <?php echo esc_html(get_post_meta($app_id, 'total_orders', true) ?: '0'); ?></p>
                <p>Average Order Value: <?php echo esc_html(get_post_meta($app_id, 'avg_order_value', true) ?: '$0.00'); ?></p>
            </div>
            <!-- Security Section -->
            <div class="hypership-card">
                <h2>Security</h2>
                <p>API Rate Limiting: Off <button>Edit</button></p>
                <p>Last Security Scan: <?php echo esc_html(get_post_meta($app_id, 'last_scan', true) ?: 'Never'); ?></p>

                <p>Security Status: <span class="status <?php echo esc_attr(get_post_meta($app_id, 'security_status', true) === 'issues' ? 'warning' : ''); ?>">
                    <?php echo esc_html(get_post_meta($app_id, 'security_status', true) ?: 'Secure'); ?>
                </span></p>
                <p>Last Security Scan: <?php echo esc_html(get_post_meta($app_id, 'last_scan', true) ?: 'Never'); ?></p>
                <p>Two-Factor Authentication: <?php echo esc_html(get_post_meta($app_id, '2fa_enabled', true) ? 'Enabled' : 'Disabled'); ?></p>
            </div>

            <!-- Gamification Section -->
            <div class="hypership-card">
                <h2>Gamification</h2>
                <p>Points Awarded: <?php echo esc_html(get_post_meta($app_id, 'points_awarded', true) ?: '0'); ?></p>
                <p>Badges Unlocked: <?php echo esc_html(get_post_meta($app_id, 'badges_unlocked', true) ?: '0'); ?></p>
                <p>Active Challenges: <?php echo esc_html(get_post_meta($app_id, 'active_challenges', true) ?: '0'); ?></p>
            </div>

            <!-- Analytics Section -->
            <div class="hypership-card">
                <h2>Analytics</h2>
                <p>Page Views (Last 30 Days): <?php echo esc_html(get_post_meta($app_id, 'page_views', true) ?: '0'); ?></p>
                <p>Average Session Duration: <?php echo esc_html(get_post_meta($app_id, 'session_duration', true) ?: '0 min'); ?></p>
                <p>Bounce Rate: <?php echo esc_html(get_post_meta($app_id, 'bounce_rate', true) ?: '0%'); ?></p>
            </div>

            <!-- Settings Section -->
            <div class="hypership-card">
                <h2>Settings</h2>
                <p>App Status: <span class="status"><?php echo esc_html(get_post_status($app_id) === 'publish' ? 'Active' : 'Inactive'); ?></span></p>
                <p>Last Updated: <?php echo esc_html(get_post_modified_time('F j, Y', false, $app_id)); ?></p>
                <p><a href="<?php echo get_edit_post_link($app_id); ?>">Edit App Settings</a></p>

                <div style="background-color: #ededed;">
                <div>Routes:</div>
                <div style="font-weight: bold;">
                  /wp-json/v1/hypershipx/<?php echo $app->post_name ?>
                </div>
                <br>
                <div>/login_email_password</div>
                <div>/register</div>
                <div>/logout</div>
                <div>/post_list</div>
                <div>/ecommerce_ai_recommendations</div>
                <div>/ecommerce_product_list</div>
                <div>/ecommerce_orders</div>
                <div>/ecommerce_order</div>
                <div>/ecommerce_order_add_product</div>
                <div>/ecommerce_order_checkout</div>
                <div>/events_get_list</div>
                <div>/events_register_attend</div>
                <div>/security_turn_all_off</div>
                </div>




            </div>
        </div>
    </div>
    <?php
}

// Add custom column to hypership-app post type admin table
add_filter('manage_hypership-app_posts_columns', 'hypership_app_columns');
function hypership_app_columns($columns) {
    $columns['details'] = __('Details', 'hypership');
    return $columns;
}

// Populate the custom column with a button
add_action('manage_hypership-app_posts_custom_column', 'hypership_app_custom_column', 10, 2);
function hypership_app_custom_column($column, $post_id) {
    if ($column === 'details') {
        $url = admin_url('admin.php?page=hypership-app-details&app_id=' . $post_id);
        printf('<a href="%s" class="button">%s</a>', esc_url($url), __('App Dashboard', 'hypership'));
    }
}







// add_action( 'rest_api_init', function () {
//   // register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', array(
//   //   'methods' => 'GET',
//   //   'callback' => 'my_awesome_func',
//   // ) );
// } );

add_action('rest_api_init', 'hypershipx_register_rest_routes');

function hypershipx_register_rest_routes() {


  // // get hypership app posts
  // $args = array(
  //   'numberposts' => 100,
  //   'post_type'   => 'hypership-app'
  // );
  // $tapps = get_posts($args);
  // // var_dump($tapps);
  // foreach ($tapps as $tapp) {
  // }


  register_rest_route('hypershipx/v1', '/(?P<appslug>[a-zA-Z0-9-]+)/auth/register', [
  // register_rest_route('hypershipx/v1', '/auth/register', [
    'methods' => 'POST',
    'callback' => 'hypershipx_routehandler_auth_register',
    'permission_callback' => '__return_true', // Allow public access; adjust for security if needed
    'args' => [
      'appslug' => [
          'required' => true,
          'validate_callback' => 'validate_appslug',
          'sanitize_callback' => 'sanitize_text_field',
      ],
      'email' => [
          'required' => true,
          'validate_callback' => 'is_email',
          'sanitize_callback' => 'sanitize_email',
      ],
      'username' => [
          'required' => true,
          'sanitize_callback' => 'sanitize_user',
      ],
      'password' => [
          'required' => true,
          'sanitize_callback' => 'sanitize_text_field',
      ],
    ],
  ]);

  function validate_appslug($value, $request, $param) {
    $post = get_posts([
        'post_type' => 'hypership-app',
        'post_status' => 'publish',
        'name' => $value,
        'numberposts' => 1,
    ]);
    return !empty($post);
}




}


// Handle user registration and add to post's Users list
function hypershipx_routehandler_auth_register(WP_REST_Request $request) {

  $appslug = $request->get_param('appslug');
  $email = $request->get_param('email');
  $username = $request->get_param('username');
  $password = $request->get_param('password');

  // Get the app post by slug
  $app = get_posts([
      'post_type' => 'hypership-app',
      'post_status' => 'publish',
      'name' => $appslug,
      'numberposts' => 1,
  ]);

  if (empty($app)) {
      return new WP_Error(
          'invalid_appslug',
          'Invalid app slug provided.',
          ['status' => 404]
      );
  }
  $app_id = $app[0]->ID;

  // Register the user
  $user_id = wp_insert_user([
      'user_login' => $username,
      'user_email' => $email,
      'user_pass' => $password,
      'role' => 'customer',
  ]);

  if (is_wp_error($user_id)) {
      return new WP_Error(
          'user_creation_failed',
          $user_id->get_error_message(),
          ['status' => 400]
      );
  }

  // Get existing users list from post meta
  $users = json_decode( get_post_meta($app_id, 'users_json', true) );
  // $users = get_field( "users", $app_id );
  if (!is_array($users)) {
    $users = [];
  }
  // var_dump($users);die();

  // Add new user ID to the list if not already present
  if (!in_array($user_id, $users)) {
      $users[$user_id] = [
        'created_at' => date('Y-m-d H:i:s'),
      ];
      update_post_meta($app_id, 'users_json', json_encode($users));
  }

  return new WP_REST_Response([
      'success' => true,
      'user_id' => $user_id,
      'app_id' => $app_id,
      'message' => 'User registered and added to app users list.',
  ], 201);
}


function hypershipx_helper_app_get_info($app_id) {
  $post = get_post($app_id);
  $data = [
    'registrations' => get_post_meta($app_id, 'registrations')
  ];
  $rett = [
    'post' => $post,
    'data' => $data,
  ];
  return $rett;
}


