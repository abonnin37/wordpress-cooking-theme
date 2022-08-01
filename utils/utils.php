<?php
function getRecipeTime (string $time) {
    $res = "";
    $hours = floor((int) $time / 60);
    $minutes = (int) $time % 60;

    if ($hours > 0) {
        $res .= $hours . "h";
    }

    if ($minutes < 10) {
        $res .= "0";
    }

    $res .= $minutes;

    if ($hours == 0) {
        $res .= "mn";
    }

    return $res;
}

function getRecipeIcon ($course_taxonomies) {
    if ($course_taxonomies && count($course_taxonomies) > 0) {
        $course_taxonomy = $course_taxonomies[0];

        switch ($course_taxonomy->slug) {
            case "dessert":
                return "cookie";
            default:
                return "drumstick-bite";
        }
    }

    return "drumstick-bite";
}

function getRecipeServings ($servings, $servings_unit) {
    $res = __("~ pour ", 'casalbbb');

    if ($servings && count($servings) > 0) {
        $servings_unit_label = (count($servings_unit) > 0 && !empty($servings_unit[0])) ? " " . $servings_unit[0] : null;

        if ((int)$servings[0] > 1) {
            $res .= $servings[0] . ($servings_unit_label ?? __(" personnes", 'casalbbb'));
        } else {
            $res .= $servings[0] . ($servings_unit_label ?? __(" personne", 'casalbbb'));
        }
    } else {
        return null;
    }

    return $res . " ~";
}

function getRecipeIngredientLine ($ingredient) {
    $res = "";

    if ($ingredient["amount"]) {
        $res .= $ingredient["amount"] . " ";
    }

    if ($ingredient["unit"]) {
        $res .= $ingredient["unit"] . " " . __("de", "casalbbb") . " ";
    }

    $res .= !$ingredient["amount"] ? ucfirst($ingredient["name"]) : $ingredient["name"];

    if ($ingredient["notes"]) {
        $res .= " <i style='font-size: 13px;'>(" . $ingredient["notes"] . ")</i>";
    }

    return $res;
}