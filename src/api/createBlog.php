<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function AVAGB_router_create_blog(WP_REST_Request $request) {
    $data = $request->get_body();
    header('Content-Type: application/json; charset=utf-8');
    try {

        echo wp_json_encode(array(
            "status" => 200,
            "data" => $data,
        ));
    } catch (Exception $e) {
        echo wp_json_encode(array(
            "status" => 400,
            "data" => $e->getMessage()
        ));
    }
}

function AVAGB_on_load_router_create_blog()
{
    register_rest_route( AVAGB_RUTE, 'create-blog', array(
      'methods' => 'POST',
      'callback' => 'AVAGB_router_create_blog',
    ) );
}

add_action( 'rest_api_init', 'AVAGB_on_load_router_create_blog' );