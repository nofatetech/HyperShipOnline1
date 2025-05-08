
    <!-- Settings Section -->
    <div class="hypership-card">
      <h2
        style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
        ⚙️ Settings 🔧</h2>
      <p>App Status: <span
          class="status"><?php echo esc_html(get_post_status($app_id) === 'publish' ? 'Active' : 'Inactive'); ?></span>
      </p>
      <p>Last Updated: <?php echo esc_html(get_post_modified_time('F j, Y', false, $app_id)); ?></p>
      <p><a href="<?php echo get_edit_post_link($app_id); ?>">Edit App Settings</a></p>
    </div>
