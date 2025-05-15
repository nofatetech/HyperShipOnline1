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


