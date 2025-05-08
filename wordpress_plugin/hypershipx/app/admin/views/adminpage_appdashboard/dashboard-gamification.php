
    <!-- Gamification Section -->
    <div class="hypership-card">
      <h2
        style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
        🏆 Gamification 🎮</h2>
      <p>Points Awarded: <?php echo esc_html(get_post_meta($app_id, 'points_awarded', true) ?: '0'); ?></p>
      <p>Badges Unlocked: <?php echo esc_html(get_post_meta($app_id, 'badges_unlocked', true) ?: '0'); ?></p>
      <p>Active Challenges: <?php echo esc_html(get_post_meta($app_id, 'active_challenges', true) ?: '0'); ?></p>
    </div>
