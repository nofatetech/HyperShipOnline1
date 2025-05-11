<!-- Analytics Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    📈 Analytics 📊</h2>

  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">



    <p>Page Views (Last 30 Days): <?php echo esc_html(get_post_meta($app_id, 'page_views', true) ?: '0'); ?></p>
    <p>Average Session Duration: <?php echo esc_html(get_post_meta($app_id, 'session_duration', true) ?: '0 min'); ?>
    </p>
    <p>Bounce Rate: <?php echo esc_html(get_post_meta($app_id, 'bounce_rate', true) ?: '0%'); ?></p>
  </div>



<!-- /allblured -->


</div>