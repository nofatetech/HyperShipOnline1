<!-- Support Dashboard Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    🛣️ Deploying your app
  </h2>


  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">


    <div class="deploy-grid"
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px;">
      <!-- Backend Deployments -->
      <div class="deploy-section">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #1d2327;">Backend Deployments</h3>

        <!-- Production -->
        <div class="deploy-card"
          style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 15px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h4 style="margin: 0; font-size: 14px;">Production</h4>
            <span
              style="background: #46b450; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Live</span>
          </div>
          <p style="margin: 0 0 10px 0; font-size: 13px; color: #666;">api.production.example.com</p>
          <div style="display: flex; gap: 8px;">
            <button class="button button-primary" style="padding: 4px 8px; font-size: 12px;">
              <span class="dashicons dashicons-update"></span>
              Deploy
            </button>
            <button class="button" style="padding: 4px 8px; font-size: 12px;">
              <span class="dashicons dashicons-visibility"></span>
              View
            </button>
          </div>
        </div>

        <!-- Staging -->
        <div class="deploy-card"
          style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h4 style="margin: 0; font-size: 14px;">Staging</h4>
            <span
              style="background: #ffb900; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Testing</span>
          </div>
          <p style="margin: 0 0 10px 0; font-size: 13px; color: #666;">api.staging.example.com</p>
          <div style="display: flex; gap: 8px;">
            <button class="button button-primary" style="padding: 4px 8px; font-size: 12px;">
              <span class="dashicons dashicons-update"></span>
              Deploy
            </button>
            <button class="button" style="padding: 4px 8px; font-size: 12px;">
              <span class="dashicons dashicons-visibility"></span>
              View
            </button>
          </div>
        </div>
      </div>

      <!-- Frontend Deployments -->
      <div class="deploy-section">
        <h3 style="font-size: 16px; margin-bottom: 15px; color: #1d2327;">Frontend Deployments</h3>

        <?php
        $frontend_apps = array(
          array(
            'name' => 'Web App',
            'prod_url' => 'app.example.com',
            'staging_url' => 'staging.app.example.com',
            'icon' => '🌐'
          ),
          array(
            'name' => 'Mobile App',
            'prod_url' => 'mobile.example.com',
            'staging_url' => 'staging.mobile.example.com',
            'icon' => '📱'
          ),
          array(
            'name' => 'Desktop App',
            'prod_url' => 'desktop.example.com',
            'staging_url' => 'staging.desktop.example.com',
            'icon' => '💻'
          )
        );

        foreach ($frontend_apps as $titem) {
          ?>
          <div class="deploy-card"
            style="background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
              <span style="font-size: 20px;"><?php echo $titem['icon']; ?></span>
              <h4 style="margin: 0; font-size: 14px;"><?php echo esc_html($titem['name']); ?></h4>
            </div>

            <!-- Production -->
            <div style="margin-bottom: 10px;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #666;">Production</span>
                <span
                  style="background: #46b450; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Live</span>
              </div>
              <p style="margin: 5px 0; font-size: 13px; color: #666;"><?php echo esc_html($titem['prod_url']); ?></p>
            </div>

            <!-- Staging -->
            <div style="margin-bottom: 10px;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 12px; color: #666;">Staging</span>
                <span
                  style="background: #ffb900; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px;">Testing</span>
              </div>
              <p style="margin: 5px 0; font-size: 13px; color: #666;"><?php echo esc_html($titem['staging_url']); ?></p>
            </div>

            <div style="display: flex; gap: 8px;">
              <button class="button button-primary" style="padding: 4px 8px; font-size: 12px;">
                <span class="dashicons dashicons-update"></span>
                Deploy
              </button>
              <button class="button" style="padding: 4px 8px; font-size: 12px;">
                <span class="dashicons dashicons-visibility"></span>
                View
              </button>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

    <style>
      .deploy-card:hover {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
        transition: all 0.2s ease;
      }
    </style>


  </div>
  <!-- /allblured -->


</div>