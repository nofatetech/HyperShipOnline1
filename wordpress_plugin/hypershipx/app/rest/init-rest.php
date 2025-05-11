<?php



// add_action( 'rest_api_init', function () {
//   // register_rest_route( 'myplugin/v1', '/author/(?P<id>\d+)', array(
//   //   'methods' => 'GET',
//   //   'callback' => 'my_awesome_func',
//   // ) );
// } );

add_action('rest_api_init', 'hypershipx__action__register_rest_routes');

function hypershipx__action__register_rest_routes()
{

  // Custom Routes

  // get hypership app route posts
  // $args = array(
  //   'numberposts' => 100,
  //   'post_type'   => 'hypership-app'
  // );
  // $tapps = get_posts($args);
  // // var_dump($tapps);
  // foreach ($tapps as $tapp) {
  // }
  $args = array(
    'post_type' => 'hypership-route',
    'posts_per_page' => -1,
    // 'meta_query' => array(
    //   array(
    //     'key' => 'app_parent',
    //     'value' => 1,
    //     'compare' => '=',
    //     'type' => 'NUMERIC'
    //   )
    // )
  );
  $tcustom_routes = get_posts($args);
  foreach ($tcustom_routes as $route) {
    $app_parent = get_post_meta($route->ID, 'app_parent', true);
    if (!$app_parent) continue;

    $app = get_post($app_parent);
    if (!$app) continue;

    $customCodeGet = get_post_meta($route->ID, 'customCodeGet', true);
    $customCodePost = get_post_meta($route->ID, 'customCodePost', true);

    // echo '<pre>';
    // var_dump($customCodeGet);
    // var_dump($customCodePost);
    // echo '</pre>';
    // die();

    if (!empty($customCodeGet)) {
      register_rest_route('hypershipx/v1', '/' . $app->post_name . '/' . $route->post_name, [
        'methods' => 'GET',
        'callback' => function($request) use ($route, $customCodeGet) {
          try {
            $temp_function = function($request) use ($customCodeGet) {
                return eval($customCodeGet);
            };
            $result = $temp_function($request);
            return $result;
          } catch (Exception $e) {
            return new WP_Error('custom_code_error', $e->getMessage(), ['status' => 500]);
          }
        },
        'permission_callback' => '__return_true',
        'args' => []
      ]);
    }

    if (!empty($customCodePost)) {
      register_rest_route('hypershipx/v1', '/' . $app->post_name . '/' . $route->post_name, [
        'methods' => 'POST',
        'callback' => function($request) use ($route, $customCodePost) {
          try {
            $temp_function = function($request) use ($customCodePost) {
                return eval($customCodePost);
            };
            $result = $temp_function($request);
            return $result;
          } catch (Exception $e) {
            return new WP_Error('custom_code_error', $e->getMessage(), ['status' => 500]);
          }
        },
        'permission_callback' => '__return_true',
        'args' => []
      ]);
    }
  }
  // echo '<pre>';
  // var_dump($routes);
  // echo '</pre>';
  // die();




  // Pre-Made Routes

  register_rest_route('hypershipx/v1', '/(?P<appslug>[a-zA-Z0-9-]+)/auth/register', [
    // register_rest_route('hypershipx/v1', '/auth/register', [
    'methods' => 'POST',
    'callback' => 'hypershipx__routecontroller__auth_register',
    'permission_callback' => '__return_true', // Allow public access; adjust for security if needed
    'args' => [
      'appslug' => [
        'required' => true,
        'validate_callback' => 'validate_appslug',
        'sanitize_callback' => 'sanitize_text_field',
      ],
      'email' => [
        'required' => true,
        'validate_callback' => 'is_email',
        'sanitize_callback' => 'sanitize_email',
      ],
      'username' => [
        'required' => true,
        'sanitize_callback' => 'sanitize_user',
      ],
      'password' => [
        'required' => true,
        'sanitize_callback' => 'sanitize_text_field',
      ],
    ],
  ]);

  function validate_appslug($value, $request, $param)
  {
    $post = get_posts([
      'post_type' => 'hypership-app',
      'post_status' => 'publish',
      'name' => $value,
      'numberposts' => 1,
    ]);
    return !empty($post);
  }




}


// Handle user registration and add to post's Users list
function hypershipx__routecontroller__auth_register(WP_REST_Request $request)
{

  $appslug = $request->get_param('appslug');
  $email = $request->get_param('email');
  $username = $request->get_param('username');
  $password = $request->get_param('password');

  // Get the app post by slug
  $app = get_posts([
    'post_type' => 'hypership-app',
    'post_status' => 'publish',
    'name' => $appslug,
    'numberposts' => 1,
  ]);

  if (empty($app)) {
    return new WP_Error(
      'invalid_appslug',
      'Invalid app slug provided.',
      ['status' => 404]
    );
  }
  $app_id = $app[0]->ID;

  // Register the user
  $user_id = wp_insert_user([
    'user_login' => $username,
    'user_email' => $email,
    'user_pass' => $password,
    'role' => 'customer',
  ]);

  if (is_wp_error($user_id)) {
    return new WP_Error(
      'user_creation_failed',
      $user_id->get_error_message(),
      ['status' => 400]
    );
  }

  // Get existing users list from post meta
  $users = json_decode(get_post_meta($app_id, 'users_json', true));
  // $users = get_field( "users", $app_id );
  if (!is_array($users)) {
    $users = [];
  }
  // var_dump($users);die();

  // Add new user ID to the list if not already present
  if (!in_array($user_id, $users)) {
    $users[$user_id] = [
      'created_at' => date('Y-m-d H:i:s'),
    ];
    update_post_meta($app_id, 'users_json', json_encode($users));
  }

  return new WP_REST_Response([
    'success' => true,
    'user_id' => $user_id,
    'app_id' => $app_id,
    'message' => 'User registered and added to app users list.',
  ], 201);
}


function hypershipx_helper_app_get_info($app_id)
{
  $post = get_post($app_id);
  $data = [
    'registrations' => get_post_meta($app_id, 'registrations')
  ];
  $rett = [
    'post' => $post,
    'data' => $data,
  ];
  return $rett;
}


