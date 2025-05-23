<?php



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




  // routes

  if (isset($_POST['create_route']) && isset($_POST['route_nonce']) && wp_verify_nonce($_POST['route_nonce'], 'create_route_nonce')) {
    $route_title = sanitize_text_field($_POST['route_title']);
    $route_path = sanitize_text_field($_POST['route_path']);
    $app_parent = intval($_POST['app_parent']);

    // Create new route post
    $route_post = array(
      'post_title' => $route_title,
      'post_name' => $route_path,
      'post_status' => 'publish',
      'post_type' => 'hypership-route'
    );

    $route_id = wp_insert_post($route_post);

    if (!is_wp_error($route_id)) {
      // Set the app parent relationship
      update_post_meta($route_id, 'app_parent', $app_parent);

      // Redirect back to dashboard
      wp_redirect(admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . $app_parent));
      exit;
    }
  }
  if (isset($_POST['dashboard_routes_ok'])) {
  }


  // data types

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

  require_once HYPERSHIPX_PLUGIN_DIR . "app/admin/views/view-appdashboard-main.php";
}



function hypershipx_adminpage_frontendapp_builder()
{
  // Check user capabilities
  if (!current_user_can('manage_options')) {
    return;
  }

  // Get app ID from URL if set
  $app_id = isset($_GET['app_id']) ? intval($_GET['app_id']) : 0;
  if (!$app_id) {
    // wp_die(__('Invalid app ID', 'hypershipx'));
  }

  // Handle form submissions
  if (isset($_POST['fbuilder_save'])) {
    $app_config = isset($_POST['app_config']) ? sanitize_textarea_field($_POST['app_config']) : '';
    update_post_meta($app_id, 'hypership_fbuilder_config', $app_config);

    wp_redirect(admin_url('admin.php?page=hypershipx_adminpage_frontendapp_builder&app_id=' . $app_id));
    exit;
  }

  // Get saved configuration
  $app_config = get_post_meta($app_id, 'hypership_fbuilder_config', true);

  // Load the view
  // require_once HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/view_adminpage_fbuilder.php';
  require_once HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/view_adminpage_frapp_builder.php';
}

// Register the admin page
add_action('admin_menu', function () {
  add_submenu_page(
    'hypershipx_adminpage_main',
    __('Frontend App Builder', 'hypershipx'),
    __('Frontend Builder', 'hypershipx'),
    'manage_options',
    'hypershipx_adminpage_frontendapp_builder',
    'hypershipx_adminpage_frontendapp_builder'
  );


});




