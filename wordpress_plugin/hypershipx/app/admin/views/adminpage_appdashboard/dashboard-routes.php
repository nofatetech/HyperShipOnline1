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

  <div class="hypership-autoroutes-list" xxxstyle="background-color: #ededed;">
    <h3>Available Routes:</h3>
    <div style="font-weight: bold;">
      All start with:
      <br>
      /wp-json/v1/hypershipx/<?php echo $app->post_name; ?>
    </div>
    <br>
    <h4>Auth</h4>
    <div>/auth/register</div>
    <div>/auth/login_email_password</div>
    <div>/auth/logout</div>
    <h4>Blog</h4>
    <div>/blog/post_list</div>
    <h4>Ecommerce</h4>
    <div>/ecommerce/ai_recommendations</div>
    <div>/ecommerce/products</div>
    <div>/ecommerce/orders</div>
    <div>/ecommerce/orders/ORDER_ID</div>
    <div>/ecommerce/orders/ORDER_ID/add_product/PRODUCT_ID</div>
    <div>/ecommerce/orders/ORDER_ID/checkout</div>
    <h4>Events</h4>
    <div>/events/events</div>
    <div>/events/EVENT_ID/register_attendee</div>
    <h4>Security</h4>
    <div>/security/turn_all_off_now</div>
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