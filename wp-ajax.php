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
    echo "test";

    die();
}
add_action( 'wp_ajax_my_ajax_action', 'my_ajax_function');
add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_function');


//Create Shortcode
function my_shortcode(){
    $html = '
    <button class="my-ajax-trigger">Test</button>
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
                success: function (){
                    alert("Ajax Working");
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

