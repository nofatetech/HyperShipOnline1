
    <!-- Security Section -->
    <div class="hypership-card">
      <h2
        style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
        🔒 Security 🛡️</h2>
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
    </div>
