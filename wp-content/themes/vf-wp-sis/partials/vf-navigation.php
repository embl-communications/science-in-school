<!-- Navigation -->
<nav class="vf-navigation vf-navigation--main | vf-cluster">
    <ul class="vf-navigation__list | vf-list | vf-cluster__inner">
        <?php

        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'depth' => 1,
                'container' => false,
                'items_wrap' => '%3$s'
            ));
        }
        ?>
    </ul>
</nav>

<!--    <h1 class="home"><a href="/">Science in School</a></h1> -->
