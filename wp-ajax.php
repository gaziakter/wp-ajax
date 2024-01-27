<?php 
/**
 * Plugin Name:       WP Ajax
 * Plugin URI:        https://gaziakter.com/plugin/wp-ajax
 * Description:       Basic plugin demo for use future
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gazi Akter
 * Author URI:        https://gaziakter.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-ajax
 * Domain Path:       /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


//Ajax function
function my_ajax_function(){
    
    $query = new WP_Query( array(
        'post_per_page'=> 10,
        'post_type'=> 'product'
    ));

    $html = '<ul>';

    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
    
    $html .= '<li>'.get_the_title().'</li>';
   
    endwhile;
    endif;
    wp_reset_query( ) ;

    $html.='<ul>';

    echo $html;
    die();
}
add_action( 'wp_ajax_my_ajax_action', 'my_ajax_function');
add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_function');


//Create Shortcode
function my_shortcode(){
    $html = '
    <button class="my-ajax-trigger">Test</button>
    <div id="info"></div>
    
    <script>
    ; (function ($) {
        $(document).ready(function () {

        $(".my-ajax-trigger").on("click", function(){
            $.ajax({
                url: "'.admin_url( 'admin-ajax.php' ).'",
                type: "POST",
                data: {
                    action: "my_ajax_action"
                },
                beforeSend: function (){
                    $("#info").empty();
                    $("#info").append("Loading ...");
                },
                success: function (html){
                    $("#info").empty();
                    $("#info").append(html);
                }
            });
        });

    });
})(jQuery);

    </script>

    ';

    return $html;
}
add_shortcode( "ajax_btn", "my_shortcode" );

