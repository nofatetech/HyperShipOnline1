<?php





$posts = get_posts([
  'posts_per_page' => -1,
  'post_type' => 'hypership-route',
  'meta_key' => 'app_parent',
  'meta_value' => $app->ID,
]);
// var_dump($posts);
?>



<!-- Routes & Functions Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🛤️ Routes & Functions 🔧</h2>

  <?php
  foreach ($posts as $tpost) {

    ?>

    <div class="hypership-card-route">
      <div>
        <h4><?php echo $tpost->post_title; ?></h4>
        <div>
          <?php echo esc_html($tpost->post_name); ?>

        </div>
      </div>
      <!-- <div>
      </div> -->
      <div>
        <a href="/wp-admin/post.php?post=110&action=edit">EDIT</a>
        //
        <a href="/wp-admin/admin.php?page=hypershipx_adminpage_fbuilder&route_id=<?php echo $tpost->ID; ?>">BUILDER</a>
      </div>
    </div>

    <?php
  }
  ?>

  <div class="new-route-form" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e9ecef;">
    <h3>Create New Route</h3>
    <form method="post" action="">
      <?php wp_nonce_field('create_route_nonce', 'route_nonce'); ?>
      <input type="hidden" name="app_parent" value="<?php echo esc_attr($app->ID); ?>">

      <div class="form-field">
        <label for="route_title">Route Title:</label>
        <input type="text" id="route_title" name="route_title" required>
      </div>

      <div class="form-field">
        <label for="route_path">Route Path:</label>
        <input type="text" id="route_path" name="route_path" required>
      </div>

      <button type="submit" name="create_route" class="button button-primary">Create Route</button>
    </form>
  </div>
  <div class="hypership-autoroutes-list" style="font-family: 'Consolas', monospace; background: #1e1e1e; padding: 15px; border-radius: 4px; border: 1px solid #333;">
    <h3 style="font-size: 14px; margin: 0 0 12px; color: #e0e0e0;">API Endpoints</h3>

    <div style="font-size: 12px; color: #888; margin-bottom: 15px;">
      Base URL: <code style="color: #9cdcfe;">/wp-json/v1/hypershipx/<?php echo $app->post_name; ?></code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Authentication</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /auth/register</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /auth/login_email_password</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /auth/logout</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Blog</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /blog/post_list</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Ecommerce</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /ecommerce/ai_recommendations</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /ecommerce/products</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /ecommerce/orders</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /ecommerce/orders/{order_id}</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /ecommerce/orders/{order_id}/add_product/{product_id}</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /ecommerce/orders/{order_id}/checkout</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Events</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /events/events</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /events/{event_id}/register_attendee</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Multiplayer</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /multiplayer/rooms</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /multiplayer/rooms/create</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /multiplayer/rooms/{room_id}/join</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /multiplayer/rooms/{room_id}/leave</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /multiplayer/rooms/{room_id}/players</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Gamification</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /gamification/points</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /gamification/badges</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">GET /gamification/leaderboard</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /gamification/challenges/create</code>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /gamification/challenges/{challenge_id}/complete</code>
    </div>

    <div style="margin-bottom: 15px;">
      <h4 style="font-size: 13px; color: #e0e0e0; margin: 0 0 8px;">Security</h4>
      <code style="display: block; margin: 4px 0; color: #9cdcfe;">POST /security/turn_all_off_now</code>
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
</style>