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
<script src="https://unpkg.com/blockly/php_compressed.js"></script>



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
  <p>ID: <?php echo $troute->ID; ?></p>


  <div id="blocklyDiv" style=""></div>


  <!-- Form to submit the generated code -->
  <div class="controls">
    <button type="button" onclick="generateCode()">Generate Code</button>
    <form id="codeForm" action="/submit" method="POST">
      <input type="text" id="generatedCode" name="code">
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



  const toolbox = {
    kind: 'categoryToolbox',
    contents: [
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
    trashcan: true, // Optional: Adds a trashcan for deleting blocks
    scrollbars: true, // Optional: Enables scrollbars
    sounds: true, // Optional: Enables sounds for block interactions
    media: 'https://unpkg.com/blockly/media/' // Path to Blockly media (sounds, icons, etc.)
  });

  // Function to generate code and populate the hidden input
  function generateCode() {
    // const code = Blockly.JavaScript.workspaceToCode(workspace);
    const code = Blockly.PHP.workspaceToCode(workspace);
    document.getElementById('generatedCode').value = code;
    // Optional: Display the code for debugging
    console.log(code);
  }




</script>