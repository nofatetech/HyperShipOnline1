<!-- Monetization & Ecommerce Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    Frontend Apps </h2>


  <style>
    .allblured {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
  </style>
  <div class="allblured">


    <div
      style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-bottom: 20px;">
      <?php
      $frontend_apps = [
        [
          'title' => 'E-commerce Dashboard',
          'type' => 'Web App',
          'icon' => '🛍️',
          'link' => 'https://shop.example.com',
          'status' => 'Active',
          'users' => '1.2k'
        ],
        [
          'title' => 'Mobile POS',
          'type' => 'Mobile App',
          'icon' => '📱',
          'link' => 'https://pos.example.com',
          'status' => 'Active',
          'users' => '850'
        ],
        [
          'title' => 'Inventory Manager',
          'type' => 'Desktop App',
          'icon' => '💻',
          'link' => 'https://inventory.example.com',
          'status' => 'Beta',
          'users' => '320'
        ],
        [
          'title' => 'Analytics Portal',
          'type' => 'Web App',
          'icon' => '📊',
          'link' => 'https://analytics.example.com',
          'status' => 'Active',
          'users' => '2.5k'
        ]
      ];

      foreach ($frontend_apps as $frapp): ?>
        <div
          style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
            <div style="font-size: 24px;"><?php echo esc_html($frapp['icon']); ?></div>
            <div>
              <div style="font-size: 16px; font-weight: 600; color: #1d2327;"><?php echo esc_html($frapp['title']); ?>
              </div>
              <div style="font-size: 13px; color: #666;"><?php echo esc_html($frapp['type']); ?></div>
            </div>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 13px; color: #666;">
            <div>
              <span style="color: <?php echo $frapp['status'] === 'Active' ? '#28a745' : '#ffc107'; ?>;">
                <?php echo esc_html($frapp['status']); ?>
              </span>
            </div>
            <div><?php echo esc_html($frapp['users']); ?> users</div>
          </div>
          <div style="display: flex; gap: 8px; margin-top: 12px;">
            <a href="<?php echo esc_url($frapp['link']); ?>"
              style="flex: 1; text-align: center; padding: 8px; background: #007cba; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
              Open App
            </a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=hypershipx_adminpage_frontendapp_builder&app_id=')); ?>"
              style="flex: 1; text-align: center; padding: 8px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
              Edit App
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>