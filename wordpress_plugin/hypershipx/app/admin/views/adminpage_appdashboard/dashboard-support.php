<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2 style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🎫 Support Dashboard
  </h2>

  <!-- News & Alerts Section -->
  <div class="support-news-section" style="margin-bottom: 25px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">📢 Latest News & Alerts</h3>
    <div class="news-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <?php
      // Fetch latest news/announcements
      $news_query = new WP_Query(array(
        'post_type' => 'announcement',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC'
      ));

      if ($news_query->have_posts()) :
        while ($news_query->have_posts()) : $news_query->the_post();
      ?>
        <div class="news-card" style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <h4 style="margin: 0 0 10px 0;"><?php the_title(); ?></h4>
          <p style="margin: 0; font-size: 14px;"><?php echo wp_trim_words(get_the_content(), 20); ?></p>
          <span style="font-size: 12px; color: #666;"><?php echo get_the_date(); ?></span>
        </div>
      <?php
        endwhile;
        wp_reset_postdata();
      else :
      ?>
        <p>No recent announcements.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Support Tickets Section -->
  <div class="support-tickets-section">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🎫 Support Tickets</h3>

    <?php
    // Check if Awesome Support plugin is active
    if (class_exists('Awesome_Support')) {
      // Display ticket statistics
      $open_tickets = wpas_get_tickets_count('open');
      $closed_tickets = wpas_get_tickets_count('closed');
    ?>
      <div class="ticket-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
        <div class="stat-card" style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="font-size: 24px; font-weight: bold; color: #007cba;"><?php echo $open_tickets; ?></div>
          <div style="font-size: 14px; color: #666;">Open Tickets</div>
        </div>
        <div class="stat-card" style="background: #fff; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="font-size: 24px; font-weight: bold; color: #28a745;"><?php echo $closed_tickets; ?></div>
          <div style="font-size: 14px; color: #666;">Closed Tickets</div>
        </div>
      </div>

      <!-- New Ticket Form -->
      <div class="new-ticket-form" style="background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin-top: 0; margin-bottom: 15px;">Create New Ticket</h4>
        <?php echo do_shortcode('[wpas_submit_ticket]'); ?>
      </div>

      <!-- Recent Tickets List -->
      <div class="recent-tickets" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin-top: 0; margin-bottom: 15px;">Recent Tickets</h4>
        <?php echo do_shortcode('[wpas_tickets]'); ?>
      </div>
    <?php
    } else {
    ?>
      <div class="notice" style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <p>Please install and activate the <a href="https://wordpress.org/plugins/awesome-support/" target="_blank">Awesome Support</a> plugin to enable ticket functionality.</p>
      </div>
    <?php
    }
    ?>
  </div>

  <!-- Support Resources -->
  <div class="support-resources" style="margin-top: 25px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">📚 Helpful Resources</h3>
    <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
      <a href="#" class="resource-card" style="background: #fff; padding: 15px; border-radius: 8px; text-decoration: none; color: inherit; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">📖 Documentation</h4>
        <p style="margin: 0; font-size: 14px;">Browse our comprehensive documentation</p>
      </a>
      <a href="#" class="resource-card" style="background: #fff; padding: 15px; border-radius: 8px; text-decoration: none; color: inherit; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">🎥 Video Tutorials</h4>
        <p style="margin: 0; font-size: 14px;">Watch step-by-step video guides</p>
      </a>
      <a href="#" class="resource-card" style="background: #fff; padding: 15px; border-radius: 8px; text-decoration: none; color: inherit; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h4 style="margin: 0 0 10px 0;">💬 Community Forum</h4>
        <p style="margin: 0; font-size: 14px;">Join our community discussions</p>
      </a>
    </div>
  </div>
</div>