<?php
function casalbbb_custom_logo_setup() {
    $defaults = [
        'height' => 100,
        'width' => 400,
        'flex-height'          => true,
        'flex-width'           => true,
    ];

    add_theme_support( 'custom-logo', $defaults );
}

add_action( 'after_setup_theme', 'casalbbb_custom_logo_setup' );