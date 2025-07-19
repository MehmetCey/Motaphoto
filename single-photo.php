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

                    <p class="description-photo">Référence : <span class="photo-ref-value"><?php echo esc_html( SCF::get('référence') ); ?></span></p>

                    <p class="description-photo">Catégorie : 
                        <?php echo get_the_term_list( get_the_ID(), 'categorie', '', ', ' ); ?>
                    </p>

                    <p class="description-photo">Format : 
                        <?php echo get_the_term_list( get_the_ID(), 'format', '', ', ' ); ?>
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
            </div>
        </div>
        </article>

    <?php endwhile; endif; ?>
</main>

<?php
get_footer();
