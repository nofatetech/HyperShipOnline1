<!-- Security Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🔒 Security 🛡️</h2>


    <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">



  <p>API Rate Limiting: Off <button>Edit</button></p>
  <p>Last Security Scan: <?php echo esc_html(get_post_meta($app_id, 'last_scan', true) ?: 'Never'); ?></p>

  <p>Security Status: <span
      class="status <?php echo esc_attr(get_post_meta($app_id, 'security_status', true) === 'issues' ? 'warning' : ''); ?>">
      <?php echo esc_html(get_post_meta($app_id, 'security_status', true) ?: 'Secure'); ?>
    </span></p>
  <p>Last Security Scan: <?php echo esc_html(get_post_meta($app_id, 'last_scan', true) ?: 'Never'); ?></p>
  <p>Two-Factor Authentication:
    <?php echo esc_html(get_post_meta($app_id, '2fa_enabled', true) ? 'Enabled' : 'Disabled'); ?>
  </p>


  <div class="security-dashboard">
    <!-- Security Stats Overview -->
    <div class="stats-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px;">
      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #dc3545;">
        <div style="font-size: 20px; font-weight: 500; color: #dc3545;">
          <?php echo esc_html(get_post_meta($app_id, 'failed_login_attempts', true) ?: '0'); ?> ⚠️
        </div>
        <div style="font-size: 12px; color: #666;">Failed Logins (24h)</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #28a745;">
        <div style="font-size: 20px; font-weight: 500; color: #28a745;">
          <?php echo esc_html(get_post_meta($app_id, 'active_sessions', true) ?: '0'); ?> 🔐
        </div>
        <div style="font-size: 12px; color: #666;">Active Sessions</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #ffc107;">
        <div style="font-size: 20px; font-weight: 500; color: #ffc107;">
          <?php echo esc_html(get_post_meta($app_id, 'api_calls_24h', true) ?: '0'); ?> 📊
        </div>
        <div style="font-size: 12px; color: #666;">API Calls (24h)</div>
      </div>

      <div class="stat-card" style="padding: 12px; border-radius: 6px; border-left: 3px solid #007cba;">
        <div style="font-size: 20px; font-weight: 500; color: #007cba;">
          <?php echo esc_html(get_post_meta($app_id, 'security_score', true) ?: '0'); ?>/100 🎯
        </div>
        <div style="font-size: 12px; color: #666;">Security Score</div>
      </div>
    </div>

    <!-- Security Features Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
      <!-- Security Settings -->
      <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Security Settings</h3>
        <div class="security-settings">
          <div class="setting-item">
            <label>API Rate Limiting</label>
            <select id="rate-limit-setting">
              <option value="off">Off</option>
              <option value="low">Low (100 req/min)</option>
              <option value="medium">Medium (50 req/min)</option>
              <option value="high">High (20 req/min)</option>
            </select>
          </div>
          <div class="setting-item">
            <label>Two-Factor Authentication</label>
            <select id="2fa-setting">
              <option value="disabled">Disabled</option>
              <option value="optional">Optional</option>
              <option value="required">Required</option>
            </select>
          </div>
          <div class="setting-item">
            <label>Session Timeout</label>
            <select id="session-timeout">
              <option value="15">15 minutes</option>
              <option value="30">30 minutes</option>
              <option value="60">1 hour</option>
              <option value="120">2 hours</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Recent Security Events -->
      <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Recent Security Events</h3>
        <div id="security-events-list">
          <!-- Events will be populated dynamically -->
        </div>
      </div>
    </div>

    <!-- Security Recommendations -->
    <div style="background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">Security Recommendations</h3>
      <div id="security-recommendations">
        <!-- Recommendations will be populated dynamically -->
      </div>
    </div>
  </div>

  <style>
    .security-settings {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .setting-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background: #f8f9fa;
      border-radius: 4px;
    }

    .setting-item label {
      font-weight: 500;
      color: #333;
    }

    .setting-item select {
      padding: 5px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      background: #fff;
    }

    #security-events-list {
      max-height: 300px;
      overflow-y: auto;
    }

    .security-event {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    .security-event:last-child {
      border-bottom: none;
    }

    .security-event .event-time {
      font-size: 12px;
      color: #666;
    }

    .security-event .event-type {
      font-weight: 500;
      color: #333;
    }

    .security-event .event-details {
      font-size: 13px;
      color: #666;
      margin-top: 5px;
    }

    #security-recommendations {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .recommendation {
      padding: 10px;
      background: #f8f9fa;
      border-radius: 4px;
      border-left: 3px solid #007cba;
    }

    .recommendation .recommendation-title {
      font-weight: 500;
      color: #333;
      margin-bottom: 5px;
    }

    .recommendation .recommendation-description {
      font-size: 13px;
      color: #666;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize security settings
      const rateLimitSetting = document.getElementById('rate-limit-setting');
      const twoFactorSetting = document.getElementById('2fa-setting');
      const sessionTimeout = document.getElementById('session-timeout');

      // Load current settings
      rateLimitSetting.value = '<?php echo esc_js(get_post_meta($app_id, 'rate_limit_setting', true) ?: 'off'); ?>';
      twoFactorSetting.value = '<?php echo esc_js(get_post_meta($app_id, '2fa_setting', true) ?: 'disabled'); ?>';
      sessionTimeout.value = '<?php echo esc_js(get_post_meta($app_id, 'session_timeout', true) ?: '30'); ?>';

      // Add event listeners for settings changes
      [rateLimitSetting, twoFactorSetting, sessionTimeout].forEach(select => {
        select.addEventListener('change', function () {
          // TODO: Implement settings update logic
          console.log(`${this.id} changed to ${this.value}`);
        });
      });

      // Populate security events
      const securityEventsList = document.getElementById('security-events-list');
      // TODO: Fetch and populate security events

      // Populate security recommendations
      const securityRecommendations = document.getElementById('security-recommendations');
      // TODO: Fetch and populate security recommendations
    });
  </script>



</div>
<!-- /allblured -->


</div>