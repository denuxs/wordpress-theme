<?php

// Get all posts and custom fields
function blog_get_posts( $params ) {
  $posts =  get_posts();

  $data = [];
  foreach($posts as $post ) {
    $data["post_title"] = $post->post_title;
    $data['custom_fields'] = get_post_meta($post->ID);
  }

  return $data;
  // return new WP_REST_Response('Howdy!!');
}

add_action('rest_api_init', function() {
  register_rest_route( 'blog/v1', '/posts', [
    'methods' => 'GET',
    'callback' => 'blog_get_posts',
    'permission_callback' => '__return_true',
  ] );
} );