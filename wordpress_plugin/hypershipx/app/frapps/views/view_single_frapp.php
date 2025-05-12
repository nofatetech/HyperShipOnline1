<?php
// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Get the current post
global $post;

// Check if the post object is available
if ($post) {
    $post_title = get_the_title($post->ID);
} else {
    $post_title = 'No Post Found';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($post_title); ?></title>
    <link rel="stylesheet" href="<?php echo HYPERSHIPX_PLUGIN_URL . 'assets/css/style.css'; ?>">

    <script src="https://unpkg.com/htmx.org@2.0.4"></script>

    <script src="<?php echo HYPERSHIPX_PLUGIN_URL . 'app/frapps/assets/frapp.js'; ?>"></script>
</head>
<body>
    <h1><?php echo esc_html($post_title); ?></h1>

     <!-- have a button POST a click via AJAX -->
  <button hx-post="/clicked" hx-swap="outerHTML">
    Click Me
  </button>


</body>
</html>