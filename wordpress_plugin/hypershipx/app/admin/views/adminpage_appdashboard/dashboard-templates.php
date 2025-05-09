<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    Templates & Themes
  </h2>
  <!-- Frontend Templates Section -->
  <div class="templates-section" style="margin-bottom: 30px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🎨 Frontend Templates</h3>

    <div class="templates-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <?php
      $templates = array(
        array(
          'name' => 'Basic App Template',
          'description' => 'A clean, minimal template for basic applications',
          'icon' => '📱'
        ),
        array(
          'name' => 'E-commerce Template',
          'description' => 'Complete template for online stores',
          'icon' => '🛍️'
        ),
        array(
          'name' => 'Social Network Template',
          'description' => 'Template for social media applications',
          'icon' => '👥'
        ),
        array(
          'name' => 'Dashboard Template',
          'description' => 'Admin dashboard with analytics',
          'icon' => '📊'
        )
      );

      foreach ($templates as $template) {
        ?>
        <div class="template-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="font-size: 24px; margin-bottom: 10px;"><?php echo $template['icon']; ?></div>
          <h4 style="margin: 0 0 10px 0;"><?php echo esc_html($template['name']); ?></h4>
          <p style="margin: 0; font-size: 14px; color: #666;"><?php echo esc_html($template['description']); ?></p>
          <button class="button button-primary" style="margin-top: 15px;">
            <span class="dashicons dashicons-download"></span>
            Use Template
          </button>
        </div>
        <?php
      }
      ?>
    </div>
  </div>

  <!-- Backend Routes Section -->
  <div class="routes-section">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🛣️ Backend Routes</h3>

    <div class="routes-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
      <?php
      $routes = array(
        array(
          'name' => 'Authentication Routes',
          'description' => 'Login, register, and user management endpoints',
          'endpoints' => array('/auth/login', '/auth/register', '/auth/profile')
        ),
        array(
          'name' => 'Data Management Routes',
          'description' => 'CRUD operations for data management',
          'endpoints' => array('/api/data', '/api/data/:id', '/api/data/search')
        ),
        array(
          'name' => 'File Management Routes',
          'description' => 'Upload, download, and file operations',
          'endpoints' => array('/api/files/upload', '/api/files/download', '/api/files/list')
        ),
        array(
          'name' => 'Analytics Routes',
          'description' => 'Data collection and reporting endpoints',
          'endpoints' => array('/api/analytics/collect', '/api/analytics/report', '/api/analytics/dashboard')
        )
      );

      foreach ($routes as $route) {
        ?>
        <div class="route-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <h4 style="margin: 0 0 10px 0;"><?php echo esc_html($route['name']); ?></h4>
          <p style="margin: 0 0 15px 0; font-size: 14px; color: #666;"><?php echo esc_html($route['description']); ?></p>
          <div class="endpoints" style="background: #f8f9fa; padding: 10px; border-radius: 4px;">
            <?php foreach ($route['endpoints'] as $endpoint) { ?>
              <div style="font-family: monospace; font-size: 13px; margin-bottom: 5px;">
                <?php echo esc_html($endpoint); ?>
              </div>
            <?php } ?>
          </div>
          <button class="button button-primary" style="margin-top: 15px;">
            <span class="dashicons dashicons-code-standards"></span>
            View Documentation
          </button>
        </div>
        <?php
      }
      ?>
    </div>
  </div>

  <style>
    .button {
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .dashicons {
      font-size: 16px;
      width: 16px;
      height: 16px;
    }
  </style>


</div>