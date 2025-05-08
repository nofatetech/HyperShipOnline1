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
  <div>
    <p>workspaceState:
      <br>
      <code>
      <?php $workspaceState = get_post_meta($troute->ID, 'workspaceState', true);
      echo $workspaceState; ?>
    </code>
      <br>

  </div>

  <div>
    <div>code:</div>
    <div>
      <code>
      <?php $code = get_post_meta($troute->ID, 'generatedCode', true);
      echo $code; ?>
    </code>
    </div>
  </div>

  <div id="blocklyDiv" style=""></div>


  <!-- Form to submit the generated code -->
  <div class="controls">
    <button type="button" onclick="generateCode()">Generate Code</button>
    <form id="codeForm" action="" method="POST">
      <input type="text" id="generatedCode" name="code">
      <input type="text" id="workspaceState" name="workspaceState">

      <input type="submit" value="Submit Code">
    </form>
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



  // 2. Block-code generator (for PHP)
  Blockly.PHP['query_users'] = function (block) {
    // Get the value of the input
    var value = Blockly.PHP.valueToCode(block, 'VALUE', Blockly.PHP.ORDER_ATOMIC) || '0';
    // Return the code
    return [value, Blockly.PHP.ORDER_ATOMIC];
  };

  const toolbox = {
    kind: 'categoryToolbox',
    contents: [

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




</script>