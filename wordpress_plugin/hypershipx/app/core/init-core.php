<?php

// Activation hook
register_activation_hook(__FILE__, function () {
  // Generate API key if not exists
  if (!get_option('hypershipx_api_key')) {
      update_option('hypershipx_api_key', wp_generate_password(32, false));
  }
});

// Deactivation hook
register_deactivation_hook(__FILE__, function () {
  // Clean up if needed
});



