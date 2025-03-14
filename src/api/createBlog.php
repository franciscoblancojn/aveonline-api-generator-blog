<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function AVAGB_router_create_blog(WP_REST_Request $request) {
    try {
        header('Content-Type: application/json; charset=utf-8');
        $data = $request->get_body();
        // var_dump($data);
        $json = AVAGB_formatJsonString($data);
        $blog_id = AVAGB_createBlogElementor($json);
        echo wp_json_encode(array(
            "status" => 200,
            // "data" => $data,
            // "json" => $json,
            "blog_id" => $blog_id,
            "blog_url" => admin_url("post.php?post=$blog_id&action=elementor")

            // "ssss"=>json_decode(get_post_meta(471, '_elementor_data',true),true)
        ));
    } catch (Exception $e) {
        echo wp_json_encode(array(
            "status" => 400,
            "data" => $e->getMessage().""
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