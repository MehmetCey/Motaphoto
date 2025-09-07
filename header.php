<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
  <div class="container">
    <div class="logo">
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Nathalie Mota.png" alt="Logo du site">
      </a>
    </div>

    <!-- Menu Desktop -->
    <nav class="main-menu">
      <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'container' => false,
        'menu_class' => 'menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item contact-popup"><a href="#" id="open-contact">Contact</a></li></ul>',
      ]);
      ?>
    </nav>

    <!-- Burger Mobile -->
    <div class="burger-menu" id="burger-menu">
      <span class="span1"></span>
      <span class="span2"></span>
      <span class="span3"></span>
    </div>
    <div class="burger-menu popup-display-none" id="burger-close">
      <span class="span1 span11"></span>
      <span class="span2 span22"></span>
      <span class="span3 span33"></span>
    </div>
  </div>
</header>

<!-- Overlay Mobile -->
<div class="mobile-menu-overlay popup-display-none" id="mobile-menu-overlay">
    <?php
    wp_nav_menu([
      'theme_location' => 'main-menu',
      'container' => false,
      'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="menu-item contact-popup"><a href="#" id="open-contact">Contact</a></li></ul>',
    ]);
    ?>
</div>

<?php wp_footer(); ?>
