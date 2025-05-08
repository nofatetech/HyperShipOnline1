<!-- Load Blockly core -->
<script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/blockly_compressed.js"></script>
<!-- Load the default blocks -->
<script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/blocks_compressed.js"></script>
<!-- Load a generator -->
<script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/javascript_compressed.js"></script>
<!-- Load a message file -->
<script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/msg/en.js"></script>


<!-- Load Blockly core -->
<!-- <script src="https://unpkg.com/blockly/blockly.min.js"></script> -->
<!-- Load PHP code generator -->
<!-- <script src="https://unpkg.com/blockly/php_compressed.js"></script> -->
<script src="<?php echo HYPERSHIPX_PLUGIN_URL; ?>app/fbuilder/blockly/php_compressed.js"></script>



<style>
  #blocklyDiv {
    border: 1px solid black;
    /* margin: 33px; */
    height: 480px;
    /* width: 600px; */
    width: 100%;
  }
</style>




<div class="wrap">
  <h1>HyperShip Route Builder</h1>
  <!-- <p>ID: <?php echo $troute->ID; ?></p> -->
  <!-- <div>
    <p>workspaceState:
      <br>
      <code>
      <?php $workspaceState = get_post_meta($troute->ID, 'workspaceState', true);
      echo $workspaceState; ?>
    </code>
      <br>

  </div> -->

  <!-- <div>
    <div>code:</div>
    <div>
      <code>
      <?php $code = get_post_meta($troute->ID, 'generatedCode', true);
      echo $code; ?>
    </code>
    </div>
  </div> -->



  <!-- Form to submit the generated code -->
  <div class="controls">
    <div class="controls-wrapper">


      <div id="blocklyDiv" style=""></div>


      <div class="button-group">
        <button type="button" class="button button-primary" onclick="generateCode()">
          <span class="dashicons dashicons-code-standards"></span>
          Generate Code
        </button>
      </div>

      <form id="codeForm" action="" method="POST" class="code-form">
        <div class="form-group">
          <label for="generatedCode">Generated Code</label>
          <?php
          $code = get_post_meta($troute->ID, 'generatedCode', true);
          ?>
          <input type="text" id="generatedCode" name="code" value="<?php echo esc_attr($code); ?>" class="regular-text"
            readonly>
        </div>

        <div class="form-group">
          <?php
          $workspaceState = get_post_meta($troute->ID, 'workspaceState', true);
          ?>
          <label for="workspaceState">Workspace State</label>
          <input type="text" id="workspaceState" name="workspaceState" value="<?php echo esc_attr($workspaceState); ?>"
            class="regular-text" readonly>
        </div>

        <div class="form-group">
          <label for="customCode">Custom Code</label>
          <textarea id="customCode" name="customCode" rows="10" class="large-text code"
            placeholder="Enter custom code here..."><?php
            $customCode = get_post_meta($troute->ID, 'customCode', true);
            echo esc_textarea($customCode); ?></textarea>
        </div>

        <div class="form-group">
          <button type="submit" class="button button-primary">
            <span class="dashicons dashicons-saved"></span>
            Save Changes
          </button>
        </div>
      </form>
    </div>

    <style>
      .controls-wrapper {
        margin-top: 20px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ccd0d4;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
      }

      .button-group {
        margin-bottom: 20px;
      }

      .code-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
      }

      .form-group label {
        font-weight: 600;
      }

      .form-group input[type="text"] {
        background: #f0f0f1;
      }

      .form-group textarea {
        font-family: monospace;
        background: #f6f7f7;
      }

      .button {
        display: inline-flex;
        align-items: center;
        gap: 5px;
      }

      .dashicons {
        font-size: 16px;
        width: 16px;
        height: 16px;
      }
    </style>
  </div>


  <!-- Custom HTML -->
  <!-- <div id="custom-content">
      <h2>Interactive Section</h2>
      <p>Click the button below to see a message.</p>
      <button id="custom-button" class="button button-primary">Click Me!</button>
      <div id="message-container"></div>
    </div> -->


</div>




<script>


  // // Passes the ID.
  // const workspace = Blockly.inject('blocklyDiv', { /* config */ });

  // // Passes the injection div.
  // const workspace = Blockly.inject(
  //   document.getElementById('blocklyDiv'), { /* config */ });


  // 1. Block Definition
  // Potential WordPress block ideas:
  // - Query Posts (by category, tag, author, date)
  // - Get Post Meta
  // - Get Option (wp_options)
  // - Get Term (taxonomy terms)
  // - Get Menu Items
  // - Get Widget Areas
  // - Get Sidebar
  // - Get Template Part
  // - Get Navigation Menu
  // - Get Custom Fields (ACF)
  // - Get User Meta
  // - Get Post Terms
  // - Get Post Author
  // - Get Post Date
  // - Get Post Content
  // - Get Post Excerpt
  // - Get Post Title
  // - Get Post URL
  // - Get Post Thumbnail
  // - Get Post Comments
  // - Get Post Categories
  // - Get Post Tags
  // - Get Post Custom Fields
  // - Get Post Meta
  // - Get Post Terms
  // - Get Post Author
  // - Get Post Date
  // - Get Post Content
  // - Get Post Excerpt
  // - Get Post Title
  // - Get Post URL
  // - Get Post Thumbnail
  // - Get Post Comments
  // - Get Post Categories
  // - Get Post Tags
  // - Get Post Custom Fields
  Blockly.Blocks['query_users'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Query Users')
        .appendField(new Blockly.FieldDropdown([
          ['All', 'all'],
          ['Subscribers', 'subscriber'],
          ['Authors', 'author'],
          ['Editors', 'editor'],
          ['Administrators', 'administrator']
        ]), 'ROLE');
      this.appendValueInput('NUMBER')
        .setCheck('Number')
        .appendField('Limit to');
      this.setOutput(true, 'Array');
      this.setColour(160);
      this.setTooltip('This is a test block that takes a number input');
      this.setHelpUrl('');
    }
  };



  Blockly.Blocks['get_current_user'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get Current User');
      this.setOutput(true, 'Object');
      this.setColour(160);
      this.setTooltip('Returns the currently logged in user object');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['get_current_user_field'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get Current User')
        .appendField(new Blockly.FieldDropdown([
          ['ID', 'ID'],
          ['Username', 'user_login'],
          ['Email', 'user_email'],
          ['Display Name', 'display_name'],
          ['First Name', 'first_name'],
          ['Last Name', 'last_name'],
          ['Role', 'role']
        ]), 'FIELD');
      this.setOutput(true, 'String');
      this.setColour(160);
      this.setTooltip('Returns a specific field from the current user');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['is_user_logged_in'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Is User Logged In');
      this.setOutput(true, 'Boolean');
      this.setColour(160);
      this.setTooltip('Returns true if a user is currently logged in');
      this.setHelpUrl('');
    }
  };








  Blockly.Blocks['http_get_users_id'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('When GET /users/{id} received');
      this.setNextStatement(true);
      this.setColour(120); // Green, like Scratch events
      this.setTooltip('Triggers when a GET request is made to /users/{id}.');
    }
  };

  Blockly.Blocks['http_post_users'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('When POST /users received');
      this.setNextStatement(true);
      this.setColour(120);
      this.setTooltip('Triggers when a POST request is made to /users.');
    }
  };

  Blockly.Blocks['get_url_parameter'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get URL parameter')
        .appendField(new Blockly.FieldTextInput('id'), 'PARAM_NAME');
      this.setOutput(true, 'String');
      this.setColour(210); // Purple, like variables
      this.setTooltip('Returns the value of the specified URL parameter.');
    }
  };
  Blockly.JavaScript['get_url_parameter'] = function (block) {
    var paramName = block.getFieldValue('PARAM_NAME');
    return ['getUrlParameter("' + paramName + '")', Blockly.JavaScript.ORDER_FUNCTION_CALL];
  };

  Blockly.Blocks['parse_json_body_field'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Parse JSON body field')
        .appendField(new Blockly.FieldTextInput('name'), 'FIELD_NAME');
      this.setOutput(true, 'String');
      this.setColour(160); // Orange, for JSON
      this.setTooltip('Gets the value of a field from the JSON body.');
    }
  };
  Blockly.JavaScript['parse_json_body_field'] = function (block) {
    var fieldName = block.getFieldValue('FIELD_NAME');
    return ['parseJsonBody("' + fieldName + '")', Blockly.JavaScript.ORDER_FUNCTION_CALL];
  };
  Blockly.Blocks['create_json_object'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Create JSON object');
      this.appendValueInput('FIELD1')
        .appendField('key')
        .appendField(new Blockly.FieldTextInput('key1'), 'KEY1');
      this.appendValueInput('FIELD2')
        .appendField('key')
        .appendField(new Blockly.FieldTextInput('key2'), 'KEY2');
      this.setOutput(true, 'JSON');
      this.setMutator(new Blockly.Mutator(['json_field'])); // Allow adding more fields
      this.setColour(160);
      this.setTooltip('Creates a JSON object with key-value pairs.');
    }
  };

  Blockly.Blocks['list_contains_key'] = {
    init: function () {
      this.appendValueInput('KEY')
        .appendField('List userList contains');
      this.setOutput(true, 'Boolean');
      this.setColour(100); // Blue, like lists
      this.setTooltip('Checks if a key exists in userList.');
    }
  };
  Blockly.JavaScript['list_contains_key'] = function (block) {
    var key = Blockly.JavaScript.valueToCode(block, 'KEY', Blockly.JavaScript.ORDER_NONE);
    return ['userList.hasOwnProperty(' + key + ')', Blockly.JavaScript.ORDER_FUNCTION_CALL];
  };

  Blockly.Blocks['get_list_subfield'] = {
    init: function () {
      this.appendValueInput('KEY')
        .appendField('Get userList[');
      this.appendDummyInput()
        .appendField('].')
        .appendField(new Blockly.FieldTextInput('name'), 'SUBFIELD');
      this.setOutput(true, 'String');
      this.setColour(100);
      this.setTooltip('Gets a subfield from userList for a key.');
    }
  };

  Blockly.Blocks['add_to_list_at_key'] = {
    init: function () {
      this.appendValueInput('KEY')
        .appendField('Add to userList at');
      this.appendValueInput('VALUE')
        .appendField('value');
      this.setPreviousStatement(true);
      this.setNextStatement(true);
      this.setColour(100);
      this.setTooltip('Adds a value to userList at the specified key.');
    }
  };
  Blockly.Blocks['send_json_response'] = {
    init: function () {
      this.appendValueInput('RESPONSE')
        .appendField('Send JSON response');
      this.appendValueInput('STATUS')
        .appendField('with status code');
      this.setPreviousStatement(true);
      this.setColour(120);
      this.setTooltip('Sends a JSON response with the specified status code.');
    }
  };
  Blockly.JavaScript['send_json_response'] = function (block) {
    var response = Blockly.JavaScript.valueToCode(block, 'RESPONSE', Blockly.JavaScript.ORDER_NONE);
    var status = Blockly.JavaScript.valueToCode(block, 'STATUS', Blockly.JavaScript.ORDER_NONE);
    return 'sendJsonResponse(' + response + ', ' + status + ');\n';
  };


  Blockly.Blocks['text_contains'] = {
    init: function () {
      this.appendValueInput('TEXT')
        .appendField('Text');
      this.appendDummyInput()
        .appendField('contains')
        .appendField(new Blockly.FieldTextInput('@'), 'SUBSTRING');
      this.setOutput(true, 'Boolean');
      this.setColour(210);
      this.setTooltip('Checks if the text contains the specified substring.');
    }
  };




  Blockly.Blocks['ecommerce_ai_recommendations'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get AI Product Recommendations');
      this.setOutput(true, 'Array');
      this.setColour(280);
      this.setTooltip('Returns AI-generated product recommendations');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['ecommerce_product_list'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get Product List');
      this.setOutput(true, 'Array');
      this.setColour(280);
      this.setTooltip('Returns a list of products');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['ecommerce_orders'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Get All Orders');
      this.setOutput(true, 'Array');
      this.setColour(280);
      this.setTooltip('Returns all orders');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['ecommerce_order'] = {
    init: function () {
      this.appendValueInput('ORDER_ID')
        .setCheck('Number')
        .appendField('Get Order');
      this.setOutput(true, 'Object');
      this.setColour(280);
      this.setTooltip('Returns a specific order by ID');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['ecommerce_order_add_product'] = {
    init: function () {
      this.appendValueInput('ORDER_ID')
        .setCheck('Number')
        .appendField('Add Product to Order');
      this.appendValueInput('PRODUCT_ID')
        .setCheck('Number')
        .appendField('Product ID');
      this.setPreviousStatement(true, null);
      this.setNextStatement(true, null);
      this.setColour(280);
      this.setTooltip('Adds a product to an existing order');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['ecommerce_order_checkout'] = {
    init: function () {
      this.appendValueInput('ORDER_ID')
        .setCheck('Number')
        .appendField('Checkout Order');
      this.setPreviousStatement(true, null);
      this.setNextStatement(true, null);
      this.setColour(280);
      this.setTooltip('Processes the checkout for an order');
      this.setHelpUrl('');
    }
  };

  Blockly.Blocks['wp_request'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('WP Request');
      this.setOutput(true, 'WP_Request');
      this.setColour(230);
      this.setTooltip('Represents a WP_Request object');
      this.setHelpUrl('');
    }
  };


  // 2. Block-code generator (for PHP)
  Blockly.PHP['query_users'] = function (block) {
    // Get the value of the input
    var value = Blockly.PHP.valueToCode(block, 'VALUE', Blockly.PHP.ORDER_ATOMIC) || '0';
    // Return the code
    return [value, Blockly.PHP.ORDER_ATOMIC];
  };

  Blockly.PHP['wp_request'] = function (block) {
    // This is a placeholder for the actual PHP code generation logic
    // You might want to return a variable or function call that represents a WP_Request object
    var code = '$request'; // Example: assuming $request is a WP_Request object in your PHP context
    return [code, Blockly.PHP.ORDER_ATOMIC];
  };

  const toolboxX0 = {
    kind: 'categoryToolbox',
    contents: [


      {
        kind: 'category',
        name: 'WordPress',
        colour: '#4A90E2',
        contents: [
          { kind: 'block', type: 'wp_request' }
          // Add other WordPress-related blocks here
        ]
      },
      {
        kind: 'category',
        name: 'Users',
        colour: 160,
        contents: [
          {
            kind: 'block',
            type: 'query_users'
          }
        ]
      },
      {
        kind: 'category',
        name: 'Events',
        colour: 120,
        contents: [
          {
            kind: 'block',
            type: 'query_users' // TODO: Replace with actual event blocks
          }
        ]
      },
      {
        kind: 'category',
        name: 'Multiplayer',
        colour: 200,
        contents: [
          {
            kind: 'block',
            type: 'query_users' // TODO: Replace with actual multiplayer blocks
          }
        ]
      },
      {
        kind: 'category',
        name: 'Ecommerce',
        colour: 280,
        contents: [
          {
            kind: 'block',
            type: 'ecommerce_ai_recommendations'
          },
          {
            kind: 'block',
            type: 'ecommerce_product_list'
          },
          {
            kind: 'block',
            type: 'ecommerce_orders'
          },
          {
            kind: 'block',
            type: 'ecommerce_order'
          },
          {
            kind: 'block',
            type: 'ecommerce_order_add_product'
          },
          {
            kind: 'block',
            type: 'ecommerce_order_checkout'
          }
        ]
      },
      {
        kind: 'category',
        name: 'Gamification',
        colour: 320,
        contents: [
          {
            kind: 'block',
            type: 'query_users' // TODO: Replace with actual gamification blocks
          }
        ]
      },
      {
        kind: 'category',
        name: 'Security',
        colour: 40,
        contents: [
          {
            kind: 'block',
            type: 'query_users' // TODO: Replace with actual security blocks
          }
        ]
      },
      {
        kind: 'category',
        name: 'WordPress',
        colour: '#4A90E2',
        contents: [
          { kind: 'block', type: 'wp_request' },
          { kind: 'block', type: 'wp_route_start' }
          // Add other WordPress-related blocks here
        ]
      },
      {
        kind: 'category',
        name: 'Logic',
        colour: '#5C81A6',
        contents: [
          { kind: 'block', type: 'controls_if' },
          { kind: 'block', type: 'logic_compare' },
          { kind: 'block', type: 'logic_operation' },
          { kind: 'block', type: 'logic_negate' },
          { kind: 'block', type: 'logic_boolean' },
          { kind: 'block', type: 'logic_null' },
          { kind: 'block', type: 'logic_ternary' }
        ]
      },
      {
        kind: 'category',
        name: 'Loops',
        colour: '#5CA65C',
        contents: [
          { kind: 'block', type: 'controls_repeat_ext' },
          { kind: 'block', type: 'controls_whileUntil' },
          { kind: 'block', type: 'controls_for' },
          { kind: 'block', type: 'controls_forEach' },
          { kind: 'block', type: 'controls_flow_statements' }
        ]
      },
      {
        kind: 'category',
        name: 'Math',
        colour: '#5C68A6',
        contents: [
          { kind: 'block', type: 'math_number' },
          { kind: 'block', type: 'math_arithmetic' },
          { kind: 'block', type: 'math_single' },
          { kind: 'block', type: 'math_trig' },
          { kind: 'block', type: 'math_constant' },
          { kind: 'block', type: 'math_number_property' },
          { kind: 'block', type: 'math_round' },
          { kind: 'block', type: 'math_on_list' },
          { kind: 'block', type: 'math_modulo' },
          { kind: 'block', type: 'math_constrain' },
          { kind: 'block', type: 'math_random_int' },
          { kind: 'block', type: 'math_random_float' }
        ]
      },
      {
        kind: 'category',
        name: 'Text',
        colour: '#5CA68D',
        contents: [
          { kind: 'block', type: 'text' },
          { kind: 'block', type: 'text_join' },
          { kind: 'block', type: 'text_append' },
          { kind: 'block', type: 'text_length' },
          { kind: 'block', type: 'text_isEmpty' },
          { kind: 'block', type: 'text_indexOf' },
          { kind: 'block', type: 'text_charAt' },
          { kind: 'block', type: 'text_getSubstring' },
          { kind: 'block', type: 'text_changeCase' },
          { kind: 'block', type: 'text_trim' },
          { kind: 'block', type: 'text_print' },
          { kind: 'block', type: 'text_prompt_ext' }
        ]
      },
      {
        kind: 'category',
        name: 'Lists',
        colour: '#745CA6',
        contents: [
          { kind: 'block', type: 'lists_create_with' },
          { kind: 'block', type: 'lists_repeat' },
          { kind: 'block', type: 'lists_length' },
          { kind: 'block', type: 'lists_isEmpty' },
          { kind: 'block', type: 'lists_indexOf' },
          { kind: 'block', type: 'lists_getIndex' },
          { kind: 'block', type: 'lists_setIndex' },
          { kind: 'block', type: 'lists_getSublist' },
          { kind: 'block', type: 'lists_split' },
          { kind: 'block', type: 'lists_sort' }
        ]
      },
      {
        kind: 'category',
        name: 'Colour',
        colour: '#A6745C',
        contents: [
          // { kind: 'block', type: 'colour_picker' },
          // { kind: 'block', type: 'colour_random' },
          // { kind: 'block', type: 'colour_rgb' },
          // { kind: 'block', type: 'colour_blend' }
        ]
      },
      {
        kind: 'category',
        name: 'Variables',
        colour: '#A65C81',
        custom: 'VARIABLE'
      },
      {
        kind: 'category',
        name: 'Functions',
        colour: '#9A5CA6',
        custom: 'PROCEDURE'
      }
    ]
  };


  const toolbox = {
    kind: 'categoryToolbox',
    contents: [
      {
        kind: 'category',
        name: 'HTTP',
        colour: 120, // Green, for event-driven blocks
        contents: [
          // { kind: 'block', type: 'http_get_users_id' }, // When GET /users/{id} received
          // { kind: 'block', type: 'http_post_users' }, // When POST /users received
          // { kind: 'block', type: 'get_url_parameter' }, // Get URL parameter "id"
          // { kind: 'block', type: 'send_json_response' } // Send JSON response with statusCode
        ]
      },
      {
        kind: 'category',
        name: 'JSON',
        colour: 160, // Orange, for data processing
        contents: [
          // { kind: 'block', type: 'create_json_object' }, // Create JSON object
          // { kind: 'block', type: 'parse_json_body_field' } // Parse JSON body field "name"
        ]
      },
      {
        kind: 'category',
        name: 'WordPress',
        colour: '#4A90E2',
        contents: [
          { kind: 'block', type: 'wp_request' },
          { kind: 'block', type: 'wp_route_start' }
          // Add other WordPress-related blocks here
        ]
      },
      {
        kind: 'category',
        name: 'Users',
        colour: 160,
        contents: [
          { kind: 'block', type: 'query_users' } // Assuming this is user-specific; clarify if REST-related
        ]
      },
      {
        kind: 'category',
        name: 'Ecommerce',
        colour: 280,
        contents: [
          { kind: 'block', type: 'ecommerce_ai_recommendations' },
          { kind: 'block', type: 'ecommerce_product_list' },
          { kind: 'block', type: 'ecommerce_orders' },
          { kind: 'block', type: 'ecommerce_order' },
          { kind: 'block', type: 'ecommerce_order_add_product' },
          { kind: 'block', type: 'ecommerce_order_checkout' }
        ]
      },
      {
        kind: 'category',
        name: 'Events',
        colour: 120,
        contents: [
          { kind: 'block', type: 'query_users' } // TODO: Replace with actual event blocks
        ]
      },
      {
        kind: 'category',
        name: 'Multiplayer',
        colour: 200,
        contents: [
          { kind: 'block', type: 'query_users' } // TODO: Replace with actual multiplayer blocks
        ]
      },
      {
        kind: 'category',
        name: 'Gamification',
        colour: 320,
        contents: [
          { kind: 'block', type: 'query_users' } // TODO: Replace with actual gamification blocks
        ]
      },
      {
        kind: 'category',
        name: 'Security',
        colour: 40,
        contents: [
          { kind: 'block', type: 'query_users' } // TODO: Replace with actual security blocks
        ]
      },
      {
        kind: 'category',
        name: 'Logic',
        colour: '#5C81A6',
        contents: [
          { kind: 'block', type: 'controls_if' },
          { kind: 'block', type: 'logic_compare' },
          { kind: 'block', type: 'logic_operation' },
          { kind: 'block', type: 'logic_negate' },
          { kind: 'block', type: 'logic_boolean' },
          { kind: 'block', type: 'logic_null' },
          { kind: 'block', type: 'logic_ternary' }
        ]
      },
      {
        kind: 'category',
        name: 'Loops',
        colour: '#5CA65C',
        contents: [
          { kind: 'block', type: 'controls_repeat_ext' },
          { kind: 'block', type: 'controls_whileUntil' },
          { kind: 'block', type: 'controls_for' },
          { kind: 'block', type: 'controls_forEach' },
          { kind: 'block', type: 'controls_flow_statements' }
        ]
      },
      {
        kind: 'category',
        name: 'Math',
        colour: '#5C68A6',
        contents: [
          { kind: 'block', type: 'math_number' },
          { kind: 'block', type: 'math_arithmetic' },
          { kind: 'block', type: 'math_single' },
          { kind: 'block', type: 'math_trig' },
          { kind: 'block', type: 'math_constant' },
          { kind: 'block', type: 'math_number_property' },
          { kind: 'block', type: 'math_round' },
          { kind: 'block', type: 'math_on_list' },
          { kind: 'block', type: 'math_modulo' },
          { kind: 'block', type: 'math_constrain' },
          { kind: 'block', type: 'math_random_int' },
          { kind: 'block', type: 'math_random_float' }
        ]
      },
      {
        kind: 'category',
        name: 'Text',
        colour: '#5CA68D',
        contents: [
          { kind: 'block', type: 'text' },
          { kind: 'block', type: 'text_join' },
          { kind: 'block', type: 'text_append' },
          { kind: 'block', type: 'text_length' },
          { kind: 'block', type: 'text_isEmpty' },
          { kind: 'block', type: 'text_indexOf' },
          { kind: 'block', type: 'text_charAt' },
          { kind: 'block', type: 'text_getSubstring' },
          { kind: 'block', type: 'text_changeCase' },
          { kind: 'block', type: 'text_trim' },
          { kind: 'block', type: 'text_print' },
          { kind: 'block', type: 'text_prompt_ext' },
          { kind: 'block', type: 'text_contains' } // Added for email validation
        ]
      },
      {
        kind: 'category',
        name: 'Lists',
        colour: '#745CA6',
        contents: [
          { kind: 'block', type: 'lists_create_with' },
          { kind: 'block', type: 'lists_repeat' },
          { kind: 'block', type: 'lists_length' },
          { kind: 'block', type: 'lists_isEmpty' },
          { kind: 'block', type: 'lists_indexOf' },
          { kind: 'block', type: 'lists_getIndex' },
          { kind: 'block', type: 'lists_setIndex' },
          { kind: 'block', type: 'lists_getSublist' },
          { kind: 'block', type: 'lists_split' },
          { kind: 'block', type: 'lists_sort' },
          { kind: 'block', type: 'list_contains_key' }, // Added for userList contains
          { kind: 'block', type: 'get_list_subfield' }, // Added for userList[userId].name
          { kind: 'block', type: 'add_to_list_at_key' } // Added for adding to userList
        ]
      },
      {
        kind: 'category',
        name: 'Colour',
        colour: '#A6745C',
        contents: [
          // { kind: 'block', type: 'colour_picker' },
          // { kind: 'block', type: 'colour_random' },
          // { kind: 'block', type: 'colour_rgb' },
          // { kind: 'block', type: 'colour_blend' }
        ]
      },
      {
        kind: 'category',
        name: 'Variables',
        colour: '#A65C81',
        custom: 'VARIABLE'
      },
      {
        kind: 'category',
        name: 'Functions',
        colour: '#9A5CA6',
        custom: 'PROCEDURE'
      }
    ]
  };



  // Inject the workspace with the toolbox
  const workspace = Blockly.inject('blocklyDiv', {
    toolbox: toolbox,
    trashcan: true,
    scrollbars: true,
    sounds: true,
    media: 'https://unpkg.com/blockly/media/'
  });

  // Preload PHP code if it exists
  <?php
  $workspaceState = get_post_meta($troute->ID, 'workspaceState', true);
  if (!empty($workspaceState)) {
    echo "try {\n";
    echo "  const savedState = " . ($workspaceState) . ";\n";
    echo "  Blockly.serialization.workspaces.load(savedState, workspace);\n";
    echo "  console.log('YES', savedState);\n";
    echo "} catch (e) {\n";
    echo "  console.error('Error loading saved workspace:', e);\n";
    echo "}\n";
  }
  ?>

  // Function to generate code and populate the hidden input
  function generateCode() {
    const code = Blockly.PHP.workspaceToCode(workspace);
    document.getElementById('generatedCode').value = code;

    // Save workspace state
    const state = Blockly.serialization.workspaces.save(workspace);
    document.getElementById('workspaceState').value = JSON.stringify(state);

    console.log(state);
  }

  Blockly.Blocks['wp_route_start'] = {
    init: function () {
      this.appendDummyInput()
        .appendField('Start WP Route');
      this.appendValueInput('REQUEST')
        .setCheck('WP_Request')
        .appendField('with WP_Request');
      this.setPreviousStatement(false, null);
      this.setNextStatement(true, null);
      this.setColour(290);
      this.setTooltip('Start a WordPress route with a WP_Request object');
      this.setHelpUrl('');
    }
  };

  Blockly.PHP['wp_route_start'] = function (block) {
    var request = Blockly.PHP.valueToCode(block, 'REQUEST', Blockly.PHP.ORDER_ATOMIC);
    var code = `// Start of WP Route\nif (${request}) {\n  // Your route logic here\n}\n`;
    return code;
  };

</script>