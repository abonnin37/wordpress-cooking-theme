<?php
$recipe = get_post();
$recipe_meta = get_post_meta($recipe->ID);

$ingredients = unserialize($recipe_meta["wprm_ingredients"][0]);
$instructions = unserialize($recipe_meta["wprm_instructions"][0]);
?>
<div class="recipe-card">
    <div class="recipe-card-image">
        <?php the_post_thumbnail('medium');?>
    </div>
    <div class="recipe-card-overlay">
        <div class="overlay-background"></div>
        <div class="overlay-text">
            <?= __("Voir la recette", 'casalbbb') ?>
        </div>
    </div>
    <div class="recipe-card-content">
        <div class="recipe-category-icon">
            <i class="fa-solid fa-<?= getRecipeIcon(get_the_terms($recipe, "wprm_course")) ?>"></i>
        </div>
        <div class="recipe-info-group">
            <div class="recipe-title">
                <?php the_title() ?>
            </div>
            <div class="recipe-time-group">
                <div class="recipe-prep-time">
                    <i class="fa-regular fa-clock"></i>
                    <?= getRecipeTime($recipe_meta["wprm_prep_time"][0]) ?>
                </div>
                <div class="recipe-cook-time">
                    <i class="fa-solid fa-temperature-full"></i>
                    <?= getRecipeTime($recipe_meta["wprm_cook_time"][0]) ?>
                </div>
            </div>
        </div>
    </div>
</div>