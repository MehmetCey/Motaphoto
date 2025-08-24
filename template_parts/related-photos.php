<div class="related-thumbnail">
  <a href="<?php the_permalink(); ?>" class="single-link">
    <?php 
      $ref = get_field('reference'); 
      $terms = get_the_terms(get_the_ID(), 'categorie'); 
      $cat = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
      $full_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0]; 
    ?>

    <?php the_post_thumbnail('large', [
      'data-reference' => $ref,
      'data-category'  => $cat,
      'data-full'      => $full_img
    ]); ?>

  </a>

  <div class="overlay">
    <span class="fullscreen-icon"><i class="fa-solid fa-expand"></i></span>
    <span class="eye-icon"><i class="fa-solid fa-eye"></i></span>
    <div class="photo-meta">
      <span class="ref"><?php echo esc_html($ref); ?></span>
      <span class="cat"><?php echo esc_html($cat); ?></span>
    </div>
  </div>
</div>
