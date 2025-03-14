<?php
function AVAGB_createBlogElementor($data) {
    // $data = json_decode($json_data, true);
    // var_dump(json_encode($data));
    
    if (!$data || empty($data['content']) || empty($data['titleSlug']) || empty($data['metadescription'])) {
        throw new Exception('El JSON proporcionado no es válido.');
    }
    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field(wp_strip_all_tags(AVAGB_removeEmojis($data['titleSlug']))),
        'post_content' => '',
        'post_status'  => 'draft',
        'post_type'    => 'post'
    ]);
    
    if (is_wp_error($post_id)) {
        throw new Exception("Error: No se crear el post.");
    }
    
    update_post_meta($post_id, '_yoast_wpseo_metadesc', $data['metadescription']);
    
    $elementor_data = [];
    
    foreach ($data['content'] as $block) {
        $element = [];
        
        $tag = $block['type'];
        switch ($block['type']) {
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6':
                $element = [
                    'id' => uniqid(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => [
                        'editor' => "<$tag>".$block['content']."</$tag>"
                    ]
                ];
                break;
            
            case 'p':
                $element = [
                    'id' => uniqid(),
                    'elType' => 'widget',
                    'widgetType' => 'text-editor',
                    'settings' => [
                        'editor' => $block['content']
                    ]
                ];
                break;
            
            case 'ul':
            case 'ol':
                if (is_array($block['list']) && !empty($block['list'])) {
                    $list_tag = $block['type'];
                    $element = [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => "<$list_tag><li>" . implode('</li><li>', $block['list']) . "</li></$list_tag>"
                        ]
                    ];
                }
                break;
            
            case 'table':
                if (!empty($block['table']['head']) && !empty($block['table']['row'])) {
                    $table_html = '<table><thead><tr>';
                    foreach ($block['table']['head'] as $head) {
                        $table_html .= "<th>$head</th>";
                    }
                    $table_html .= '</tr></thead><tbody>';
                    foreach ($block['table']['row'] as $row) {
                        $table_html .= '<tr><td>' . implode('</td><td>', $row) . '</td></tr>';
                    }
                    $table_html .= '</tbody></table>';
                    
                    $element = [
                        'id' => uniqid(),
                        'elType' => 'widget',
                        'widgetType' => 'text-editor',
                        'settings' => [
                            'editor' => $table_html
                        ]
                    ];
                }
                break;
        }
        
        if (!empty($element)) {
            $elementor_data[] = $element;
        }
    }
    
    update_post_meta($post_id, '_elementor_data', json_encode([[
        'id' => uniqid(),
        "elType"=> "container",
        "settings"=> [],
        "isInner"=> false,
        "elements"=>$elementor_data
    ]]));
    
    return $post_id;
}
