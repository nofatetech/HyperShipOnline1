<?php

$mydomains = get_posts(array(
  'post_type' => 'hypership-domain',
  'author' => get_current_user_id(),
  'posts_per_page' => -1
));

// var_dump($mydomains);


?>

<div>
  <h2>Domains</h2>


  <div>
    <div class="domains-list">
      <?php foreach ($mydomains as $domain): ?>
        <div class="domain-card">
          <h3><?php echo esc_html($domain->post_title); ?></h3>

          <div class="domain-sections">
            <div class="section">
              <h4>Routes</h4>
              <div class="section-content">


                <?php
                $routes = get_posts(array(
                  'post_type' => 'hypership-route',
                  'meta_key' => 'domain_parent',
                  'meta_value' => $domain->ID,
                  'posts_per_page' => -1
                ));

                foreach ($routes as $route): ?>

                  <div class="hypership-card-route">
                    <div>
                      <h4><?php echo $route->post_title; ?></h4>
                      <div>
                        /<?php echo esc_html($route->post_name); ?>

                      </div>
                    </div>
                    <!-- <div>
      </div> -->
                    <div>
                      <a
                        href="/wp-admin/admin.php?page=hypershipx_adminpage_fbuilder&route_id=<?php echo $route->ID; ?>">BUILDER</a>
                    </div>
                  </div>



                <?php endforeach; ?>

                <div>


                  <div class="new-route-form"
                    style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px; border: 1px solid #e9ecef;">
                    <h3 xxxonclick="toggleForm(this)" xxxstyle="cursor: pointer;">Create New API Endpoint <span class="toggle-icon">▼</span></h3>
                    <form class="new-route-form-<?php echo $domain->ID; ?>" method="post" action="">
                      <?php wp_nonce_field('create_route_nonce', 'route_nonce'); ?>
                      <input type="hidden" name="dashboard_routes_ok" value="1">
                      <input type="hidden" name="app_parent" value="<?php echo esc_attr($app->ID); ?>">

                      <div class="form-field">
                        <label for="route_title">Title:</label>
                        <input type="text" id="route_title" name="route_title" required>
                      </div>

                      <div class="form-field">
                        <label for="route_path">Path:</label>
                        <input type="text" id="route_path" name="route_path" required>
                      </div>
                      <div class="form-field">
                        <label for="route_recipe">Recipe:</label>
                        <div>

                          <select id="route_recipe" name="route_recipe" required onchange="handleRecipeSelect(this)">
                            <option value="">Select a recipe...</option>
                            <?php foreach ($recipes_for_endpoints as $category => $paths) { ?>
                              <optgroup label="<?php echo esc_attr($category); ?>">
                                <?php foreach ($paths as $path => $details) { ?>
                                  <option value="<?php echo esc_attr(json_encode($details)); ?>"
                                    data-path="<?php echo esc_attr($path); ?>">
                                    <?php echo esc_html($details["Title"]); ?>
                                  </option>
                                <?php } ?>
                              </optgroup>
                            <?php } ?>
                          </select>

                          <script>
                            function handleRecipeSelect(select) {
                              const selectedOption = select.options[select.selectedIndex];
                              if (selectedOption.value) {
                                const details = JSON.parse(selectedOption.value);
                                document.getElementById('route_title').value = details.Title;
                                document.getElementById('route_path').value = selectedOption.dataset.path;
                              }
                            }
                          </script>
                        </div>
                      </div>

                      <div style="margin-top: 11px;">
                        <button type="submit" name="create_route" class="button button-primary">Create Endpoint!</button>
                      </div>
                    </formc>




                    <div class="hypership-card-route" style="margin-top: 33px; display: none;">
                      <div>
                        <h3>Pre-Made Recipes for Endpoints</h3>
                        <?php if (0)
                          foreach ($recipes_for_endpoints as $category => $paths) { ?>
                            <h4
                              class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'xxblurred'; ?>">
                              <?php echo $category; ?>
                            </h4>
                            <?php foreach ($paths as $path) { ?>
                              <div
                                class="<?php echo in_array($category, ['Authentication', 'Blog', 'Ecommerce']) ? '' : 'blurred'; ?>">
                                <?php echo $path["Title"]; ?>
                              </div>
                            <?php } ?>
                          <?php } ?>
                      </div>
                    </div>





                  </div>


                </div>

              </div>
            </div>

            <div class="section">
              <h4>Controllers</h4>
              <div class="section-content">
                <!-- Controllers content will go here -->
              </div>
            </div>

            <div class="section">
              <h4>Views</h4>
              <div class="section-content">
                <!-- Views content will go here -->
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <style>
      .domains-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px 0;
      }

      .domain-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.2s ease;
      }

      .domain-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      }

      .domain-card h3 {
        margin: 0 0 15px 0;
        color: #333;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
      }

      .domain-sections {
        display: grid;
        gap: 15px;
      }

      .section {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px;
      }

      .section h4 {
        margin: 0 0 10px 0;
        color: #555;
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .section-content {
        min-height: 50px;
      }
    </style>
  </div>

</div>