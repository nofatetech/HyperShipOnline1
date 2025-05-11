<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('userRegistrationChart');
    if (!ctx) return;

    const data = {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [
        {
          label: 'New Registrations',
          data: [12, 19, 15, 8, 22, 14, 17],
          borderColor: '#007cba',
          backgroundColor: 'rgba(0, 124, 186, 0.1)',
          tension: 0.4,
          fill: true
        },
        {
          label: 'Active Users',
          data: [45, 52, 48, 55, 60, 58, 62],
          borderColor: '#28a745',
          backgroundColor: 'rgba(40, 167, 69, 0.1)',
          tension: 0.4,
          fill: true
        }
      ]
    };

    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 5
            }
          }
        }
      }
    };

    const chart = new Chart(ctx, config);
    chart.canvas.parentNode.style.height = '210px';
  });
</script>

<?php
$tregistrations = get_posts([
  'post_type' => 'hyp-app-registration',
  'posts_per_page' => -1,
  'meta_query' => [
    [
      'key' => 'hypership_app',

      'value' => $app_id,
      'compare' => '='
    ]
  ]
]);
// var_dump($tregistrations);
?>

<!-- Users Section -->
<div class="hypership-card">
  <h2
    style="font-family: 'Elite', monospace; text-transform: uppercase; letter-spacing: 2px; border-bottom: 2px solid #007cba; padding-bottom: 10px;">
    👥 Users 👤 👨‍💻</h2>

  <!-- <div style="text-align: right; margin: 10px 0;">
    <a href="#" style="color: #007cba; text-decoration: none; font-size: 13px; opacity: 0.8; transition: opacity 0.2s ease;">✨ Free plan: 50 users limit - Upgrade for unlimited</a>
  </div> -->

  <?php
  $tf = HYPERSHIPX_PLUGIN_DIR . 'myapps/' . $app->post_name . '/includes/hook__app_page_dashboard__card_users__before.php';
  if (is_file($tf)) {
    require_once $tf;
  }
  ?>

  <div style="xxbackground-color: #999;">
    <div class="user-stats-grid" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
      <div class="stat-card"
        style="flex: 1; min-width: 0; padding: 12px; text-align: center; border-bottom: 2px solid #007cba;">
        <div style="font-size: 20px; font-weight: 500; color: #007cba;">
          <?php echo esc_html(get_post_meta($app_id, 'total_users', true) ?: '0'); ?>
        </div>
        <div style="font-size: 13px; color: #666;">Total Users</div>
      </div>

      <div class="stat-card"
        style="flex: 1; min-width: 0; padding: 12px; text-align: center; border-bottom: 2px solid #28a745;">
        <div style="font-size: 20px; font-weight: 500; color: #28a745;">
          <?php echo esc_html(get_post_meta($app_id, 'active_users', true) ?: '0'); ?>
        </div>
        <div style="font-size: 13px; color: #666;">Active Users (30d)</div>
      </div>

      <div class="stat-card"
        style="flex: 1; min-width: 0; padding: 12px; text-align: center; border-bottom: 2px solid #ffc107;">
        <div style="font-size: 20px; font-weight: 500; color: #ffc107;">
          <?php echo esc_html(get_post_meta($app_id, 'new_users', true) ?: '0'); ?>
        </div>
        <div style="font-size: 13px; color: #666;">New Registrations (30d)</div>
      </div>
    </div>


    <div>
      <div style="xxbackground: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0;">
        <!-- <h4 style="margin-top: 0;">Stats</h4> -->


        <div>
          <!-- <h5>User Registration History</h5> -->
          <div>

            <canvas id="userRegistrationChart"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>


  <div style="border: 0px solid black; margin-bottom: 11px;">


    <!-- <h4>User Registrations</h4> -->
    <!-- <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; color: #333;">User Registrations</h3> -->


    <?php
    // Pagination setup
    $users_per_page = 2;
    $current_page = isset($_GET['page_users']) ? max(1, intval($_GET['page_users'])) : 1;
    $total_users = count($tregistrations);
    $total_pages = ceil($total_users / $users_per_page);

    // Get paginated registrations
    $offset = ($current_page - 1) * $users_per_page;
    $paginated_registrations = array_slice($tregistrations, $offset, $users_per_page);

    // Build pagination links
    $pagination_links = '';
    if ($total_pages > 1) {
      $pagination_links .= '<div class="tablenav-pages">';
      $pagination_links .= '<span class="displaying-num">' . $total_users . ' items</span>';
      $pagination_links .= '<span class="pagination-links">';

      // First page link
      if ($current_page > 1) {
        $pagination_links .= '<a class="first-page button" href="' . add_query_arg('page_users', 1) . '"><span class="screen-reader-text">First page</span><span aria-hidden="true">&laquo;</span></a>';
      } else {
        $pagination_links .= '<span class="first-page button disabled"><span class="screen-reader-text">First page</span><span aria-hidden="true">&laquo;</span></span>';
      }

      // Previous page link
      if ($current_page > 1) {
        $pagination_links .= '<a class="prev-page button" href="' . add_query_arg('page_users', $current_page - 1) . '"><span class="screen-reader-text">Previous page</span><span aria-hidden="true">&lsaquo;</span></a>';
      } else {
        $pagination_links .= '<span class="prev-page button disabled"><span class="screen-reader-text">Previous page</span><span aria-hidden="true">&lsaquo;</span></span>';
      }

      // Current page info
      $pagination_links .= '<span class="paging-input">' . $current_page . ' of <span class="total-pages">' . $total_pages . '</span></span>';

      // Next page link
      if ($current_page < $total_pages) {
        $pagination_links .= '<a class="next-page button" href="' . add_query_arg('page_users', $current_page + 1) . '"><span class="screen-reader-text">Next page</span><span aria-hidden="true">&rsaquo;</span></a>';
      } else {
        $pagination_links .= '<span class="next-page button disabled"><span class="screen-reader-text">Next page</span><span aria-hidden="true">&rsaquo;</span></span>';
      }

      // Last page link
      if ($current_page < $total_pages) {
        $pagination_links .= '<a class="last-page button" href="' . add_query_arg('page_users', $total_pages) . '"><span class="screen-reader-text">Last page</span><span aria-hidden="true">&raquo;</span></a>';
      } else {
        $pagination_links .= '<span class="last-page button disabled"><span class="screen-reader-text">Last page</span><span aria-hidden="true">&raquo;</span></span>';
      }

      $pagination_links .= '</span></div>';
    }

    echo '<div class="pagination-container" style="display: flex; justify-content: center; align-items: center; margin: 20px 0; gap: 8px;">';
    echo '<div class="pagination-info" style="font-size: 0.9em; color: #666; margin-right: 15px;">' . $total_users . ' items</div>';

    if ($total_pages > 1) {
        // First & Previous
        echo '<div class="pagination-controls" style="display: flex; gap: 4px;">';

        // First page
        if ($current_page > 1) {
            echo '<a href="' . add_query_arg('page_users', 1) . '" class="pagination-button" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #007cba; transition: all 0.2s;">&laquo;</a>';
        } else {
            echo '<span class="pagination-button disabled" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #999; cursor: not-allowed;">&laquo;</span>';
        }

        // Previous page
        if ($current_page > 1) {
            echo '<a href="' . add_query_arg('page_users', $current_page - 1) . '" class="pagination-button" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #007cba; transition: all 0.2s;">&lsaquo;</a>';
        } else {
            echo '<span class="pagination-button disabled" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #999; cursor: not-allowed;">&lsaquo;</span>';
        }

        // Current page indicator
        echo '<span class="pagination-current" style="padding: 6px 12px; background: #007cba; color: white; border-radius: 4px;">' . $current_page . '</span>';

        // Next & Last
        // Next page
        if ($current_page < $total_pages) {
            echo '<a href="' . add_query_arg('page_users', $current_page + 1) . '" class="pagination-button" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #007cba; transition: all 0.2s;">&rsaquo;</a>';
        } else {
            echo '<span class="pagination-button disabled" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #999; cursor: not-allowed;">&rsaquo;</span>';
        }

        // Last page
        if ($current_page < $total_pages) {
            echo '<a href="' . add_query_arg('page_users', $total_pages) . '" class="pagination-button" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #007cba; transition: all 0.2s;">&raquo;</a>';
        } else {
            echo '<span class="pagination-button disabled" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #999; cursor: not-allowed;">&raquo;</span>';
        }

        echo '</div>';
    }
    echo '</div>';


    $tregistrations = get_posts([
      'post_type' => 'hyp-app-registration',
      'posts_per_page' => $users_per_page,
      'paged' => $current_page,
      'meta_query' => [
        [
          'key' => 'hypership_app',
          'value' => $app_id,
          'compare' => '='
        ]
      ]
    ]);

    ?>

    <?php

    // update_post_meta($app_id, 'users_json', json_encode([]));


    $tappinfo = hypershipx_helper_app_get_info($app_id);
    // var_dump($tappinfo['data']);


    // // Get existing users list from post meta
    // $tusers = json_decode( get_post_meta($app_id, 'users_json', true) );
    // // $tusers = get_field( "users", $app_id );
    // if (!is_array($tusers)) {
    //   $tusers = [];
    // }
    // $wp_users = get_users(['include' => $tusers]);
    // foreach ([['id' => 1, 'username' => "user1", 'email' => "user1@test.com", 'created_at' => "2025-03-03 00:00:00",], ['id' => 2, 'username' => "user7", 'email' => "user7@test.com", 'created_at' => "2025-03-03 00:00:00",],] as $titem) { // ($tappinfo['data']['registrations'] as $titem) {
    foreach ($tregistrations as $tregistration) {
      $tuser = get_user(get_post_meta($tregistration->ID, 'user', true));
      // var_dump($tuser);
      // require_once plugin_dir_path(HYPERSHIPX_PLUGIN_DIR) . 'app/admin/views/view_element_post_hyp_app_registration.php';
      ?>

      <?php
      $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/view_element_post_hyp_app_registration.php';
      if (is_file($tf)) {
        require $tf;
      }
      ?>


      <?php
    }
    // var_dump($tusers);//die();
    ?>

  </div>





  <?php
  $tf = HYPERSHIPX_PLUGIN_DIR . 'myapps/' . $app->post_name . '/includes/hook__app_page_dashboard__card_users__after.php';
  if (is_file($tf)) {
    require_once $tf;
  }
  ?>


</div>