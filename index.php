<?php
/*
 Plugin Name: ARW8 - Elementor Campaign Page
 Description: Esse plugin estende o plugin Elementor e adiciona funcaoes Campaign Page
 Version: 1.9
 License: GPLv3
 Plugin URI: http://celeirobusiness.com

 Author: Leandro Augusto <leandro@leandroaugusto.eti.br>
 Author URI: http://leandroaugusto.eti.br
*/

# Adiciona CPT Campaign Page
add_action( 'init', 'cpt_arw8_elementor_campaignpage' );
function cpt_arw8_elementor_campaignpage() {
    register_post_type( 'campaignpage',
        array(
            'labels' => array(
                'menu_name'     => __( 'ARW8' ),
                'name'          => __( 'Paginas de campanha' ),
                'singular_name' => __( 'Pagina Campanha' ),
            ),
            'public' => true,
            'supports' => array('title','editor','thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
            'has_archive' => true,
            'hierarchical' => true,
            'rewrite' => array ('slug' => 'a'),
        )
    );
}

# Adiciona campos personalizado
add_action("admin_init", "arw8_elementor_campaignpage_metabox");
function arw8_elementor_campaignpage_metabox() {
   add_meta_box("arw8_elementor_campaignpage_metabox_connects",
                 "Integracoes", "arw8_elementor_campaignpage_connects", "campaignpage",
                 "normal", "low");
}

function arw8_elementor_campaignpage_connects() {
    global $post;
    $custom = get_post_custom($post->ID);

    $code_google = $custom["code_google"][0];
    $code_piwik = $custom["code_piwik"][0];
    $code_pixelface = $custom["code_pixelface"][0];

    echo "<label>Code google:</label><br>";
    echo "<input name=\"code_google\" value=\"$code_google\" /><br>";

    echo "<label>Code piwik:</label><br>";
    echo "<input name=\"code_piwik\" value=\"$code_piwik\" /><br>";

    echo "<label>Pixel Facebook:</label><br>";
    echo "<input name=\"code_pixelface\" value=\"$code_pixelface\" /><br>";
}

add_action('save_post', 'arw8_elementor_campaignpage_connects_save');
function arw8_elementor_campaignpage_connects_save(){
    global $post;

    update_post_meta($post->ID, "code_google", $_POST["code_google"]);
    update_post_meta($post->ID, "code_piwik", $_POST["code_piwik"]);
    update_post_meta($post->ID, "code_pixelface", $_POST["code_pixelface"]);
}


# Adiciona Taxonomy Campanha
add_action( 'init', 'arw8_elementor_campaignpage_campaign', 0 ) ;
function arw8_elementor_campaignpage_campaign() {
    $labels = array(
		    'name'                       => __( 'Campanha' ),
		    'singular_name'              => __( 'Campanha' ),
		    'menu_name'                  => __( 'Cadastro de campanha' ),
 	  );
    register_taxonomy('campaignpage_campaign',
        array( 'campaignpage'),
        array(
            'labels' => $labels,
            'hierarchical' => true,
	          'show_ui' => true,
	          'show_in_tag_cloud' => true,
	          'query_var' => true,
	          'rewrite' => true,
	      )
    );
}

# Adiciona Taxonomy Tipo
add_action( 'init', 'arw8_elementor_campaignpage_type', 0 ) ;
function arw8_elementor_campaignpage_type() {
    $labels = array(
		    'name'                       => __( 'Tipos de pagina' ),
		    'singular_name'              => __( 'Tipo de pagina' ),
		    'menu_name'                  => __( 'Cadastro de tipo de pagina' ),
    );
    register_taxonomy('campaignpage_type', array( 'campaignpage'),
        array(
            'labels' => $labels,
            'hierarchical' => true,
	          'show_ui' => true,
	          'show_in_tag_cloud' => true,
	          'query_var' => true,
	          'rewrite' => true,
	      )
    );
}




# Re-mapeia single page para plugin
add_filter( "single_template", "get_plugin_template" );
function get_plugin_template($single_template) {
    global $post;
    if ($post->post_type == 'campaignpage') {
        wp_enqueue_style( 'landpage-reset', plugins_url('HTML5-Reset-WordPress-Theme/reset.css', __FILE__) );
        wp_enqueue_style( 'landpage-reset', plugins_url('style.css', __FILE__) );
        $single_template = dirname( __FILE__ ) . '/single-campaignpage.php';
    }
    return $single_template;
}


?>
