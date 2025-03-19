<?php
/*
Plugin Name: Aveonline Api Generator Blog
Plugin URI: https://github.com/franciscoblancojn/aveonline-api-generator-blog
Description: Plugin que genera endpoint para generar Blog.
Version: 1.0.7
Author: franciscoblancojn
Author URI: https://franciscoblanco.vercel.app/
License: GPL2+
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: aveonline-api-generator-blog
*/

if (!function_exists( 'is_plugin_active' ))
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

//AVAGB_
define("AVAGB_KEY",'AVAGB');
define("AVAGB_RUTE",'avagb');
define("AVAGB_SLUG",'aveonline-api-generator-blog');
define("AVAGB_LOG",false);
define("AVAGB_DIR",plugin_dir_path( __FILE__ ));
define("AVAGB_URL",plugin_dir_url(__FILE__));
define("AVAGB_BASENAME",plugin_basename(__FILE__));

require_once AVAGB_DIR . 'update.php';
github_updater_plugin_wordpress([
    'basename'=>AVAGB_BASENAME,
    'dir'=>AVAGB_DIR,
    'file'=>"index.php",
    'path_repository'=>'franciscoblancojn/aveonline-api-generator-blog',
    'branch'=>'master',
    'token_array_split'=>[
        "g",
        "h",
        "p",
        "_",
        "G",
        "4",
        "W",
        "E",
        "W",
        "F",
        "p",
        "V",
        "U",
        "E",
        "F",
        "V",
        "x",
        "F",
        "U",
        "n",
        "b",
        "M",
        "k",
        "P",
        "R",
        "x",
        "o",
        "f",
        "t",
        "Y",
        "8",
        "z",
        "j",
        "t",
        "4",
        "E",
        "x",
        "b",
        "i",
        "9"
    ]
]);


require_once AVAGB_DIR . 'src/_index.php';
