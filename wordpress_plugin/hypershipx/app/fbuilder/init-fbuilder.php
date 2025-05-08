<?php


// Prevent direct access to this file
if (!defined('ABSPATH')) {
  exit;
}


// 'HyperShip Admin',              // Page title
// 'HyperShip',              // Menu title
// 'manage_options',         // Capability required
// 'hypershipx_adminpage_main',    // Menu slug
// 'hypershipx__controller__adminpage_main', // Callback function for the main page
// 'dashicons-star-filled',  // Icon (using WordPress dashicon)
// 6                         // Menu position


function hypershipx__action__register_admin_page_fbuilder()
{
  // Add submenu: Apps (links to the hypership-app post type)
  add_submenu_page(
    'hypershipx_adminpage_main',    // Parent slug
    'FBuilder',                   // Page title
    'FBuilder',                   // Menu title
    'manage_options',         // Capability required
    'hypershipx_adminpage_fbuilder',// 'edit.php?post_type=hypership-app', // Links to the post type admin page
    'hypershipx__controller__adminpage_fbuilder',
  );

}


// Hook to add admin menu
add_action('admin_menu', 'hypershipx__action__register_admin_page_fbuilder');



// function hypershipx__action__register_admin_page_fbuilder()
// {
//   // Add a top-level menu page
//   add_menu_page(
//     'Function Builder',           // Page title
//     'Function Builder',                // Menu title
//     'manage_options',             // Capability required
//     'hypershipx_adminpage_fbuilder',          // Menu slug
//     'hypershipx__controller__adminpage_fbuilder',      // Callback function to render page
//     'dashicons-admin-generic',    // Icon
//     80                            // Position
//   );
// }

// Callback to render the admin page
function hypershipx__controller__adminpage_fbuilder()
{
  ?>


  <!-- Load Blockly core -->
  <script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/blockly_compressed.js"></script>
  <!-- Load the default blocks -->
  <script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/blocks_compressed.js"></script>
  <!-- Load a generator -->
  <script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/javascript_compressed.js"></script>
  <!-- Load a message file -->
  <script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/msg/en.js"></script>


  <style>
    #blocklyDiv {
      border: 1px solid black;
      margin: 33px;
    }
  </style>




  <div class="wrap">
    <h1>Custom Admin Page</h1>
    <p>Welcome to your custom admin page!</p>


    <div id="blocklyDiv" style="height: 480px; width: 600px;"></div>



    <!-- Custom HTML -->
    <div id="custom-content">
      <h2>Interactive Section</h2>
      <p>Click the button below to see a message.</p>
      <button id="custom-button" class="button button-primary">Click Me!</button>
      <div id="message-container"></div>
    </div>
  </div>




  <script>


    // Blockly.common.defineBlocksWithJsonArray([{
    //   "type": "string_length",
    //   "message0": 'length of %1',
    //   "args0": [
    //     {
    //       "type": "input_value",
    //       "name": "VALUE",
    //       "check": "String"
    //     }
    //   ],
    //   "output": "Number",
    //   "colour": 160,
    //   "tooltip": "Returns number of letters in the provided text.",
    //   "helpUrl": "http://www.w3schools.com/jsref/jsref_length_string.asp"
    // }]);




    const toolbox = {
      // There are two kinds of toolboxes. The simpler one is a flyout toolbox.
      kind: 'flyoutToolbox',
      // The contents is the blocks and other items that exist in your toolbox.
      contents: [
        {
          kind: 'block',
          type: 'controls_if'
        },
        {
          kind: 'block',
          type: 'controls_whileUntil'
        }
        // You can add more blocks to this array.
      ]
    };

    // The toolbox gets passed to the configuration struct during injection.
    const workspace = Blockly.inject('blocklyDiv', { toolbox: toolbox });


    // // Create the definition.
    // const definitions = Blockly.createBlockDefinitionsFromJsonArray([
    //   {
    //     // The type is like the "class name" for your block. It is used to construct
    //     // new instances. E.g. in the toolbox.
    //     type: 'my_custom_block',
    //     // The message defines the basic text of your block, and where inputs or
    //     // fields will be inserted.
    //     message0: 'move forward %1',
    //     args0: [
    //       // Each arg is associated with a %# in the message.
    //       // This one gets substituted for %1.
    //       {
    //         // The type specifies the kind of input or field to be inserted.
    //         type: 'field_number',
    //         // The name allows you to reference the field and get its value.
    //         name: 'FIELD_NAME',
    //       }
    //     ],
    //     // Adds an untyped previous connection to the top of the block.
    //     previousStatement: null,
    //     // Adds an untyped next connection to the bottom of the block.
    //     nextStatement: null,
    //   }
    // ]);

    // Register the definition.
    // Blockly.defineBlocks(definitions);


    // // Passes the ID.
    // const workspace = Blockly.inject('blocklyDiv', { /* config */ });

    // // Passes the injection div.
    // const workspace = Blockly.inject(
    //   document.getElementById('blocklyDiv'), { /* config */ });
  </script>



  <?php
}

// Hook to enqueue scripts and styles
add_action('admin_enqueue_scripts', 'cap_enqueue_admin_assets');

function cap_enqueue_admin_assets($hook)
{
  // Only load scripts/styles on our custom admin page
  if ($hook !== 'toplevel_page_hypershipx_adminpage_fbuilder') {
    return;
  }

  // Enqueue custom CSS
  wp_enqueue_style(
    'cap-admin-style',
    plugin_dir_url(__FILE__) . 'css/cap-admin.css',
    array(),
    '1.0'
  );

  // Enqueue custom JavaScript
  wp_enqueue_script(
    'cap-admin-script',
    plugin_dir_url(__FILE__) . 'js/cap-admin.js',
    array('jquery'),
    '1.0',
    true
  );

  // Localize script to pass data to JavaScript
  wp_localize_script(
    'cap-admin-script',
    'capData',
    array(
      'ajax_url' => admin_url('ajax.php'),
      'nonce' => wp_create_nonce('cap_nonce')
    )
  );
}



