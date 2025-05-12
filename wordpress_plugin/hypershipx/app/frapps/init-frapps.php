<?php

add_filter('single_template', function($template) {
    global $post;

    if ($post->post_type === 'hypership-frapp') {
        // Get the custom template path
        $custom_template = HYPERSHIPX_PLUGIN_DIR . 'app/frapps/views/view_single_frapp.php';

        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }

    return $template;
});
