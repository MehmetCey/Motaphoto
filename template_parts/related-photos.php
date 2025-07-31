<article class="related-photo">
  <a href="<?php the_permalink(); ?>">
    <?php if (has_post_thumbnail()) : ?>
      <div class="related-thumbnail"><?php the_post_thumbnail('medium'); ?></div>
    <?php endif; ?>
  </a>
</article>
