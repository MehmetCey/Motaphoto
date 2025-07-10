<?php
// Charger CSS et JS
function mon_theme_enqueue_assets() {
    wp_enqueue_style('mon-style', get_stylesheet_uri());
    wp_enqueue_script('mon-scripts', get_template_directory_uri() . '/scripts.js', [], false, true);
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css' );
}

add_action('wp_enqueue_scripts', 'mon_theme_enqueue_assets');

// Enregistrer les menus
function register_my_menus() {
    register_nav_menus([
        'main-menu' => __('Menu principal', 'text-domain'),
        'footer-menu' => __('Menu du footer', 'text-domain'),
    ]);
}
add_action('after_setup_theme', 'register_my_menus');

