<?php





$troutes = get_posts([
  'posts_per_page' => -1,
  'post_type' => 'hypership-route',
  'meta_key' => 'app_parent',
  'meta_value' => $app->ID,
]);
// var_dump($app);
?>



<!-- Routes & Functions Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🛤️ API Endpoints & Code 🔧</h2>



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

      <button type="submit" name="create_route" class="button button-primary">Create Endpoint!</button>
    </form>
  </div>



  <?php
  $routes = [
    'Authentication' => [
      '/users/register',
      '/users/login_email_password',
      '/users/logout',
      '/users/profile',
    ],
    'Blog' => [
      '/blog/posts'
    ],
    'Ecommerce' => [
      '/ecommerce/ai_recommendations',
      '/ecommerce/products',
      '/ecommerce/orders',
      '/ecommerce/orders',
      '/ecommerce/orders/add_product',
      '/ecommerce/orders/checkout'
    ],
    'Events' => [
      '/events/events',
      '/events/register_attendee'
    ],
    'Multiplayer' => [
      '/multiplayer/rooms',
      '/multiplayer/rooms/create',
      '/multiplayer/rooms/join',
      '/multiplayer/rooms/leave',
      '/multiplayer/rooms/players'
    ],
    'Gamification' => [
      '/gamification/points',
      '/gamification/badges',
      '/gamification/leaderboard',
      '/gamification/challenges/create',
      '/gamification/challenges/complete'
    ],
    'Analytics' => [
      '/analytics/xxx',
      '/analytics/xxx',
      '/analytics/xxx',
      '/analytics/xxx/create',
    ],
    'Security' => [
      '/security/turn_all_off_now'
    ]
  ];
  ?>
  <div class="hypership-card-route" style="margin-top: 33px;">
    <div>
      <h3>Pre-Made API Endpoints</h3>
      <?php foreach ($routes as $category => $paths) { ?>
        <h4 class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'xxblurred'; ?>">
          <?php echo $category; ?>
        </h4>
        <?php foreach ($paths as $path) { ?>
          <div class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'blurred'; ?>">
            <?php echo $path; ?>
          </div>
        <?php } ?>
      <?php } ?>
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