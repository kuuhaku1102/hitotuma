<?php
/**
 * Mama Gen Theme functions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// CSS 読み込み
function mama_gen_enqueue_styles() {
    wp_enqueue_style( 'mama-gen-style', get_stylesheet_uri(), array(), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'mama_gen_enqueue_styles' );
