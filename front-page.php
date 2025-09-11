<?php get_header(); ?>
<script>
  var photoRef = "<?php echo esc_js( SCF::get('référence') ); ?>";
</script>
<main>
<?php
$hero_bg_url = get_field('hero_image');
?>

<div class="hero-header" style="background-image: url('<?php echo esc_url($hero_bg_url); ?>');">
    <h1>Photographe event</h1>
</div>
    <?php
$categories = get_terms([
    'taxonomy' => 'categorie',
]);
$formats = get_terms([
    'taxonomy' => 'format'
]);
    ?>

<section class="photos-list">
    <section class="tri-photos">
    <div class="tri-taxo">
        <!-- Catégories -->
        <div class="custom-dropdown" data-name="categorie">
            <div class="dropdown-selected">CATÉGORIES</div>
            <ul class="dropdown-options">
                <?php foreach ($categories as $categorie) : ?>
                    <li data-value="<?php echo esc_attr($categorie->term_id); ?>">
                        <?php echo esc_html($categorie->name); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Formats -->
        <div class="custom-dropdown" data-name="format">
            <div class="dropdown-selected">FORMATS</div>
            <ul class="dropdown-options">
                <?php foreach ($formats as $format) : ?>
                    <li data-value="<?php echo esc_attr($format->term_id); ?>">
                        <?php echo esc_html($format->name); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Trier par -->
    <div class="custom-dropdown" data-name="tri">
        <div class="dropdown-selected">TRIER PAR</div>
        <ul class="dropdown-options">
            <li data-value="date-desc">Plus récentes</li>
            <li data-value="date-asc">Plus anciennes</li>
        </ul>
    </div>
</section>



    <section class="related-photos-container">
        <?php
        $args = [
            'post_type'      => 'photo',
            'posts_per_page' => 8,
        ];
        $photo_query = new WP_Query($args);

        if ($photo_query->have_posts()) :
            while ($photo_query->have_posts()) : $photo_query->the_post();
                get_template_part('template_parts/related-photos');
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </section>
</section>
<div class="btn-charger-plus">
    <button id="charger-plus">Charger plus</button>
</div>
</main>
<?php get_footer(); ?>
