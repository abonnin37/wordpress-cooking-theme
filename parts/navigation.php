<nav class="navbar">
    <a href="/" class="navbar-link">
        <?php
            if (function_exists( 'the_custom_logo' ) && has_custom_logo()) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

                echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="navbar-logo">';
            } else {
                echo '<h1 class="navbar-title">' . get_bloginfo('name') . '</h1>';
            }
        ?>
    </a>
</nav>