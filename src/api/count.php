<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function AVAGB_router_count_post(WP_REST_Request $request) {
    try {
        header('Content-Type: application/json; charset=utf-8');
        $data = json_decode($request->get_body(),true);
        $n_asesor_comercial = $data['n_asesor_comercial'];
        
        update_option('AVAGB_n_asesor_comercial',$n_asesor_comercial);

        echo wp_json_encode(array(
            "status" => 200,
            
        ));
    } catch (Exception $e) {
        echo wp_json_encode(array(
            "status" => 400,
            "data" => $e->getMessage().""
        ));
    }
}

function AVAGB_router_count_get(WP_REST_Request $request) {
    try {
        header('Content-Type: application/json; charset=utf-8');

        $n_asesor_comercial = get_option('AVAGB_n_asesor_comercial',0);
        
        echo wp_json_encode(array(
            "status" => 200,
            "n_asesor_comercial"=>(int)$n_asesor_comercial
            
        ));
    } catch (Exception $e) {
        echo wp_json_encode(array(
            "status" => 400,
            "data" => $e->getMessage().""
        ));
    }
}

function AVAGB_on_load_router_count()
{
    register_rest_route( AVAGB_RUTE, 'count', array(
      'methods' => 'POST',
      'callback' => 'AVAGB_router_count_post',
    ) );
    register_rest_route( AVAGB_RUTE, 'count', array(
      'methods' => 'GET',
      'callback' => 'AVAGB_router_count_get',
    ) );
}

add_action( 'rest_api_init', 'AVAGB_on_load_router_count' );