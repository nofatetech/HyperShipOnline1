<?php


// Prevent direct access to this file
if (!defined('ABSPATH')) {
  exit;
}


function hypershipx__action__register_admin_page_fbuilder()
{
  // Add submenu: Apps (links to the hypership-app post type)
  add_submenu_page(
    'hypershipx_adminpage_main',    // Parent slug
    'Route Builder',                   // Page title
    'Route Builder',                   // Menu title
    'manage_options',         // Capability required
    'hypershipx_adminpage_fbuilder',// 'edit.php?post_type=hypership-app', // Links to the post type admin page
    'hypershipx__controller__adminpage_fbuilder',
  );

}


// Hook to add admin menu
add_action('admin_menu', 'hypershipx__action__register_admin_page_fbuilder');



// Callback to render the page
function hypershipx__controller__adminpage_fbuilder()
{

  $route_id = isset($_GET['route_id']) ? intval($_GET['route_id']) : 0;
  if (!$route_id || get_post_type($route_id) !== 'hypership-route') {
    wp_die('Invalid or missing route_id.');
  }
  $route = get_post($route_id);

  function sanitizeCode($code)
  {
    $sanitized_code = str_replace('', '', $code);
    // $sanitized_code = str_replace('<? php', '', $code);
    // $sanitized_code = str_replace('? >', '', $sanitized_code);
    return $sanitized_code;
  }

  // POST
  if (isset($_POST['workspaceState'])) {
    $sanitized_code = sanitizeCode($_POST['workspaceState']);
    update_post_meta($route_id, 'workspaceState', $sanitized_code);
  }
  if (isset($_POST['code'])) {
    $sanitized_code = sanitizeCode($_POST['code']);
    update_post_meta($route_id, 'generatedCode', $sanitized_code);
  }
  if (isset($_POST['customCode'])) {
    $sanitized_custom_code = sanitize_textarea_field($_POST['customCode']);
    update_post_meta($route_id, 'customCode', $sanitized_custom_code);
  }

  if (isset($_POST['customCodeGet'])) {
    $sanitized_custom_code_get = sanitize_textarea_field($_POST['customCodeGet']);
    update_post_meta($route_id, 'customCodeGet', $sanitized_custom_code_get);
  }
  if (isset($_POST['customCodePost'])) {
    $sanitized_custom_code_post = sanitize_textarea_field($_POST['customCodePost']);
    update_post_meta($route_id, 'customCodePost', $sanitized_custom_code_post);
  }




  $route_id = isset($_GET['route_id']) ? intval($_GET['route_id']) : 0;
  if (!$route_id || get_post_type($route_id) !== 'hypership-route') {
    wp_die('Invalid or missing route_id.');
  }
  $troute = get_post($route_id);

  require_once HYPERSHIPX_PLUGIN_DIR . 'app/fbuilder/views/view_adminpage_fbuilder.php';

}

// // Hook to enqueue scripts and styles
// add_action('admin_enqueue_scripts', 'cap_enqueue_admin_assets');

// function cap_enqueue_admin_assets($hook)
// {
//   // Only load scripts/styles on our custom admin page
//   if ($hook !== 'toplevel_page_hypershipx_adminpage_fbuilder') {
//     return;
//   }

//   // Enqueue custom CSS
//   wp_enqueue_style(
//     'cap-admin-style',
//     plugin_dir_url(__FILE__) . 'css/cap-admin.css',
//     array(),
//     '1.0'
//   );

//   // Enqueue custom JavaScript
//   wp_enqueue_script(
//     'cap-admin-script',
//     plugin_dir_url(__FILE__) . 'js/cap-admin.js',
//     array('jquery'),
//     '1.0',
//     true
//   );

//   // Localize script to pass data to JavaScript
//   wp_localize_script(
//     'cap-admin-script',
//     'capData',
//     array(
//       'ajax_url' => admin_url('ajax.php'),
//       'nonce' => wp_create_nonce('cap_nonce')
//     )
//   );
// }






// Hook to enqueue scripts and styles
add_action('admin_enqueue_scripts', 'hypershipx_enqueue_codemirror_assets');

function hypershipx_enqueue_codemirror_assets($hook)
{
  // Only load scripts/styles on our custom admin page
  if ($hook !== 'toplevel_page_hypershipx_adminpage_fbuilder') {
    return;
  }

  // Enqueue CodeMirror CSS
  wp_enqueue_style(
    'codemirror-style',
    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css'
  );

  // Enqueue CodeMirror JavaScript
  wp_enqueue_script(
    'codemirror-script',
    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js',
    array(),
    null,
    true
  );

  // Enqueue CodeMirror mode for PHP
  wp_enqueue_script(
    'codemirror-mode-php',
    'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/php/php.min.js',
    array('codemirror-script'),
    null,
    true
  );
}


