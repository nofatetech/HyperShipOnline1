<!-- Monetization & Ecommerce Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    💰 Monetization & Ecommerce 🛒</h2>
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px;">
    <!-- Revenue Stats -->
    <div style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <div style="font-size: 24px; margin-bottom: 8px;">💰</div>
      <div style="font-size: 13px; color: #666;">Total Revenue</div>
      <div style="font-size: 20px; font-weight: 600; color: #1d2327;">
        <?php echo esc_html(get_post_meta($app_id, 'total_revenue', true) ?: '$0.00'); ?>
      </div>
    </div>

    <!-- Order Stats -->
    <div style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <div style="font-size: 24px; margin-bottom: 8px;">📦</div>
      <div style="font-size: 13px; color: #666;">Orders</div>
      <div style="font-size: 20px; font-weight: 600; color: #1d2327;">
        <?php echo esc_html(get_post_meta($app_id, 'total_orders', true) ?: '0'); ?>
      </div>
      <div style="font-size: 12px; color: #666; margin-top: 4px;">
        <?php echo esc_html(get_post_meta($app_id, 'pending_orders', true) ?: '0'); ?> pending
      </div>
    </div>

    <!-- Average Order Value -->
    <div style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
      <div style="font-size: 24px; margin-bottom: 8px;">📊</div>
      <div style="font-size: 13px; color: #666;">Avg Order Value</div>
      <div style="font-size: 20px; font-weight: 600; color: #1d2327;">
        <?php echo esc_html(get_post_meta($app_id, 'avg_order_value', true) ?: '$0.00'); ?>
      </div>
    </div>
  </div>

  <!-- Popular Products -->
  <div style="background: linear-gradient(135deg, #ffffff, #f8f9fa); padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-top: 15px;">
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
      <span style="font-size: 20px;">🔥</span>
      <h3 style="margin: 0; font-size: 16px;">Popular Products</h3>
    </div>
    <?php
    $popular_products = get_post_meta($app_id, 'popular_products', true) ?: [];
    if (!empty($popular_products)) {
      foreach (array_slice($popular_products, 0, 3) as $product) {
        ?>
        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0,0,0,0.05);">
          <div style="font-size: 13px;"><?php echo esc_html($product['name']); ?></div>
          <div style="font-size: 13px; color: #666;"><?php echo esc_html($product['sales']); ?> sales</div>
        </div>
        <?php
      }
    } else {
      echo '<div style="font-size: 13px; color: #666;">No product data available</div>';
    }
    ?>
  </div>
</div>
