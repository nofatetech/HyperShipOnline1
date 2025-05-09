<?php

$app_id = isset($_GET['app_id']) ? intval($_GET['app_id']) : 0;
if (!$app_id || get_post_type($app_id) !== 'hypership-app') {
  wp_die('Invalid or missing app ID.');
}
$app = get_post($app_id);
?>
<div class="wrap" style="xbackground: #f8f9fa;">
  <!-- <h1>App Dashboard: <?php echo esc_html($app->post_title); ?></h1> -->
  <!--
    Font suggestions:
    - 'Poppins' - Modern, clean, professional yet friendly
    - 'Montserrat' - Strong, contemporary, versatile
    - 'Roboto' - Google's workhorse, balanced and readable
    - 'Inter' - Modern, highly legible, great for UI
    - 'Source Sans Pro' - Adobe's clean, professional choice
  -->
  <h1
    style="font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 600; letter-spacing: 0.5px; color: #1d2327; margin-bottom: 20px; xxborder-bottom: 2px solid #007cba; padding-bottom: 10px;">
    <?php echo esc_html($app->post_title); ?>
  </h1>

  <p><a href="<?php echo admin_url('edit.php?post_type=hypership-app'); ?>" class="button">Back to Apps</a></p>

  <style>
    .hypership-dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .hypership-card {
      /* background: #fff; */
      border: 1px solid #c3c4c7;
      border-radius: 4px;
      padding: 20px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .hypership-card h2 {
      font-family: 'Elite', monospace;
      text-transform: uppercase;
      letter-spacing: 2px;
      border-bottom: 2px solid #007cba;
      padding-bottom: 10px;
      margin: 0 0 15px;
      font-size: 18px;
      color: #1d2327;
    }

    .hypership-card p {
      margin: 0 0 10px;
      color: #3c434a;
    }

    .hypership-card .status {
      font-weight: bold;
      color: #007cba;
    }

    .hypership-card .status.warning {
      color: #d63638;
    }

    .hypership-card-route {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 15px;
      margin-bottom: 10px;
      background: #f8f9fa;
      border-radius: 4px;
      border-left: 4px solid #007cba;
      transition: all 0.2s ease;
    }

    .hypership-card-route:hover {
      background: #f0f0f1;
      transform: translateX(5px);
    }

    .hypership-card-route h4 {
      margin: 0;
      color: #1d2327;
      font-size: 14px;
      font-weight: 600;
    }

    .hypership-card-route a {
      color: #007cba;
      text-decoration: none;
      font-size: 12px;
      font-weight: 500;
      padding: 4px 8px;
      border-radius: 3px;
      transition: all 0.2s ease;
    }

    .hypership-card-route a:hover {
      background: #007cba;
      color: white;
    }

    .hypership-card-user-info {
      xxxdisplay: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      background: linear-gradient(135deg, rgb(150, 181, 212), rgb(203, 217, 227));
      border-radius: 12px;
      margin-bottom: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      /* color: white; */
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .hypership-card-user-info:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .hypership-card-user-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .hypership-card-user-info .user-details {
      flex: 1;
    }

    .hypership-card-user-info .user-name {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 4px;
    }

    .hypership-card-user-info .user-role {
      font-size: 13px;
      opacity: 0.9;
    }
  </style>

  <div class="hypership-dashboard">




    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-users.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>


    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-events.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    // die();
    ?>


    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-community.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>


    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-support.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>



    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-marketing.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>


    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-deploy.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>



    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-multiplayer.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-ecommerce.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-datatypes.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-routes.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-security.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-gamification.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>


    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-templates.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-analytics.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>

    <?php
    $tf = HYPERSHIPX_PLUGIN_DIR . 'app/admin/views/adminpage_appdashboard/dashboard-settings.php';
    if (is_file($tf)) {
      require_once $tf;
    }
    ?>




  </div>
</div>