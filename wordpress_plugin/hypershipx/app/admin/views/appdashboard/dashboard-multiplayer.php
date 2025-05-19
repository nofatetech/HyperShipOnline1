<!-- Multiplayer Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🎮 Multiplayer 🎲</h2>

  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">


    <div class="multiplayer-stats"
      style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
      <div class="stat-box" style="background: #f8f9fa; padding: 12px; border-radius: 6px;">
        <div style="font-size: 0.9em; color: #666;">Active Rooms</div>
        <div style="font-size: 1.4em; font-weight: bold;">
          <?php echo esc_html(get_post_meta($app_id, 'active_rooms', true) ?: '0'); ?>
        </div>
      </div>
      <div class="stat-box" style="background: #f8f9fa; padding: 12px; border-radius: 6px;">
        <div style="font-size: 0.9em; color: #666;">Online Players</div>
        <div style="font-size: 1.4em; font-weight: bold;">
          <?php echo esc_html(get_post_meta($app_id, 'online_players', true) ?: '0'); ?>
        </div>
      </div>
    </div>

    <div class="quick-actions" style="margin-bottom: 20px;">
      <a href="#" class="button"
        style="display: inline-block; padding: 8px 15px; background: #007cba; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">Create
        Room</a>
      <a href="#" class="button"
        style="display: inline-block; padding: 8px 15px; background: #f8f9fa; color: #333; text-decoration: none; border-radius: 4px;">View
        All Rooms</a>
    </div>

    <div class="recent-activity" style="background: #f8f9fa; padding: 15px; border-radius: 6px;">
      <h3 style="font-size: 1em; margin: 0 0 10px;">Recent Activity</h3>
      <div style="font-size: 0.9em;">
        <div style="margin-bottom: 8px;">• Room "Space Warriors" created</div>
        <div style="margin-bottom: 8px;">• 5 players joined "Galaxy Quest"</div>
        <div>• Room "Star Fleet" completed</div>
      </div>
    </div>
  </div>
  <!-- /allblured -->


</div>