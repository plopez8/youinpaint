<?php
/**
 * Plugin Name: YouInPaint Plugin
 * Plugin URI: http://boscdelacoma.cat
 * Description: Pràctica MP07.
 * Version: 0.1
 * Author: Pau Lopez Canal
 * Author URI:  http://boscdelacoma.cat     
 **/
register_activation_hook(__FILE__, 'activacio');

// Hook de desactivación del plugin
register_deactivation_hook(__FILE__, 'desactivacio');


function desactivacio(){
    delete_page('input');
    delete_page('player');
    delete_table();
}

function delete_page($titol){
    $page = get_page_by_title($titol);
    if ($page) {
      wp_delete_post($page->ID, true);
    }
}

function activacio(){
    create_page("player", youinpaint_player('URL_IMAGEN'), "publish", "page");
    create_page("input", youinpaint_input(), "publish", "page");
    create_table();
}
function create_table(){
    global $wpdb;
    $tabla = $wpdb->prefix . "fotos";
    $sql = "CREATE TABLE $tabla (
        id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        imagen VARCHAR(100),
        ruta VARCHAR(100),
        usuario VARCHAR(100),
        fecha DATE        
    );";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
function delete_table() {
    global $wpdb;
    $tabla = $wpdb->prefix . "fotos";
    $sql = "DROP TABLE IF EXISTS $tabla;";
    $wpdb->query($sql);
}
function create_page($titol, $contingut, $estat, $tipus) {
    $pagina = array(
      'post_title' => $titol,
      'post_content' => $contingut,
      'post_status' => $estat,
      'post_type' => $tipus
    );
    wp_insert_post($pagina);
}

require_once("includes/custom-pages.php");

const YOUINPAINT_DB_VERSION = '1.0';
const YOUINPAINT_VERSION = '1.0';

function youinpaint_shortcode()
{
    $dataoutput = "";

    if (isset($_GET['yerror'])) {
        $dataoutput.= "<div class='youinpaint-error'>" . $_GET['yerror'] . "</div>";
    }

    if (isset($_GET['success'])) {
        $url = plugin_dir_url(__FILE__) . "/uploads/" . $_GET['success'] . ".png";
        $dataoutput.= youinpaint_player($url);
    } else {
        $dataoutput.= youinpaint_input();
    }

    return $dataoutput;
}

function exemple_shortcode()
{
    return "<div class='exemple'>Exemple de shortcode</div>";
}

//TODO: Afegir la funcionalitat restant...

add_shortcode('youinpaint', 'youinpaint_shortcode');
add_shortcode('exemple', 'exemple_shortcode');
