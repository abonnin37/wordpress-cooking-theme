<?php

require_once ("options/apparence.php");
require_once ("utils/utils.php");
require_once ("rest-api/get-taxonomies-by-name.php");

function casalbbb_init () {
}

function casalbbb_supports () {
    add_theme_support('title-tag');
    add_theme_support('html5');
    add_theme_support('post-thumbnails');
}

function casalbbb_register_assets()
{
    wp_register_style('casalbbb_style', get_template_directory_uri() . "/assets/style.css");
    wp_register_style('fontawesome', "https://use.fontawesome.com/releases/v6.1.1/css/all.css");
    wp_register_style('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css");
    wp_register_script('bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js", [], false, true);
    wp_register_script('casalbbb_script_special_regime', get_template_directory_uri() . "/assets/special-regime.js", [], false, true);
    wp_register_script('casalbbb_script_ingredients', get_template_directory_uri() . "/assets/search-ingredients.js", [], false, true);
    wp_register_script('casalbbb_script_recipes', get_template_directory_uri() . "/assets/search-recipes.js", [], false, true);
    wp_register_script('casalbbb_script_single_recipe', get_template_directory_uri() . "/assets/single-recipe.js", [], false, true);
    wp_register_script('casalbbb_script_reset_filter', get_template_directory_uri() . "/assets/reset-filter.js", [], false, true);
    wp_register_script('casalbbb_script_filter_submit', get_template_directory_uri() . "/assets/onFilterSubmit.js", [], false, true);

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('fontawesome');
    wp_enqueue_style('casalbbb_style');
    wp_enqueue_script('bootstrap');
    if (is_single() && get_post_type() === "wprm_recipe") {
        wp_enqueue_script('casalbbb_script_single_recipe');
    } else {
        wp_enqueue_script('casalbbb_script_special_regime');
        wp_enqueue_script('casalbbb_script_ingredients');
        wp_enqueue_script('casalbbb_script_recipes');
        wp_enqueue_script('casalbbb_script_reset_filter');
        wp_enqueue_script('casalbbb_script_filter_submit');
    }
}

add_action('init', 'casalbbb_init');
add_action('after_setup_theme', 'casalbbb_supports');
add_action('wp_enqueue_scripts', 'casalbbb_register_assets');

function casalbbb_pre_get_post (WP_Query $query) {
    if (is_admin() || (!is_home() && !is_search()) || !$query->is_main_query()) {
        return;
    }

    // configuration de la requête de base du site
    $query->set('posts_per_page', 8);
    $query->set('post_type', "wprm_recipe");
    $query->set('post_status', "publish");
    $query->set('orderby', "date");

    $tax_query = $query->get('tax_query', []);

    // add query param to WP_Query object if present in the query search bar
    // Handle Recipe Type
    if (!empty(get_query_var('wprm_course'))) {
        $tax_query[] = [
            'taxonomy' => 'wprm_course',
            'field'    => 'name',
            'terms' => get_query_var('wprm_course'),
            'operator' => 'IN'
        ];
    }

    // Handle country
    if (!empty(get_query_var('wprm_cuisine'))) {
        $tax_query[] = [
            'taxonomy' => 'wprm_cuisine',
            'field'    => 'name',
            'terms' => get_query_var('wprm_cuisine'),
            'operator' => 'IN'
        ];
    }

    // Handle special regime
    if (!empty(get_query_var('wprm_keyword'))) {
        $special_regimes = explode(',', get_query_var('wprm_keyword'));

        $tax_query[] = [
            'taxonomy' => 'wprm_keyword',
            'field'    => 'name',
            'terms' => $special_regimes,
            'operator' => 'AND'
        ];
    }

    // Handle ingredients
    if (!empty(get_query_var('wprm_ingredient'))) {
        $ingredients = explode(',', get_query_var('wprm_ingredient'));

        $tax_query[] = [
            'taxonomy' => 'wprm_ingredient',
            'field'    => 'name',
            'terms' => $ingredients,
            'operator' => 'AND'
        ];
    }

    $tax_query[] = ['relation' => 'AND'];
    $query->set('tax_query', $tax_query);
}

// On ajoute les champs de recherche ici
function casalbbb_query_vars ($params) {
    $params[] = 'wprm_course';
    $params[] = 'wprm_cuisine';
    $params[] = 'wprm_keyword';
    $params[] = 'wprm_ingredient';
    $params[] = 'recipe-type';

    return $params;
}

add_action('pre_get_posts', 'casalbbb_pre_get_post');
add_action('query_vars', 'casalbbb_query_vars');