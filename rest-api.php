<?php

define("API_URL", "api/v1");

$filters_default = [
    'sort_order'  => 'desc',
    'post_type'   => 'page',
    'post_status' => 'publish',
];

// Get all pages and custom fields
// localhost:8000/wp-json/api/v1/pages
function blog_get_pages()
{

    $pages = get_pages($filters_default);
    return get_custom_post($pages);
}

// Get page by slug and custom types
// localhost:8000/wp-json/api/v1/pages/home
function blog_get_page(WP_REST_Request $request)
{

    $param = $request->get_url_params();

    $args = [
        'name'        => $param['slug'],
        'post_type'   => 'page',
        'post_status' => 'publish',
    ];

    $pages = get_posts($args);
    return get_custom_post($pages);
}

// Extract Post Fields
function get_custom_post($pages)
{
    $data = [];
    foreach ($pages as &$page) {
        $data["ID"]          = $page->ID;
        $data['post_status'] = $page->post_status;
        $data['post_author'] = $page->post_author;
        $data['post_type']   = $page->post_type;
        $data['post_title']  = $page->post_title;

        // get custom fields
        $custom_fields         = get_fields($page->ID);
        $data['custom_fields'] = $custom_fields;
    }

    return $data;
}

add_action('rest_api_init', function () {

    register_rest_route(API_URL, '/pages', [
        'methods'  => 'GET',
        'callback' => 'blog_get_pages',
    ]);

    register_rest_route(API_URL, '/pages/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods'  => 'GET',
        'callback' => 'blog_get_page',
    ));

});
