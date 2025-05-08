<!-- Data Types Section -->
<div class="hypership-card">
  <h2 style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    📊 Data Types 📈
  </h2>

  <!-- Quick Actions -->
  <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <button class="button button-primary" onclick="createDataType()">+ New</button>
    <button class="button" onclick="importDataType()">Import</button>
    <button class="button" onclick="exportData()">Export</button>
  </div>

  <!-- Data Types Grid -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; max-width: 100%;">
    <?php
    $data_types = get_posts([
      'post_type' => 'hyp-data-type',
      'posts_per_page' => -1,
      'meta_query' => [
        [
          'key' => 'hypership_app',
          'value' => $app_id,
          'compare' => '='
        ]
      ]
    ]);

    // Add mock data types if none exist
    if (empty($data_types)) {
      $mock_types = [
        [
          'title' => 'User Profiles',
          'records' => '1,234',
          'updated' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
          'title' => 'Product Catalog',
          'records' => '567',
          'updated' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ]
      ];

      foreach ($mock_types as $mock) {
        ?>
        <div class="data-type-card" style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h3 style="margin: 0; font-size: 16px;"><?php echo esc_html($mock['title']); ?></h3>
            <div class="actions" style="display: flex; gap: 5px;">
              <button class="button" style="padding: 2px 8px;">Edit</button>
              <button class="button" style="padding: 2px 8px;">Del</button>
            </div>
          </div>
          <div style="font-size: 13px; color: #666;">
            <div>Records: <?php echo esc_html($mock['records']); ?></div>
            <div>Last Updated: <?php echo date('M j, Y', strtotime($mock['updated'])); ?></div>
          </div>
        </div>
        <?php
      }
    } else {
      foreach ($data_types as $type) {
        $total_records = get_post_meta($type->ID, 'total_records', true) ?: '0';
        $last_updated = get_post_meta($type->ID, 'last_updated', true) ?: $type->post_modified;
        $emojis = get_post_meta($type->ID, 'emojis', true) ?: '📊';
        ?>
        <div class="data-type-card" style="background: linear-gradient(135deg, #ffffff, #f8f9fa); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05); transition: transform 0.2s ease;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <span style="font-size: 24px;"><?php echo esc_html($emojis); ?></span>
              <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1d2327;"><?php echo esc_html($type->post_title); ?></h3>
            </div>
            <div class="actions" style="display: flex; gap: 8px;">
              <button class="button" onclick="editDataType(<?php echo $type->ID; ?>)" style="padding: 4px 12px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">Edit</button>
              <button class="button" onclick="deleteDataType(<?php echo $type->ID; ?>)" style="padding: 4px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Del</button>
            </div>
          </div>
          <div style="font-size: 13px; color: #666; background: rgba(0,0,0,0.02); padding: 10px; border-radius: 6px;">
            <div style="margin-bottom: 5px;">📝 Records: <?php echo esc_html($total_records); ?></div>
            <div>🕒 Last Updated: <?php echo date('M j, Y', strtotime($last_updated)); ?></div>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
</div>

<script>
function createDataType() {
  console.log('Create new data type');
}

function editDataType(id) {
  console.log('Edit data type:', id);
}

function deleteDataType(id) {
  console.log('Delete data type:', id);
}

function importDataType() {
  console.log('Import data type');
}

function exportData() {
  console.log('Export data');
}
</script>