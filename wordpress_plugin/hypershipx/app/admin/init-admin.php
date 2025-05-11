<?php

// Hook into admin_menu to add the custom menu
add_action('admin_menu', 'hypershipx__action__register_admin_menu');

function hypershipx__action__register_admin_menu()
{
  // Add top-level menu: HyperShip
  add_menu_page(
    'HyperShip Admin',              // Page title
    'HyperShip',              // Menu title
    'manage_options',         // Capability required
    'hypershipx_adminpage_main',    // Menu slug
    'hypershipx__controller__adminpage_main', // Callback function for the main page
    'dashicons-star-filled',  // Icon (using WordPress dashicon)
    6                         // Menu position
  );

  // Add submenu: Apps (links to the hypership-app post type)
  add_submenu_page(
    'hypershipx_adminpage_main',    // Parent slug
    'Apps',                   // Page title
    'Apps',                   // Menu title
    'manage_options',         // Capability required
    'edit.php?post_type=hypership-app' // Links to the post type admin page
  );

  // Add submenu: App Details (hidden from menu, accessed via button)
  add_submenu_page(
    'hypershipx_adminpage_main',    // Parent slug
    'App Details',            // Page title
    'App Details',            // Menu title (not visible)
    'manage_options',         // Capability required
    'hypershipx_adminpage_appdashboard',  // Menu slug
    'hypershipx__controller__adminpage_appdashboard' // Callback function for the app details page
  );
}







// Callback function for the HyperShip dashboard page
function hypershipx__controller__adminpage_main()
{
  require_once HYPERSHIPX_PLUGIN_DIR . "app/admin/views/view_adminpage_main.php";
}

// Callback function for the App Details page
function hypershipx__controller__adminpage_appdashboard()
{

  $app_id = isset($_GET['app_id']) ? intval($_GET['app_id']) : 0;
  if (!$app_id || get_post_type($app_id) !== 'hypership-app') {
    wp_die('Invalid or missing app ID.');
  }
  $app = get_post($app_id);


  if (isset($_POST['dashboard_datatypes_ok'])) {
    $datatypes_raw = isset($_POST['datatypes']) ? sanitize_textarea_field($_POST['datatypes']) : '';
    $datatypes_lines = array_filter(array_map('trim', explode("\n", $datatypes_raw)));
    $valid_datatypes = [];

    // Verify each post type exists and remove duplicates
    foreach ($datatypes_lines as $post_type) {
        if (post_type_exists($post_type) && !in_array($post_type, $valid_datatypes)) {
            $valid_datatypes[] = $post_type;
        }
    }

    // Save the validated list
    $datatypes_sanitized = implode("\n", $valid_datatypes);
    update_post_meta($app_id, 'hypership_data_types', $datatypes_sanitized);
    wp_redirect(admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . $app_id));
    exit;
  }

  $datatypes_text = get_post_meta($app_id, 'hypership_data_types', true);
  $datatypes = [];
  foreach (explode("\n", $datatypes_text) as $line) {
    $line = trim($line);
    if ($line) {
      $post_type = get_post_type_object($line);
      if ($post_type) {
        // $line = $post_type->labels->singular_name;
      }
      $datatypes[] = $post_type;
    }
  }
  // echo '<pre>';
  // var_dump($datatypes);
  // echo '</pre>';
  // die();

  require_once HYPERSHIPX_PLUGIN_DIR . "app/admin/views/view_adminpage_appdashboard.php";
}

// Add custom column to hypership-app post type admin table
add_filter('manage_hypership-app_posts_columns', 'hypership_app_columns');
function hypership_app_columns($columns)
{
  $columns['details'] = __('Details', 'hypership');
  return $columns;
}

// Populate the custom column with a button
add_action('manage_hypership-app_posts_custom_column', 'hypership_app_custom_column', 10, 2);
function hypership_app_custom_column($column, $post_id)
{
  if ($column === 'details') {
    $url = admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . $post_id);
    printf('<a href="%s" class="button">%s</a>', esc_url($url), __('App Dashboard', 'hypership'));
  }
}


