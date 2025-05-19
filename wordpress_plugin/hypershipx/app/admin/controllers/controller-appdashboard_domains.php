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
                  <div class="route-item">
                    <div class="route-title"><?php echo esc_html($route->post_title); ?></div>
                    <div class="route-slug"><?php echo esc_html($route->post_name); ?></div>
                  </div>
                  <hr>
                <?php endforeach; ?>


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