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
            <div class="custom-select">
            <select id="filtre-categorie">
                <option value="">CATÉGORIES</option>
                <?php foreach ($categories as $categorie) : ?>
                <option value="<?php echo esc_attr($categorie->term_id); ?>">
                    <?php echo esc_html($categorie->name); ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>

            <div class="custom-select">
            <select id="filtre-format">
                <option value="">FORMATS</option>
                <?php foreach ($formats as $format) : ?>
                <option value="<?php echo esc_attr($format->term_id); ?>">
                    <?php echo esc_html($format->name); ?>
                </option>
                <?php endforeach; ?>
            </select>
            </div>
        </div>
        <div class="custom-select">
            <select id="tri-photos">
            <option value="">TRIER PAR</option>
            <option value="date-desc">Plus récentes</option>
            <option value="date-asc">Plus anciennes</option>
            </select>
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
