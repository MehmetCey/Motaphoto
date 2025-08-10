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

<section class="related-photos-container">
    <?php
    $args = [
        'post_type'      => 'photo',
        'posts_per_page' => 8
    ];

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            
            get_template_part('template_parts/related-photos');

         endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;
    ?>
</section>
</main>
<?php get_footer(); ?>
