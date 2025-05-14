<?php





$troutes = get_posts([
  'posts_per_page' => -1,
  'post_type' => 'hypership-route',
  'meta_key' => 'app_parent',
  'meta_value' => $app->ID,
]);
// var_dump($app);
?>




<?php
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




<!-- Routes & Functions Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🛤️ Custom Code 🔧</h2>




  <h3>My Classes</h3>
  <div style="font-size: 12px; xxxcolor: #888; margin-bottom: 15px;">
    🚧 Under construction 🚧
  </div>

  <hr />


  <h3>My Controllers</h3>
  <div style="font-size: 12px; xxxcolor: #888; margin-bottom: 15px;">
    🚧 Under construction 🚧
  </div>


  <hr />

  <h3>API Endpoints</h3>

  <div style="font-size: 12px; xxxcolor: #888; margin-bottom: 15px;">
    <div>

      Base URL:
    </div>
    <div>
      <code style="xxxcolor: #9cdcfe;">/wp-json/v1/hypershipx/<?php echo $app->post_name; ?></code>

    </div>
  </div>



  <?php
  foreach ($troutes as $troute) {

    ?>

    <div class="hypership-card-route">
      <div>
        <h4><?php echo $troute->post_title; ?></h4>
        <div>
          /<?php echo esc_html($troute->post_name); ?>

        </div>
      </div>
      <!-- <div>
      </div> -->
      <div>
        <a href="/wp-admin/post.php?post=<?php echo $troute->ID; ?>&action=edit">EDIT</a>
        //
        <a href="/wp-admin/admin.php?page=hypershipx_adminpage_fbuilder&route_id=<?php echo $troute->ID; ?>">BUILDER</a>
      </div>
    </div>

    <?php
  }
  ?>

  <div class="new-route-form"
    style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e9ecef;">
    <h3>Create New Endpoint</h3>
    <form method="post" action="">
      <?php wp_nonce_field('create_route_nonce', 'route_nonce'); ?>
      <input type="hidden" name="dashboard_routes_ok" value="1">
      <input type="hidden" name="app_parent" value="<?php echo esc_attr($app->ID); ?>">

      <div class="form-field">
        <label for="route_title">Title:</label>
        <input type="text" id="route_title" name="route_title" required>
      </div>

      <div class="form-field">
        <label for="route_path">Path:</label>
        <input type="text" id="route_path" name="route_path" required>
      </div>
      <div class="form-field">
        <label for="route_recipe">Recipe:</label>
        <div>

          <select id="route_recipe" name="route_recipe" required onchange="handleRecipeSelect(this)">
            <option value="">Select a recipe...</option>
            <?php foreach ($recipes_for_endpoints as $category => $paths) { ?>
              <optgroup label="<?php echo esc_attr($category); ?>">
                <?php foreach ($paths as $path => $details) { ?>
                  <option value="<?php echo esc_attr(json_encode($details)); ?>" data-path="<?php echo esc_attr($path); ?>">
                    <?php echo esc_html($details["Title"]); ?>
                  </option>
                <?php } ?>
              </optgroup>
            <?php } ?>
          </select>

          <script>
            function handleRecipeSelect(select) {
              const selectedOption = select.options[select.selectedIndex];
              if (selectedOption.value) {
                const details = JSON.parse(selectedOption.value);
                document.getElementById('route_title').value = details.Title;
                document.getElementById('route_path').value = selectedOption.dataset.path;
              }
            }
          </script>
        </div>
      </div>

      <div style="margin-top: 11px;">
        <button type="submit" name="create_route" class="button button-primary">Create Endpoint!</button>
      </div>
    </form>




    <div class="hypership-card-route" style="margin-top: 33px; display: none;">
      <div>
        <h3>Pre-Made Recipes for Endpoints</h3>
        <?php if (0)
          foreach ($recipes_for_endpoints as $category => $paths) { ?>
            <h4 class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'xxblurred'; ?>">
              <?php echo $category; ?>
            </h4>
            <?php foreach ($paths as $path) { ?>
              <div class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'blurred'; ?>">
                <?php echo $path["Title"]; ?>
              </div>
            <?php } ?>
          <?php } ?>
      </div>
    </div>





  </div>


</div>


<style>
  .hypership-autoroutes-list {
    background-color: #ededed;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
  }

  .blurred {
    filter: blur(5px);
    color: #888;
    font-style: italic;
  }
</style>