<footer>
  <nav class="footer-nav">
    <?php
    wp_nav_menu([
      'theme_location' => 'footer-menu',
      'container' => false,
      'menu_class' => 'footer-menu', // pour ton CSS
    ]);
    ?>
  </nav>
<?php get_template_part('template_parts/popup.php'); ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
