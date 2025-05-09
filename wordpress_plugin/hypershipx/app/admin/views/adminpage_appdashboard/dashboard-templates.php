<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    Templates & Themes
  </h2>
  <!-- Frontend Templates Section -->
  <div class="templates-section" style="margin-bottom: 30px;">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🎨 Frontend Templates</h3>

    <div class="template-category" style="margin-bottom: 25px;">
      <h3 style="color: #1d2327; margin-bottom: 10px;">Godot/Redot</h3>
      <div class="template-details" style="padding-left: 15px;">
        <h4 style="color: #50575e; margin: 8px 0;">Platforms</h4>
        <ul style="list-style-type: none; padding-left: 0; margin: 0 0 15px 0;">
          <li>📱 Multimedia</li>
          <li>🎮 Multiplatform</li>
          <li>🎯 Game</li>
          <li>💻 App</li>
        </ul>

        <h4 style="color: #50575e; margin: 8px 0;">Example Templates</h4>
        <ul style="list-style-type: none; padding-left: 0; margin: 0;">
          <li>🎹 MIDI Piano</li>
          <li>🎵 Audio Player</li>
          <li>⚔️ RPG Game</li>
          <li>📦 Inventory System</li>
          <li>🐦 Flappy Bird Style Game</li>
        </ul>
      </div>
    </div>

    <div class="template-category">
      <h3 style="color: #1d2327; margin-bottom: 10px;">JS/HTML/CSS</h3>
      <div class="template-details" style="padding-left: 15px;">
        <h4 style="color: #50575e; margin: 8px 0;">Platforms</h4>
        <ul style="list-style-type: none; padding-left: 0; margin: 0 0 15px 0;">
          <li>🌐 Web</li>
          <li>📱 Mobile</li>
          <li>💻 Desktop</li>
        </ul>

        <h4 style="color: #50575e; margin: 8px 0;">Frameworks</h4>
        <ul style="list-style-type: none; padding-left: 0; margin: 0;">
          <li>⚡ Vue.js</li>
          <li>🚀 Svelte</li>
          <li>⚡ HTMX</li>
          <li>🔄 Backbone.js</li>
        </ul>
      </div>
    </div>


    <hr>

    <?php if (false) : ?>


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

    <?php endif; ?>



  </div>

  <!-- Backend Routes Section -->
  <div class="routes-section">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🛣️ Backend Routes</h3>


    <?php if (false) : ?>

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
    <?php endif; ?>

    <div>

    </div>



  </div>


    <!-- Backend Routes Section -->
    <div class="routes-section">
    <h3 style="font-size: 18px; margin-bottom: 15px;">🛣️ APIs and Services</h3>

    <div>

    </div>
  <div class="api-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
    <?php
    $apis = array(
      array(
        'name' => 'Spotify API',
        'description' => 'Access music data, playlists, and user information',
        'endpoints' => array('/v1/me', '/v1/playlists', '/v1/tracks'),
        'icon' => '🎵'
      ),
      array(
        'name' => 'OpenWeather API',
        'description' => 'Weather forecasts and current conditions',
        'endpoints' => array('/data/2.5/weather', '/data/2.5/forecast'),
        'icon' => '🌤️'
      ),
      array(
        'name' => 'News API',
        'description' => 'Latest news articles and headlines',
        'endpoints' => array('/v2/top-headlines', '/v2/everything', '/v2/sources'),
        'icon' => '📰'
      ),
      array(
        'name' => 'GitHub API',
        'description' => 'Access repositories, users, and code data',
        'endpoints' => array('/repos', '/users', '/search/code'),
        'icon' => '💻'
      ),
      array(
        'name' => 'Unsplash API',
        'description' => 'High-quality stock photos and images',
        'endpoints' => array('/photos', '/search/photos', '/collections'),
        'icon' => '📸'
      ),
      array(
        'name' => 'YouTube API',
        'description' => 'Video content and channel information',
        'endpoints' => array('/v3/videos', '/v3/channels', '/v3/playlists'),
        'icon' => '🎥'
      )
    );

    foreach ($apis as $api) {
      ?>
      <div class="api-card" style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
          <span style="font-size: 20px;"><?php echo $api['icon']; ?></span>
          <h4 style="margin: 0; font-size: 15px;"><?php echo esc_html($api['name']); ?></h4>
        </div>
        <p style="margin: 0 0 10px 0; font-size: 13px; color: #666; line-height: 1.4;"><?php echo esc_html($api['description']); ?></p>
        <button class="button button-primary" style="margin-top: 8px; padding: 4px 8px; font-size: 12px;">
          <span class="dashicons dashicons-code-standards"></span>
          Docs
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