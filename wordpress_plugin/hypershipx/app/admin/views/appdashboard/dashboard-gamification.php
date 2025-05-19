<!-- Gamification Dashboard -->
<div class="hypership-card gamification-dashboard">
  <div class="dashboard-header">
    <h2 class="dashboard-title">🏆 Gamification Dashboard</h2>


    <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">



    <div class="dashboard-stats">
      <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
          <span class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'total_users', true) ?: '0'); ?></span>
          <span class="stat-label">Total Users</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">⭐</div>
        <div class="stat-content">
          <span class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'points_awarded', true) ?: '0'); ?></span>
          <span class="stat-label">Total Points</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">👑</div>
        <div class="stat-content">
          <span
            class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'top_user_points', true) ?: '0'); ?></span>
          <span class="stat-label">Top User Points</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">🏅</div>
        <div class="stat-content">
          <span
            class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'badges_unlocked', true) ?: '0'); ?></span>
          <span class="stat-label">Badges</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">🎯</div>
        <div class="stat-content">
          <span
            class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'active_challenges', true) ?: '0'); ?></span>
          <span class="stat-label">Challenges</span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📈</div>
        <div class="stat-content">
          <span
            class="stat-value"><?php echo esc_html(get_post_meta($app_id, 'avg_points_per_user', true) ?: '0'); ?></span>
          <span class="stat-label">Avg Points/User</span>
        </div>
      </div>
    </div>
  </div>
  <style>
    .gamification-dashboard {
      padding: 20px;
      xxxbackground: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .dashboard-header {
      margin-bottom: 20px;
    }

    .dashboard-title {
      font-family: 'Elite', monospace;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: #2c3e50;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #007cba;
    }

    .dashboard-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .stat-card {
      display: flex;
      align-items: center;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 6px;
      transition: transform 0.2s;
    }

    .stat-card:hover {
      transform: translateY(-2px);
    }

    .stat-icon {
      font-size: 24px;
      margin-right: 15px;
    }

    .stat-content {
      display: flex;
      flex-direction: column;
    }

    .stat-value {
      font-size: 24px;
      font-weight: bold;
      color: #2c3e50;
    }

    .stat-label {
      font-size: 14px;
      color: #6c757d;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
  </style>
</div>
<!-- /allblured -->


</div>