<?php
function route_get_taxonomies_by_name (WP_REST_Request $request) {
    $name = $request->get_param('name');
    $selected_ingredients_string = $request->get_param('selected_ingredients');
    $selected_ingredients = [];

    foreach (explode(',', $selected_ingredients_string) as $selected_ingredient) {
        $selected_ingredients[] = get_term_by('name', $selected_ingredient, 'wprm_ingredient')->term_id;
    }

    if (!isset($name)) {
        return new WP_Error('name_not_exist', 'The parameter {name} is not defined.', ['status' => 404]);
    }

    if (!isset($selected_ingredients)) {
        return new WP_Error('selected_ingredients_not_exist', 'The parameter {selected_ingredients} is not defined.', ['status' => 404]);
    }

    $ingredients = get_terms([
        'taxonomy' => 'wprm_ingredient',
        'orderby' => 'name',
        'order' => 'asc',
        'fields' => 'names',
        'hide_empty' => false,
        'name__like' => $name,
        'exclude' => $selected_ingredients
    ]);

    $has_more_than_10_ingredients = count($ingredients) > 10;

    $ingredients_to_send = $has_more_than_10_ingredients ? array_splice($ingredients, 0 , 10) : $ingredients;

    $response = new WP_REST_Response([
        "name" => $name,
        "length" => count($ingredients_to_send),
        "ingredients" => $ingredients_to_send,
        "has_more" => $has_more_than_10_ingredients,
        "status" => 200
    ]);
    $response->set_status(200);
    $response->set_headers([
        'Content-Type' => 'application/json'
    ]);
    return $response;
}
function validateName ($name, $request, $key) {
    $pattern = '!"#$&()*+,-./:;<=>?@[\]^_`{|}~';

    // If $name is free of all the character in $pattern
    if (!strpbrk($name, $pattern)) {
        return true;
    }
    return false;
}

function casalbbb_register_route_get_taxonomies_by_name () {
    register_rest_route('casalbbb/v1', '/taxonomies-by-name', [
        'methods' => 'GET',
        'callback' => 'route_get_taxonomies_by_name',
        'args' => [
            'name' => [
                'validate_callback' => 'validateName'
            ]
        ]
    ]);
}

add_action('rest_api_init', 'casalbbb_register_route_get_taxonomies_by_name');