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





require_once HYPERSHIPX_PLUGIN_DIR . "app/admin/controllers/controller-appdashboard_main.php";


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


