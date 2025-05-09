<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🛣️ Our Community
  </h2>


  <div class="community-grid"
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
    <!-- Forum Stats -->
    <div class="stats-section">
      <h3 style="font-size: 16px; margin-bottom: 15px; color: #1d2327;">Forum Statistics</h3>

      <div class="stats-card"
        style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <div class="stat-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
          <span style="color: #666;">Total Members</span>
          <span style="font-weight: 600;">1,234</span>
        </div>
        <div class="stat-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
          <span style="color: #666;">Active Topics</span>
          <span style="font-weight: 600;">567</span>
        </div>
        <div class="stat-item" style="display: flex; justify-content: space-between;">
          <span style="color: #666;">New Posts Today</span>
          <span style="font-weight: 600;">89</span>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="activity-section">
      <h3 style="font-size: 16px; margin-bottom: 15px; color: #1d2327;">Recent Activity</h3>

      <div class="activity-card"
        style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <?php
        $recent_activities = array(
          array(
            'user' => 'JohnDoe',
            'action' => 'posted in',
            'topic' => 'Getting Started Guide',
            'time' => '5 min ago',
            'icon' => '💬'
          ),
          array(
            'user' => 'JaneSmith',
            'action' => 'created topic',
            'topic' => 'Feature Request: Dark Mode',
            'time' => '15 min ago',
            'icon' => '📝'
          ),
          array(
            'user' => 'TechGuru',
            'action' => 'replied to',
            'topic' => 'API Documentation',
            'time' => '1 hour ago',
            'icon' => '↩️'
          )
        );

        foreach ($recent_activities as $activity) {
          ?>
          <div class="activity-item"
            style="display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
            <span style="font-size: 18px;"><?php echo $activity['icon']; ?></span>
            <div style="flex: 1;">
              <div style="font-size: 13px;">
                <strong><?php echo esc_html($activity['user']); ?></strong>
                <?php echo esc_html($activity['action']); ?>
                <strong><?php echo esc_html($activity['topic']); ?></strong>
              </div>
              <div style="font-size: 12px; color: #666;"><?php echo esc_html($activity['time']); ?></div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="actions-section">
      <h3 style="font-size: 16px; margin-bottom: 15px; color: #1d2327;">Quick Actions</h3>

      <div class="actions-card"
        style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <button class="button button-primary"
          style="width: 100%; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <span class="dashicons dashicons-plus-alt"></span>
          New Topic
        </button>
        <button class="button"
          style="width: 100%; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <span class="dashicons dashicons-groups"></span>
          Manage Users
        </button>
        <button class="button"
          style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;">
          <span class="dashicons dashicons-admin-settings"></span>
          Forum Settings
        </button>
      </div>
    </div>
  </div>

  <style>
    .stats-card:hover,
    .activity-card:hover,
    .actions-card:hover {
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transform: translateY(-1px);
      transition: all 0.2s ease;
    }

    .activity-item:last-child {
      border-bottom: none;
    }
  </style>

</div>