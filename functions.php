<?php
// Charger CSS, JS et font awesome
function mon_theme_enqueue_assets() {
    wp_enqueue_style('mon-style', get_stylesheet_uri());
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/lightbox.js', ['jquery'], false, true);
    wp_enqueue_script('mon-script', get_template_directory_uri() . '/scripts.js', ['jquery'], '1.0', true);
    wp_localize_script('mon-script', 'mon_ajax_obj', ['ajaxurl' => admin_url('admin-ajax.php')]);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
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

function cptui_register_my_taxes_format() {

	/**
	 * Taxonomy: Formats.
	 */

	$labels = [
		"name" => esc_html__( "Formats", "custom-post-type-ui" ),
		"singular_name" => esc_html__( "Format", "custom-post-type-ui" ),
	];

	
	$args = [
		"label" => esc_html__( "Formats", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'format', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "format",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "format", [ "photo" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_format' );

function cptui_register_my_taxes_categorie() {

	/**
	 * Taxonomy: Catégories.
	 */

	$labels = [
		"name" => esc_html__( "Catégories", "custom-post-type-ui" ),
		"singular_name" => esc_html__( "catégorie", "custom-post-type-ui" ),
	];

	
	$args = [
		"label" => esc_html__( "Catégories", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'categorie', 'with_front' => true, ],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "categorie",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "categorie", [ "photo" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_categorie' );

//* format pour la médiateque

function add_format_taxonomy_to_attachments() {
    register_taxonomy_for_object_type( 'format', 'attachment' );
}
add_action( 'init', 'add_format_taxonomy_to_attachments' );

//* filtrer les images pour le héro header

add_filter('acf/fields/image/query/name=Hero_header', function($args, $field, $post_id) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => array('paysage') // slug exact de ta taxonomie
        )
    );
    return $args;
}, 10, 3);

//* ajax 

function charger_toutes_photos() {
    $paged  = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $posts_per_page = 8;
    $offset = ($paged - 1) * $posts_per_page;

    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'offset'         => $offset,
    ];

    if (!empty($_POST['categorie'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'categorie',
            'field'    => 'term_id',
            'terms'    => intval($_POST['categorie']),
        ];
    }

    if (!empty($_POST['format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'format',
            'field'    => 'term_id',
            'terms'    => intval($_POST['format']),
        ];
    }

    if (!empty($_POST['tri'])) {
        if ($_POST['tri'] === 'date-desc') {
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
        } elseif ($_POST['tri'] === 'date-asc') {
            $args['orderby'] = 'date';
            $args['order']   = 'ASC';
        }
    }

    $query = new WP_Query($args);
    $total_posts = $query->found_posts;

    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template_parts/related-photos');
        endwhile;
        wp_reset_postdata();

        // ⚡ Indicateur pour le JS du nombre restant
        $remaining = max(0, $total_posts - ($offset + $posts_per_page));
        echo '<span class="remaining-posts" data-remaining="' . $remaining . '"></span>';
    } else {
        echo 0; // plus de posts
    }

    wp_die();
}
add_action('wp_ajax_charger_toutes_photos', 'charger_toutes_photos');
add_action('wp_ajax_nopriv_charger_toutes_photos', 'charger_toutes_photos');


// Fonction pour filtrer et trier les photos
function filtrer_photos() {
$categorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : '';
$format    = isset($_POST['format']) ? intval($_POST['format']) : '';
$tri       = isset($_POST['tri']) ? $_POST['tri'] : '';

$args = [
    'post_type' => 'photo',
    'posts_per_page' => 8,
];

// Filtre catégorie
if ($categorie) {
    $args['tax_query'][] = [
        'taxonomy' => 'categorie',
        'field'    => 'term_id',
        'terms'    => $categorie
    ];
}

// Filtre format
if ($format) {
    $args['tax_query'][] = [
        'taxonomy' => 'format',
        'field'    => 'term_id',
        'terms'    => $format
    ];
}

// Tri
if ($tri === 'date-desc') {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
} elseif ($tri === 'date-asc') {
    $args['orderby'] = 'date';
    $args['order'] = 'ASC';
}

$query = new WP_Query($args);


    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template_parts/related-photos');
        endwhile;
    else:
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_filtrer_photos', 'filtrer_photos');
add_action('wp_ajax_nopriv_filtrer_photos', 'filtrer_photos');
