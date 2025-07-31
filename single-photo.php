<?php
get_header();
?>
<main class="single-photo">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="photo-content-wrapper">

                <div class="photo-infos">
                    <!-- Titre -->
                    <h2 class=""><?php the_title(); ?></h2>

                    <p class="description-photo">Référence : <span class="photo-ref-value"><?php echo esc_html( SCF::get('reference') ); ?></span></p>

                    <p class="description-photo">Catégorie :
                        <?php echo implode(', ', wp_list_pluck(wp_get_post_terms(get_the_ID(), 'categorie'), 'name')); ?>
                    </p>

                    <p class="description-photo">Catégorie :
                        <?php echo implode(', ', wp_list_pluck(wp_get_post_terms(get_the_ID(), 'format'), 'name')); ?>
                    </p>

                    <p class="description-photo">Type : <?php echo esc_html( SCF::get('type') ); ?></p>

                    <p class="photo-date description-photo">Année : <?php echo get_the_date('Y'); ?></p>

                </div>

                <!-- Image à la une -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="photo-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                
                <?php endif; ?>

            </div>
            <div class="content-underpost">
                <div class="photo-contact">
                    <p>Cette photo vous intéresse ?</p>    
                    <button class="contact-button">Contact</button>
                </div>
                <div class="photo-card">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    <?php
                    $current_id = get_the_ID();
                    $args = array(
                    'post_type' => 'photo',
                    'posts_per_page' => -1,
                    'orderby' => 'date',
                    'order' => 'ASC',
                    'fields' => 'ids',
                    );
                    $all_photos = get_posts($args);

                    $current_index = array_search($current_id, $all_photos);

                    $prev_index = $current_index - 1;
                    $next_index = $current_index + 1;

                    if ($prev_index < 0) {
                    $prev_index = count($all_photos) - 1;
                    }
                    if ($next_index >= count($all_photos)) {
                    $next_index = 0;
                    }

                    $prev_id = $all_photos[$prev_index];
                    $next_id = $all_photos[$next_index];
                    ?>
                    <div class="photo-navigation">
                        <div class="next-photo-preview">
                            <a href="<?php echo get_permalink($next_id); ?>">
                            <?php echo get_the_post_thumbnail($next_id, 'thumbnail'); ?>
                            </a>
                        </div>
                        <div class="arrows">
                            <a href="<?php echo get_permalink($prev_id); ?>" class="nav-arrow left">
                            <i class="fa-solid fa-arrow-up fa-rotate-270"></i>
                            </a>

                            <a href="<?php echo get_permalink($next_id); ?>" class="nav-arrow right">
                            <i class="fa-solid fa-arrow-up fa-rotate-90"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="photo-similaire">
                <h3>Vous aimerez aussi</h3>
                        <div class="related-photos-container">

                            <?php
                            $categories = wp_get_post_terms(get_the_ID(), 'categorie', ['fields' => 'ids']);

                            if (!empty($categories)) {
                            $args = [
                                'post_type' => 'photo',
                                'posts_per_page' => 2,
                                'post__not_in' => [get_the_ID()],
                                'tax_query' => [
                                [
                                    'taxonomy' => 'categorie',
                                    'field'    => 'term_id',
                                    'terms'    => $categories,
                                ]
                                ]
                            ];

                            $related_query = new WP_Query($args);

                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post();
                                get_template_part('template_parts/related-photos');
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p>Aucune photo apparentée trouvée.</p>';
                            endif;
                            }
                            ?>

                        </div>
                </div>
            </div>
        </article>

    <?php endwhile; endif; ?>
<script>
    var photoRef = "<?php echo esc_html( SCF::get('reference') ); ?>";
</script>
</main>
<?php get_footer(); ?>
