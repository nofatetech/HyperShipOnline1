<!-- Monetization & Ecommerce Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    Frontend Apps </h2>


  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="xxxallblured">


    <div
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-bottom: 20px;">
      <?php
      // Get the current xapp ID
      // $xapp_id = get_the_ID(); // Assuming this is called within the xapp context

      // Query apps that belong to this xapp
      $frontend_apps = get_posts(array(
        'post_type' => 'xapp',
        'posts_per_page' => -1,
        // 'meta_query' => array(
        //   array(
        //     'key' => 'app_parent',
        //     'value' => $app_id,
        //     'compare' => '='
        //   )
        // )
      ));
      // var_dump($frontend_apps);

      foreach ($frontend_apps as $app):
        // Get app metadata
        $app_type = get_post_meta($app->ID, 'app_type', true) ?: 'Web App';
        $app_icon = get_post_meta($app->ID, 'app_icon', true) ?: '📱';
        $app_status = get_post_meta($app->ID, 'app_status', true) ?: 'Active';
        $app_users = get_post_meta($app->ID, 'app_users', true) ?: '0';
        $app_link = get_post_meta($app->ID, 'app_link', true) ?: '#';
      ?>
        <div
          style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <div style="font-size: 24px;"><?php echo esc_html($app_icon); ?></div>
            <div>
              <div style="font-size: 16px; font-weight: 600; color: #1d2327;">
                <?php echo esc_html($app->post_title); ?>
              </div>
              <div style="font-size: 13px; color: #666;">
                <?php echo esc_html($app_type); ?>
              </div>
            </div>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 13px; color: #666;">
            <div>
              <span style="color: <?php echo $app_status === 'Active' ? '#28a745' : '#ffc107'; ?>;">
                <?php echo esc_html($app_status); ?>
              </span>
            </div>
            <div><?php echo esc_html($app_users); ?> users</div>
          </div>
          <div style="display: flex; gap: 8px; margin-top: 12px;">
            <a href="<?php echo esc_url($app_link); ?>"
              style="flex: 1; text-align: center; padding: 8px; background: #007cba; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
              Open App
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=hypershipx_adminpage_frontendapp_builder&app_id=' . $app->ID)); ?>"
              style="flex: 1; text-align: center; padding: 8px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
              Edit App
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Animate app cards on load
  gsap.from('.app-card', {
    duration: 0.6,
    y: 20,
    opacity: 0,
    stagger: 0.1,
    ease: 'power2.out'
  });

  // Add hover animations
  const appCards = document.querySelectorAll('.app-card');
  appCards.forEach(card => {
    card.addEventListener('mouseenter', () => {
      gsap.to(card, {
        duration: 0.3,
        y: -5,
        boxShadow: '0 4px 12px rgba(0,0,0,0.1)',
        ease: 'power2.out'
      });
    });

    card.addEventListener('mouseleave', () => {
      gsap.to(card, {
        duration: 0.3,
        y: 0,
        boxShadow: '0 2px 4px rgba(0,0,0,0.05)',
        ease: 'power2.out'
      });
    });
  });
});
</script>