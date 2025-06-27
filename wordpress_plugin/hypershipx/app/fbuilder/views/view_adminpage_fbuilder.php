<?php

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

if (isset($_POST['post_name'])) {
  $sanitized_name = sanitize_text_field($_POST['post_name']);
  wp_update_post([
    'ID' => $route_id,
    'post_name' => $sanitized_name
  ]);
}

if (isset($_POST['post_title'])) {
  $sanitized_title = sanitize_text_field($_POST['post_title']);
  wp_update_post([
    'ID' => $route_id,
    'post_title' => $sanitized_title
  ]);
}

if (isset($_POST['post_excerpt'])) {
  $sanitized_excerpt = sanitize_textarea_field($_POST['post_excerpt']);
  wp_update_post([
    'ID' => $route_id,
    'post_excerpt' => $sanitized_excerpt
  ]);
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




$parent_app_id = get_post_meta($troute->ID, 'app_parent', true);
$parent_app = get_post($parent_app_id);
// echo esc_html($parent_app->post_title);














$recipes_for_endpoints = [
  'Authentication' => [
    '/users_register' => [
      'Title' => 'User Registration',
      'SampleCode' => <<<Y1Y1Y1Y1
\$username = \$request->get_param("username");
\$password = \$request->get_param("password");

\$user = wp_authenticate(\$username, \$password);
if (is_wp_error(\$user)) {
  return new WP_Error("auth_failed", "Invalid credentials", array("status" => 401));
}
return new WP_REST_Response(["token" => wp_create_nonce("wp_rest")], 200);
Y1Y1Y1Y1,
    ],
    '/users_login_email_password' => [
      'Title' => 'User Login',
      'SampleCode' => 'POST /users_login_email_password { email: "user@example.com", password: "****" }'
    ],
    '/users_logout' => [
      'Title' => 'User Logout',
      'SampleCode' => 'POST /users_logout { token: "user_token" }'
    ],
    '/users_profile' => [
      'Title' => 'Get User Profile',
      'SampleCode' => 'GET /users_profile { token: "user_token" }'
    ],
  ],
  'Blog' => [
    '/blog/posts' => [
      'Title' => 'Get Blog Posts',
      'SampleCode' => 'GET /blog/posts { page: 1, per_page: 10 }'
    ]
  ],
  'Ecommerce' => [
    '/ecommerce_ai_recommendations' => [
      'Title' => 'Get AI Recommendations',
      'SampleCode' => 'GET /ecommerce_ai_recommendations { user_id: "123" }'
    ],
    '/ecommerce_products' => [
      'Title' => 'Get Products',
      'SampleCode' => 'GET /ecommerce_products { category: "electronics" }'
    ],
    '/ecommerce_orders' => [
      'Title' => 'Get Orders',
      'SampleCode' => 'GET /ecommerce_orders { user_id: "123" }'
    ],
    '/ecommerce_orders_add_product' => [
      'Title' => 'Add Product to Order',
      'SampleCode' => 'POST /ecommerce_orders_add_product { order_id: "456", product_id: "789" }'
    ],
    '/ecommerce_orders_checkout' => [
      'Title' => 'Checkout Order',
      'SampleCode' => 'POST /ecommerce_orders_checkout { order_id: "456", payment_method: "credit_card" }'
    ]
  ],
  'Events' => [
    '/events/events' => [
      'Title' => 'Get Events',
      'SampleCode' => 'GET /events/events { date: "2024-03-20" }'
    ],
    '/events/register_attendee' => [
      'Title' => 'Register Attendee',
      'SampleCode' => 'POST /events/register_attendee { event_id: "123", user_id: "456" }'
    ]
  ],
  'Multiplayer' => [
    '/multiplayer/rooms' => [
      'Title' => 'Get Rooms',
      'SampleCode' => 'GET /multiplayer/rooms { status: "active" }'
    ],
    '/multiplayer/rooms/create' => [
      'Title' => 'Create Room',
      'SampleCode' => 'POST /multiplayer/rooms/create { name: "Game Room", max_players: 4 }'
    ],
    '/multiplayer/rooms/join' => [
      'Title' => 'Join Room',
      'SampleCode' => 'POST /multiplayer/rooms/join { room_id: "123", user_id: "456" }'
    ],
    '/multiplayer/rooms/leave' => [
      'Title' => 'Leave Room',
      'SampleCode' => 'POST /multiplayer/rooms/leave { room_id: "123", user_id: "456" }'
    ],
    '/multiplayer/rooms/players' => [
      'Title' => 'Get Room Players',
      'SampleCode' => 'GET /multiplayer/rooms/players { room_id: "123" }'
    ]
  ],
  'Gamification' => [
    '/gamification/points' => [
      'Title' => 'Get User Points',
      'SampleCode' => 'GET /gamification/points { user_id: "123" }'
    ],
    '/gamification/badges' => [
      'Title' => 'Get User Badges',
      'SampleCode' => 'GET /gamification/badges { user_id: "123" }'
    ],
    '/gamification/leaderboard' => [
      'Title' => 'Get Leaderboard',
      'SampleCode' => 'GET /gamification/leaderboard { time_frame: "weekly" }'
    ],
    '/gamification/challenges/create' => [
      'Title' => 'Create Challenge',
      'SampleCode' => 'POST /gamification/challenges/create { title: "Weekly Quest", points: 100 }'
    ],
    '/gamification/challenges/complete' => [
      'Title' => 'Complete Challenge',
      'SampleCode' => 'POST /gamification/challenges/complete { challenge_id: "123", user_id: "456" }'
    ]
  ],
  'Analytics' => [
    '/analytics/xxx/create' => [
      'Title' => 'Create Analytics Event',
      'SampleCode' => 'POST /analytics/xxx/create { event_type: "page_view", data: {} }'
    ]
  ],
  'Security' => [
    '/security/turn_all_off_now' => [
      'Title' => 'Emergency Shutdown',
      'SampleCode' => 'POST /security/turn_all_off_now { admin_token: "secure_token" }'
    ]
  ]
];
?>






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


<h2 style="margin: 0; font-size: 24px; color: #1d2327;">
<?php echo esc_html($parent_app->post_title); ?> > <?php echo esc_html($troute->post_title); ?>
</h2>

<div>
  <a href="<?php echo admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . get_post_meta($troute->ID, 'app_parent', true)); ?>"
    class="button">
    <span class="dashicons dashicons-arrow-left-alt"></span>
    Back to App Dashboard
  </a>
</div>






  <!-- <div class="back-link" style="margin-bottom: 20px;">
    <a href="<?php echo admin_url('admin.php?page=hypershipx_adminpage_appdashboard&app_id=' . get_post_meta($troute->ID, 'app_parent', true)); ?>"
      class="button">
      <span class="dashicons dashicons-arrow-left-alt"></span>
      Back to App Dashboard
    </a>
  </div> -->

  <!-- <h1>HyperShip Route Builder</h1> -->



  <form id="basicInfoForm" action="" method="POST" class="code-form">
    <div class="route-info">
      <h3>Basic Info</h3>
      <div class="form-group">
        <label for="routeTitle">Title</label>
        <input type="text" id="routeTitle" name="post_title" value="<?php echo esc_attr($troute->post_title); ?>"
          class="regular-text" xxxreadonly>
      </div>

      <div class="form-group">
        <label for="routeSlug">Path</label>
        <input type="text" id="routeSlug" name="post_name" value="<?php echo esc_attr($troute->post_name); ?>"
          class="regular-text" xxxreadonly>
      </div>

      <div class="form-group">
        <label for="routeDescription">Summary</label>
        <textarea id="routeDescription" name="post_excerpt" class="large-text" rows="3"
          xxxreadonly><?php echo esc_textarea($troute->post_excerpt); ?></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="button button-primary">
          <span class="dashicons dashicons-saved"></span>
          Save Changes
        </button>
      </div>
    </div>
  </form>



  <style>
    .route-info {
      background: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #ccd0d4;
      box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
    }

    .route-info .form-group {
      margin-bottom: 15px;
    }

    .route-info label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
    }

    .route-info input[type="text"],
    .route-info textarea {
      width: 100%;
      background: #f0f0f1;
    }
  </style>


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
      <h3>Visual Code Builder (Under Construction)</h3>
      <br>
      <br>
      <br>


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
          <button type="submit" class="button button-primary">
            <span class="dashicons dashicons-saved"></span>
            Save Changes
          </button>
        </div>
      </form>
    </div>



    <form id="customCodeForm" action="" method="POST" class="custom-code-form">

      <div class="controls-wrapper" style="background: #333;">
        <h3 style="color: #fff;">Custom Code</h3>
        <br>

        <div class="form-group">
          <!-- <label for="customCode">Custom Code</label> -->
          <div class="custom-code-tabs">
            <div class="tab-buttons">
              <button type="button" class="tab-button active" data-tab="get">GET</button>
              <button type="button" class="tab-button" data-tab="post">POST</button>
            </div>

            <div class="tab-content">
              <div class="tab-pane active" id="get-tab">
                <textarea id="customCodeGet" name="customCodeGet" rows="17" class="large-text code"
                  placeholder="Enter GET route code here..." style="background: #444; color: #fff;"><?php
                  $customCodeGet = get_post_meta($troute->ID, 'customCodeGet', true);
                  echo esc_textarea($customCodeGet);
                  ?></textarea>
              </div>

              <div class="tab-pane" id="post-tab">
                <textarea id="customCodePost" name="customCodePost" rows="33" class="large-text code"
                  placeholder="Enter POST route code here..." style="background: #444; color: #fff;"><?php
                  $customCodePost = get_post_meta($troute->ID, 'customCodePost', true);
                  echo esc_textarea($customCodePost);
                  ?></textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="button button-primary">
              <span class="dashicons dashicons-saved"></span>
              Save Changes
            </button>
          </div>


          <style>
            .custom-code-tabs {
              margin-bottom: 20px;
            }

            .tab-buttons {
              margin-bottom: 10px;
            }

            .tab-button {
              padding: 8px 16px;
              margin-right: 5px;
              border: 1px solid #555;
              background: #444;
              color: #fff;
              cursor: pointer;
            }

            .tab-button.active {
              background: #007cba;
              color: white;
              border-color: #007cba;
            }

            .tab-pane {
              display: none;
            }

            .tab-pane.active {
              display: block;
            }
          </style>

          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const tabButtons = document.querySelectorAll('.tab-button');
              const tabPanes = document.querySelectorAll('.tab-pane');

              tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                  // Remove active class from all buttons and panes
                  tabButtons.forEach(btn => btn.classList.remove('active'));
                  tabPanes.forEach(pane => pane.classList.remove('active'));

                  // Add active class to clicked button and corresponding pane
                  button.classList.add('active');
                  document.getElementById(button.dataset.tab + '-tab').classList.add('active');
                });
              });
            });
          </script>



<div class="ai-assistant" style="background: #555;">
              <h3 style="color: #fff;">AI Route Assistant</h3>
              <div class="assistant-input">
                <textarea id="routePrompt" placeholder="Describe the route you want to create..." rows="4"
                  class="large-text" style="background: #444; color: #fff;"></textarea>
                <button onclick="getAIAssistance()" class="button button-secondary" style="background: #666;">
                  <span class="dashicons dashicons-admin-comments"></span>
                  Get AI Help
                </button>
              </div>
              <div id="aiResponse" class="assistant-response" style="display: none; background: #444;">
                <div class="response-content" style="color: #fff;"></div>
                <button onclick="applyAISuggestion()" class="button button-primary" style="background: #666;">
                  <span class="dashicons dashicons-yes"></span>
                  Apply Suggestion
                </button>
              </div>
            </div>

            <style>
              .route-examples {
                margin-bottom: 20px;
              }

              .ai-assistant {
                padding: 15px;
                border-radius: 4px;
                margin-bottom: 20px;
              }

              .assistant-input {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
              }

              .assistant-input textarea {
                flex: 1;
              }

              .assistant-response {
                padding: 15px;
                border-radius: 4px;
                border: 1px solid #555;
                margin-top: 10px;
              }

              .response-content {
                font-family: monospace;
                white-space: pre-wrap;
                margin-bottom: 10px;
              }
            </style>



          <div
            style="border: 1px solid #555; padding: 10px; border-radius: 5px; margin-top: 33px; background: #444;">

            <div class="route-examples">
              <h3 style="color: #fff;">Recipes for Endpoints</h3>
              <select id="routeExample" onchange="updateCodeExample()" class="regular-text"
                style="background: #555; color: #fff;">
                <option value="">Select an example...</option>
                <?php foreach ($recipes_for_endpoints as $category => $endpoints): ?>
                  <optgroup label="<?php echo esc_html($category); ?>">
                    <?php foreach ($endpoints as $endpoint => $details): ?>
                      <option value="<?php echo esc_attr($endpoint); ?>"><?php echo esc_html($details['Title']); ?></option>
                    <?php endforeach; ?>
                  </optgroup>
                <?php endforeach; ?>
              </select>
            </div>

            <div id="code-example" style="background:rgb(79, 79, 79); padding: 10px; border-radius: 4px; color: white;">
              <pre style="margin: 0;">
function($request) {
// ONLY WRITE THE CODE FROM HERE..
<strong>
$username = $request->get_param('username');
$password = $request->get_param('password');

$user = wp_authenticate($username, $password);
if (is_wp_error($user)) {
return new WP_Error('auth_failed', 'Invalid credentials', array('status' => 401));
}

return new WP_REST_Response(['token' => wp_create_nonce('wp_rest')], 200);
</strong>
// .. UP TO HERE.
}
</pre>
            </div>

            <script>
              const routeExamples = <?php echo json_encode(array_map(function ($endpoints) {
                return array_map(function ($details) {
                  return $details['SampleCode'];
                }, $endpoints);
              }, $recipes_for_endpoints)); ?>;

              function updateCodeExample() {
                const select = document.getElementById('routeExample');
                const selectedValue = select.value;
                if (!selectedValue) return;

                // Find the example in the nested structure
                let example = null;
                for (const category in routeExamples) {
                  if (routeExamples[category][selectedValue]) {
                    example = routeExamples[category][selectedValue];
                    break;
                  }
                }

                if (example) {
                  document.getElementById('code-example').innerHTML = "<pre>" + example + "</pre>";
                }
              }

              function getAIAssistance() {
                const prompt = document.getElementById('routePrompt').value;
                if (!prompt) return;

                // Show loading state
                const responseDiv = document.getElementById('aiResponse');
                responseDiv.style.display = 'block';
                responseDiv.querySelector('.response-content').textContent = 'Generating response...';

                // Simulate AI response (replace with actual API call)
                setTimeout(() => {
                  responseDiv.querySelector('.response-content').textContent =
                    `// AI generated route based on your description:\n${prompt}\n\n` +
                    `add_action('rest_api_init', function() {\n` +
                    `  register_rest_route('myplugin/v1', '/custom', array(\n` +
                    `    'methods' => 'POST',\n` +
                    `    'callback' => function($request) {\n` +
                    `      // Your route logic here\n` +
                    `      return new WP_REST_Response(['message' => 'Success'], 200);\n` +
                    `    }\n` +
                    `  ));\n` +
                    `});`;
                }, 1000);
              }

              function applyAISuggestion() {
                const suggestion = document.getElementById('aiResponse').querySelector('.response-content').textContent;
                document.getElementById('customCode').value = suggestion;
              }
            </script>
          </div>

        </div>
      </div>
    </form>


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




    <div id="" style="display: none;">
      ```markdown
      # WordPress API Endpoints

      ## Authentication

      ### Login
      ```php
      $params = $request->get_json_params();
      $username = sanitize_text_field($params['username']);
      $password = $params['password'];

      $user = wp_authenticate($username, $password);
      if (is_wp_error($user)) {
          return new WP_Error('invalid_credentials', 'Invalid username or password', array('status' => 401));
      }

      $token = wp_generate_password(32, false);
      update_user_meta($user->ID, 'auth_token', $token);

      return array(
          'message' => 'Login successful',
          'token' => $token,
          'user_id' => $user->ID,
          'email' => $user->user_email
      );
      ```

      ### Logout
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      delete_user_meta($user_id, 'auth_token');

      return array(
          'message' => 'Logout successful'
      );
      ```

      ### Register
      ```php
      $params = $request->get_json_params();
      $username = sanitize_text_field($params['username']);
      $email = sanitize_email($params['email']);
      $password = $params['password'];

      if (username_exists($username) || email_exists($email)) {
          return new WP_Error('user_exists', 'Username or email already exists', array('status' => 400));
      }

      $user_id = wp_create_user($username, $password, $email);
      if (is_wp_error($user_id)) {
          return new WP_Error('registration_failed', $user_id->get_error_message(), array('status' => 400));
      }

      $token = wp_generate_password(32, false);
      update_user_meta($user_id, 'auth_token', $token);

      return array(
          'message' => 'Registration successful',
          'user_id' => $user_id,
          'token' => $token
      );
      ```

      ## Posts

      ### Create Post
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);
      $title = sanitize_text_field($params['title']);
      $content = wp_kses_post($params['content']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      $post_id = wp_insert_post(array(
          'post_title' => $title,
          'post_content' => $content,
          'post_status' => 'publish',
          'post_author' => $user_id,
          'post_type' => 'post'
      ));

      if (is_wp_error($post_id)) {
          return new WP_Error('post_creation_failed', 'Failed to create post', array('status' => 400));
      }

      return array(
          'message' => 'Post created successfully',
          'post_id' => $post_id
      );
      ```

      ### Read Post
      ```php
      $params = $request->get_json_params();
      $post_id = absint($params['post_id']);

      $post = get_post($post_id);
      if (!$post || $post->post_type !== 'post') {
          return new WP_Error('post_not_found', 'Post not found', array('status' => 404));
      }

      return array(
          'message' => 'Post retrieved successfully',
          'post' => array(
              'id' => $post->ID,
              'title' => $post->post_title,
              'content' => $post->post_content,
              'author' => $post->post_author,
              'date' => $post->post_date
          )
      );
      ```

      ### Update Post
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);
      $post_id = absint($params['post_id']);
      $title = sanitize_text_field($params['title']);
      $content = wp_kses_post($params['content']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      $post = get_post($post_id);
      if (!$post || $post->post_author != $user_id) {
          return new WP_Error('unauthorized', 'Unauthorized to edit this post', array('status' => 403));
      }

      $updated = wp_update_post(array(
          'ID' => $post_id,
          'post_title' => $title,
          'post_content' => $content
      ));

      if (is_wp_error($updated)) {
          return new WP_Error('post_update_failed', 'Failed to update post', array('status' => 400));
      }

      return array(
          'message' => 'Post updated successfully',
          'post_id' => $post_id
      );
      ```

      ### Delete Post
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);
      $post_id = absint($params['post_id']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      $post = get_post($post_id);
      if (!$post || $post->post_author != $user_id) {
          return new WP_Error('unauthorized', 'Unauthorized to delete this post', array('status' => 403));
      }

      $deleted = wp_delete_post($post_id, true);
      if (!$deleted) {
          return new WP_Error('post_deletion_failed', 'Failed to delete post', array('status' => 400));
      }

      return array(
          'message' => 'Post deleted successfully'
      );
      ```

      ## E-commerce

      ### Create Product
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);
      $name = sanitize_text_field($params['name']);
      $price = floatval($params['price']);
      $description = wp_kses_post($params['description']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      $product_id = wp_insert_post(array(
          'post_title' => $name,
          'post_content' => $description,
          'post_status' => 'publish',
          'post_type' => 'product'
      ));

      if (is_wp_error($product_id)) {
          return new WP_Error('product_creation_failed', 'Failed to create product', array('status' => 400));
      }

      update_post_meta($product_id, '_regular_price', $price);
      update_post_meta($product_id, '_price', $price);
      update_post_meta($product_id, '_visibility', 'visible');

      return array(
          'message' => 'Product created successfully',
          'product_id' => $product_id
      );
      ```

      ### Process Payment
      ```php
      $params = $request->get_json_params();
      $user_id = absint($params['user_id']);
      $token = sanitize_text_field($params['token']);
      $product_id = absint($params['product_id']);
      $quantity = absint($params['quantity']);

      $stored_token = get_user_meta($user_id, 'auth_token', true);
      if ($stored_token !== $token) {
          return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
      }

      $product = wc_get_product($product_id);
      if (!$product) {
          return new WP_Error('product_not_found', 'Product not found', array('status' => 404));
      }

      $order = wc_create_order();
      $order->add_product($product, $quantity);
      $order->set_customer_id($user_id);
      $order->calculate_totals();

      m<div>
      /login
    $params = $request->get_json_params();
    $username = sanitize_text_field($params['username']);
    $password = $params['password'];

    $user = wp_authenticate($username, $password);
    if (is_wp_error($user)) {
        return new WP_Error('invalid_credentials', 'Invalid username or password', array('status' => 401));
    }

    $token = wp_generate_password(32, false);
    update_user_meta($user->ID, 'auth_token', $token);

    return array(
        'message' => 'Login successful',
        'token' => $token,
        'user_id' => $user->ID,
        'email' => $user->user_email
    );

/logout
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    delete_user_meta($user_id, 'auth_token');

    return array(
        'message' => 'Logout successful'
    );

/register
    $params = $request->get_json_params();
    $username = sanitize_text_field($params['username']);
    $email = sanitize_email($params['email']);
    $password = $params['password'];

    if (username_exists($username) || email_exists($email)) {
        return new WP_Error('user_exists', 'Username or email already exists', array('status' => 400));
    }

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        return new WP_Error('registration_failed', $user_id->get_error_message(), array('status' => 400));
    }

    $token = wp_generate_password(32, false);
    update_user_meta($user_id, 'auth_token', $token);

    return array(
        'message' => 'Registration successful',
        'user_id' => $user_id,
        'token' => $token
    );

/create-post
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $title = sanitize_text_field($params['title']);
    $content = wp_kses_post($params['content']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $post_id = wp_insert_post(array(
        'post_title' => $title,
        'post_content' => $content,
        'post_status' => 'publish',
        'post_author' => $user_id,
        'post_type' => 'post'
    ));

    if (is_wp_error($post_id)) {
        return new WP_Error('post_creation_failed', 'Failed to create post', array('status' => 400));
    }

    return array(
        'message' => 'Post created successfully',
        'post_id' => $post_id
    );

/read-post
    $params = $request->get_json_params();
    $post_id = absint($params['post_id']);

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'post') {
        return new WP_Error('post_not_found', 'Post not found', array('status' => 404));
    }

    return array(
        'message' => 'Post retrieved successfully',
        'post' => array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'content' => $post->post_content,
            'author' => $post->post_author,
            'date' => $post->post_date
        )
    );

/update-post
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $post_id = absint($params['post_id']);
    $title = sanitize_text_field($params['title']);
    $content = wp_kses_post($params['content']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $post = get_post($post_id);
    if (!$post || $post->post_author != $user_id) {
        return new WP_Error('unauthorized', 'Unauthorized to edit this post', array('status' => 403));
    }

    $updated = wp_update_post(array(
        'ID' => $post_id,
        'post_title' => $title,
        'post_content' => $content
    ));

    if (is_wp_error($updated)) {
        return new WP_Error('post_update_failed', 'Failed to update post', array('status' => 400));
    }

    return array(
        'message' => 'Post updated successfully',
        'post_id' => $post_id
    );

/delete-post
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $post_id = absint($params['post_id']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $post = get_post($post_id);
    if (!$post || $post->post_author != $user_id) {
        return new WP_Error('unauthorized', 'Unauthorized to delete this post', array('status' => 403));
    }

    $deleted = wp_delete_post($post_id, true);
    if (!$deleted) {
        return new WP_Error('post_deletion_failed', 'Failed to delete post', array('status' => 400));
    }

    return array(
        'message' => 'Post deleted successfully'
    );

/create-product
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $name = sanitize_text_field($params['name']);
    $price = floatval($params['price']);
    $description = wp_kses_post($params['description']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $product_id = wp_insert_post(array(
        'post_title' => $name,
        'post_content' => $description,
        'post_status' => 'publish',
        'post_type' => 'product'
    ));

    if (is_wp_error($product_id)) {
        return new WP_Error('product_creation_failed', 'Failed to create product', array('status' => 400));
    }

    update_post_meta($product_id, '_regular_price', $price);
    update_post_meta($product_id, '_price', $price);
    update_post_meta($product_id, '_visibility', 'visible');

    return array(
        'message' => 'Product created successfully',
        'product_id' => $product_id
    );

/process-payment
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $product_id = absint($params['product_id']);
    $quantity = absint($params['quantity']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $product = wc_get_product($product_id);
    if (!$product) {
        return new WP_Error('product_not_found', 'Product not found', array('status' => 404));
    }

    $order = wc_create_order();
    $order->add_product($product, $quantity);
    $order->set_customer_id($user_id);
    $order->calculate_totals();

    $order->update_status('pending', 'Order created via API');

    return array(
        'message' => 'Order created successfully',
        'order_id' => $order->get_id(),
        'total' => $order->get_total()
    );

/send-transactional-email
    $params = $request->get_json_params();
    $user_id = absint($params['user_id']);
    $token = sanitize_text_field($params['token']);
    $to = sanitize_email($params['to']);
    $subject = sanitize_text_field($params['subject']);
    $message = wp_kses_post($params['message']);

    $stored_token = get_user_meta($user_id, 'auth_token', true);
    if ($stored_token !== $token) {
        return new WP_Error('invalid_token', 'Invalid token', array('status' => 401));
    }

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $sent = wp_mail($to, $subject, $message, $headers);

    if (!$sent) {
        return new WP_Error('email_failed', 'Failed to send email', array('status' => 400));
    }

    return array(
        'message' => 'Email sent successfully'
    );
      </div>
    </div>

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


<script>
  document.addEventListener('DOMContentLoaded', function () {
    var customCodeTextarea = document.getElementById('customCode');
    if (customCodeTextarea) {
      var editor = CodeMirror.fromTextArea(customCodeTextarea, {
        lineNumbers: true,
        mode: 'application/x-httpd-php',
        matchBrackets: true,
        indentUnit: 2,
        indentWithTabs: true,
        theme: 'default'
      });
    }
  });
</script>

<style>
  #code-example {
    background-color: #2e2e2e;
    /* Slightly lighter dark background */
    color: #00cc00;
    /* Less bright green text */
    font-family: 'Courier New', Courier, monospace;
    /* Monospace font */
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    overflow: auto;
    max-height: 250px;
    /* Limit height and allow scrolling */
  }

  #code-example pre {
    margin: 0;
    white-space: pre-wrap;
    /* Preserve whitespace and wrap lines */
  }

  #code-example strong {
    color: #ff6600;
    /* Less bright orange for highlighted text */
  }

  #customCodeGet,
  #customCodePost {
    background-color: #1a1a1a;
    /* Darker background for more contrast */
    color: #00ff00;
    /* Bright green text */
    font-family: 'Courier New', Courier, monospace;
    /* Monospace font */
    padding: 10px;
    border: 1px solid #00ff00;
    /* Bright green border */
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
    /* Green glow effect */
    width: 100%;
    height: 200px;
    /* Adjust height as needed */
    resize: vertical;
    /* Allow vertical resizing */
  }
</style>