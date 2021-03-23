<?php

define("API_URL", "api/v1");
define("HOME_TEMPLATE", "plantilla");

// Get all pages and custom fields
// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/pages
function blog_get_pages()
{
    $args = [
        'sort_order'  => 'desc',
        'post_type'   => 'page',
        'post_status' => 'publish',
    ];

    $pages = get_pages($args);
    $data  = [];
    $index = 0;
    foreach ($pages as $page) {
        $data[$index]["ID"]          = $page->ID;
        $data[$index]['post_status'] = $page->post_status;
        $data[$index]['post_author'] = $page->post_author;
        $data[$index]['post_type']   = $page->post_type;
        $data[$index]['post_title']  = $page->post_title;

        // get custom fields
        $custom_fields = get_fields($page->ID);

        $data[$index]['custom_fields'] = $custom_fields["plantilla"];
        $index += 1;

    }

    return $data;
}

// Get page by slug and custom types
// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/pages/{slug}
function blog_get_page(WP_REST_Request $request)
{

    $param = $request->get_url_params();

    $args = [
        'name'        => $param['slug'],
        'post_type'   => 'page',
        'post_status' => 'publish',
    ];

    $pages = get_posts($args);
    $data  = [];
    foreach ($pages as $page) {
        $data["ID"]          = $page->ID;
        $data['post_status'] = $page->post_status;
        $data['post_author'] = $page->post_author;
        $data['post_type']   = $page->post_type;
        $data['post_title']  = $page->post_title;

        // get custom fields
        $custom_fields = get_fields($page->ID);

        $data['custom_fields'] = $custom_fields["plantilla"];

    }

    return $data;
}

// Get Custom Type News
// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/news
function blog_get_news()
{
    $args = [
        'sort_order'  => 'desc',
        'post_type'   => 'noticias',
        'post_status' => 'publish',
    ];

    $news  = get_posts($args);
    $data  = [];
    $index = 0;
    foreach ($news as $page) {
        $data[$index]["ID"]          = $page->ID;
        $data[$index]['post_status'] = $page->post_status;
        $data[$index]['post_author'] = $page->post_author;
        $data[$index]['post_type']   = $page->post_type;
        $data[$index]['post_title']  = $page->post_title;

        // get custom fields

        $data[$index]['custom_fields'] = get_fields($page->ID);
        $index += 1;

    }

    return $data;
}

// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/news/cards

function blog_get_news_card()
{
    $args = [
        'sort_order'  => 'desc',
        'post_type'   => 'noticias',
        'post_status' => 'publish',
    ];

    $news  = get_posts($args);
    $data  = [];
    $index = 0;
    foreach ($news as $page) {
        $data[$index]["ID"]          = $page->ID;
        $data[$index]['post_status'] = $page->post_status;
        $data[$index]['post_author'] = $page->post_author;
        $data[$index]['post_type']   = $page->post_type;
        $data[$index]['post_title']  = $page->post_title;

        // get custom fields
        $fields = get_fields($page->ID);
        $data[$index]['card_noticia'] =  $fields["card_noticia"];
        $index += 1;

    }

    return $data;
}

// Get Custom Type News by Id
// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/news/{id}
function blog_get_new_id(WP_REST_Request $request)
{
    $param = $request->get_url_params();

    $args = [
        'p'           => $param['id'],
        'post_type'   => 'noticias',
        'post_status' => 'publish',
    ];

    $pages = get_posts($args);
    foreach ($pages as $page) {
        $data["ID"]          = $page->ID;
        $data['post_status'] = $page->post_status;
        $data['post_author'] = $page->post_author;
        $data['post_type']   = $page->post_type;
        $data['post_title']  = $page->post_title;

        // get custom fields
        $custom_fields = get_fields($page->ID);

        $data['custom_fields'] = get_fields($page->ID);

    }

    return $data;
}

// Get Custom Type Services
function blog_get_services()
{
    $args = [
        'sort_order'  => 'desc',
        'post_type'   => 'servicios',
        'post_status' => 'publish',
    ];

    $news  = get_posts($args);
    $data  = [];
    $index = 0;
    foreach ($news as $page) {
        $data[$index]["ID"]          = $page->ID;
        $data[$index]['post_status'] = $page->post_status;
        $data[$index]['post_author'] = $page->post_author;
        $data[$index]['post_type']   = $page->post_type;
        $data[$index]['post_title']  = $page->post_title;

        // get custom fields

        $data[$index]['custom_fields'] = get_fields($page->ID);
        $index += 1;

    }

    return $data;
}

// Get Custom Type Service by Id
// https://app-ag-wordpress.azurewebsites.net/index.php/wp-json/api/v1/services/{id}
function blog_get_service_id(WP_REST_Request $request)
{
    $param = $request->get_url_params();

    $args = [
        'p'           => $param['id'],
        'post_type'   => 'servicios',
        'post_status' => 'publish',
    ];

    $pages = get_posts($args);
    foreach ($pages as $page) {
        $data["ID"]          = $page->ID;
        $data['post_status'] = $page->post_status;
        $data['post_author'] = $page->post_author;
        $data['post_type']   = $page->post_type;
        $data['post_title']  = $page->post_title;

        // get custom fields
        $custom_fields = get_fields($page->ID);

        $data['custom_fields'] = get_fields($page->ID);

    }

    return $data;
}

add_action('rest_api_init', function () {

    // Pages
    register_rest_route(API_URL, '/pages', [
        'methods'  => 'GET',
        'callback' => 'blog_get_pages',
    ]);

    register_rest_route(API_URL, '/pages/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods'  => 'GET',
        'callback' => 'blog_get_page',
    ));

    // News
    register_rest_route(API_URL, '/news', [
        'methods'  => 'GET',
        'callback' => 'blog_get_news',
    ]);

    register_rest_route(API_URL, '/news/cards', [
        'methods'  => 'GET',
        'callback' => 'blog_get_news_card',
    ]);

    register_rest_route(API_URL, '/news/(?P<id>\w+)', array(
        'methods'  => 'GET',
        'callback' => 'blog_get_new_id',
    ));

    // Services
    register_rest_route(API_URL, '/services', [
        'methods'  => 'GET',
        'callback' => 'blog_get_services',
    ]);

    register_rest_route(API_URL, '/services/(?P<id>\w+)', array(
        'methods'  => 'GET',
        'callback' => 'blog_get_service_id',
    ));

});
