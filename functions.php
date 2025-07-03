<?php
// Charger CSS et JS
function mon_theme_enqueue_assets() {
    wp_enqueue_style('mon-style', get_stylesheet_uri());
    wp_enqueue_script('mon-scripts', get_template_directory_uri() . '/js/scripts.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_assets');

// Enregistrer un menu
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menu');
