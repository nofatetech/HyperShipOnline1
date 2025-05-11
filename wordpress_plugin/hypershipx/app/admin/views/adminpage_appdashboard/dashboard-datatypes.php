<!-- Data Types Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    📊 Data Types 📈
  </h2>

  <!-- Quick Actions -->
  <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <a href="/wp-admin/post-new.php?post_type=acf-post-type"><button class="button button-primary" xxxonclick="createDataType()">+ New</button></a>
    <button class="button" onclick="importDataType()">Import</button>
    <button class="button" onclick="exportData()">Export</button>
  </div>


  <!-- Data Types Grid -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; max-width: 100%;">
    <?php


    foreach ($datatypes as $type) {
      // echo '<pre>';
      // var_dump($type);
      // echo '</pre>';
      ?>

      <div class="data-type-card"
        style="background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
          <h3 style="margin: 0; font-size: 16px;"><?php echo esc_html($type->labels->singular_name); ?></h3>
          <div class="actions" style="display: flex; gap: 5px;">
            <!-- <a href="<?php echo admin_url('edit.php?post_type=' . $type->name); ?>"><button class="button" style="padding: 2px 8px;">Edit</button></a> -->
            <a href="<?php echo admin_url('edit.php?post_type=' . $type->name); ?>"><button class="button" style="padding: 2px 8px;">Records</button></a>
          </div>
        </div>
        <div style="font-size: 13px; color: #666;">
          <div>Records count: <?php echo number_format(wp_count_posts($type->name)->publish); ?></div>
          <div>Last updated: <?php
            $latest_post = get_posts(array(
              'post_type' => $type->name,
              'posts_per_page' => 1,
              'orderby' => 'modified',
              'order' => 'DESC'
            ));
            echo $latest_post ? date('M j, Y', strtotime($latest_post[0]->post_modified)) : 'Never';
          ?></div>
          <div>Fields: <?php
            $fields = [];
            // Method 1: Get ACF fields for the post type
            $field_groups = acf_get_field_groups(array('post_type' => $type->name));
            $fields = array();
            foreach ($field_groups as $group) {
                $fields = array_merge($fields, acf_get_fields($group['key']));
            }
            // echo '<pre>';
            // var_dump($fields);
            // echo '</pre>';
            // Method 2: Get all registered fields and filter by post type
            // $fields = acf_get_fields();
            // $fields = array_filter($fields, function($field) use ($type) {
            //     return in_array($type->name, $field['post_type']);
            // });

            // Method 3: Get fields from a specific field group assigned to this post type
            // $field_groups = acf_get_field_groups(array('post_type' => $type->name));
            // $fields = array();
            // foreach ($field_groups as $group) {
            //     $fields = array_merge($fields, acf_get_fields($group['key']));
            // }
            echo $fields ? count($fields) : '0';
          ?></div>
        </div>
        <div>
          <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
            <span class="dashicons dashicons-database" style="color: #007cba;"></span>
            <span style="color: #666; font-size: 13px;">Data Operations:</span>
            <a href="" class="xxxbutton xxxbutton-small" style="padding: 2px 8px; text-decoration: none;">
              <span class="dashicons dashicons-download" style="font-size: 14px; margin-right: 4px;"></span>
              Export
            </a>
            <a href="" class="xxxbutton xxxbutton-small" style="padding: 2px 8px; text-decoration: none;">
              <span class="dashicons dashicons-upload" style="font-size: 14px; margin-right: 4px;"></span>
              Import
            </a>
          </div>
          <div style="margin-top: 11px;">
            <div>Type definitions..</div>
            <a href="#" onclick="document.getElementById('languageLinks').style.display = document.getElementById('languageLinks').style.display === 'none' ? 'block' : 'none'; return false;"></a>
            <div id="languageLinks" style="xxxdisplay: none; margin-top: 5px;">
                <a href="#" style="margin-right: 10px;">GDScript</a>
                <a href="#" style="margin-right: 10px;">JavaScript</a>
                <!-- <a href="#" style="margin-right: 10px;">TypeScript</a> -->
                <!-- <a href="#" style="margin-right: 10px;">Python</a> -->
                <!-- <a href="#" style="margin-right: 10px;">Java</a> -->
                <!-- <a href="#" style="margin-right: 10px;">C#</a> -->
                <!-- <a href="#" style="margin-right: 10px;">Go</a> -->
            </div>
          </div>
        </div>
      </div>
    <?php
    }


    ?>
</div>



<div style="background: #f5f5f5; padding: 15px; border-radius: 4px; margin: 10px 0;">
  <a href="#" onclick="toggleDataTypeForm(); return false;" style="display: block; margin-bottom: 10px; text-decoration: none;">
    <span class="dashicons dashicons-arrow-down-alt2"></span> Select Data Types
  </a>

  <div id="datatypeForm" style="display: none;">
    <form method="post" action="">
      <input type="hidden" name="dashboard_datatypes_ok" value="1">
      <?php wp_nonce_field('datatypes_nonce', 'datatypes_nonce'); ?>
      <div>
        <textarea name="datatypes" id="datatypes" style="width: 100%; height: 60px;"><?php echo esc_textarea(get_post_meta($app->ID, 'hypership_data_types', true)); ?></textarea>
      </div>
      <button type="submit" name="submit_datatypes" class="button button-primary">Save Data Types</button>
    </form>
  </div>
</div>

<script>
function toggleDataTypeForm() {
  const form = document.getElementById('datatypeForm');
  const icon = document.querySelector('.dashicons-arrow-down-alt2');
  if (form.style.display === 'none') {
    form.style.display = 'block';
    icon.classList.remove('dashicons-arrow-down-alt2');
    icon.classList.add('dashicons-arrow-up-alt2');
  } else {
    form.style.display = 'none';
    icon.classList.remove('dashicons-arrow-up-alt2');
    icon.classList.add('dashicons-arrow-down-alt2');
  }
}
</script>




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