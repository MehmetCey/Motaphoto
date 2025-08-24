<footer>
  <nav class="footer-nav">
    <?php
    wp_nav_menu([
      'theme_location' => 'footer-menu',
      'container' => false,
      'menu_class' => 'footer-menu',
      'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item contact-popup"><p">tous droits réservés<p></li></ul>',
    ]);
    ?>
  </nav>
<?php get_template_part('template_parts/popup'); ?>
<div id="lightbox-overlay" class="lightbox-overlay">
  <div class="lightbox-content">
    <span class="lightbox-close">&times;</span>
    <img id="lightbox-img" src="" alt="">
    <div class="lightbox-info">
      <span id="lightbox-ref"></span>
      <span id="lightbox-cat"></span>
    </div>
    <span class="lightbox-prev"><i class="fa-solid fa-arrow-left"></i>Précédente</span>
    <span class="lightbox-next">Suivante<i class="fa-solid fa-arrow-right"></i></span>
  </div>
</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
