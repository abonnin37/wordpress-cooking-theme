<?php get_header() ?>

<?php if (have_posts()): while (have_posts()) : the_post();
$recipe = get_post();
$recipe_meta = get_post_meta($recipe->ID);

$ingredients_groups = unserialize($recipe_meta["wprm_ingredients"][0]);
$instructions_groups = unserialize($recipe_meta["wprm_instructions"][0]);


?>
<div class="single-recipe-container">
    <div class="single-recipe">
        <div class="single-recipe-image">
            <?php the_post_thumbnail('full');?>
            <div class="single-recipe-homepage-btn"><?= __("Page d'accueil", 'casalbbb') ?></div>
        </div>
        <div class="single-recipe-header">
            <div class="recipe-category-icon">
                <i class="fa-solid fa-<?= getRecipeIcon(get_the_terms($recipe, "wprm_course")) ?>"></i>
            </div>
            <div class="recipe-header-info">
                <div class="recipe-title">
                    <h2>
                        <?php the_title() ?>
                    </h2>
                </div>
                <div class="recipe-time-group">
                    <div class="recipe-time recipe-prep-time">
                        <i class="fa-regular fa-clock"></i>
                        <span><?= __("Temps de préparation :", 'casalbbb') ?> </span>
                        <b><?= getRecipeTime($recipe_meta["wprm_prep_time"][0]) ?></b>
                    </div>
                    <div class="recipe-time recipe-cook-time">
                        <i class="fa-solid fa-temperature-full"></i>
                        <span><?= __("Temps de cuisson :", 'casalbbb') ?> </span>
                        <b><?= getRecipeTime($recipe_meta["wprm_cook_time"][0]) ?></b>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-recipe-content">
            <div class="ingredients-section">
                <div class="ingredients-header">
                    <div class="ingredients-title">
                        <?= __("Ingrédients", 'casalbbb') ?>
                    </div>
                    <?php if (getRecipeServings($recipe_meta["wprm_servings"], $recipe_meta["wprm_servings_unit"])) :?>
                    <div class="ingredients-quantity">
                        <?= getRecipeServings($recipe_meta["wprm_servings"], $recipe_meta["wprm_servings_unit"]) ?>
                    </div>
                    <?php endif;?>
                </div>
                <div class="ingredients-groups">
                    <?php foreach ($ingredients_groups as $ingredients_group) : ?>
                        <div class="ingredients-group">
                            <?php if (!empty($ingredients_group["name"])) : ?>
                            <div class="ingredients-group-name">
                                <?= $ingredients_group["name"] ?>
                            </div>
                            <?php endif; ?>
                            <ul class="ingredients-list">
                            <?php foreach ($ingredients_group["ingredients"] as $ingredient): ?>
                                <li class="ingredients-line">
                                    <?= getRecipeIngredientLine($ingredient) ?>
                                </li>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="instructions-section">
                <div class="instructions-header">
                    <div class="instructions-title">
                        <?= __("Instructions", 'casalbbb') ?>
                    </div>
                    <!-- Indicateur de temps
                    <div class="instructions-time-group">
                        <div class="total-time">
                            <b>Temps total : </b>
                            <?= getRecipeTime(getRecipeTime((string)((int)$recipe_meta["wprm_prep_time"][0] + (int)$recipe_meta["wprm_cook_time"][0]))) ?>
                        </div>
                        <div class="detail-time">
                            <div class="prep-time">
                                <i class="fa-regular fa-clock"></i>
                                <?= getRecipeTime($recipe_meta["wprm_prep_time"][0]) ?>
                            </div>
                            <div class="cook-time">
                                <i class="fa-solid fa-temperature-full"></i>
                                <?= getRecipeTime($recipe_meta["wprm_cook_time"][0]) ?>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
                <div class="instructions-groups">
                    <?php foreach ($instructions_groups as $instructions_group) : ?>
                    <div class="instructions-group">
                        <?php if (!empty($instructions_group["name"])) : ?>
                            <div class="instructions-group-name">
                                <?= $instructions_group["name"] ?>
                            </div>
                        <?php endif; ?>
                        <ol class="instructions-list">
                            <?php foreach ($instructions_group["instructions"] as $instruction) : ?>
                                <li class="instructions-line">
                                    <?= $instruction["text"] ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (count($recipe_meta["wprm_notes"]) > 0 && !empty($recipe_meta["wprm_notes"][0])) : ?>
            <div class="notes-section">
                <div class="notes-header">
                    <div class="notes-title">
                        <?= __("Notes", 'casalbbb') ?>
                    </div>
                </div>
                <div class="notes-content">
                    <?= $recipe_meta["wprm_notes"][0] ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="single-recipe-footer"></div>
    </div>
</div>
<?php endwhile; endif; ?>
<?php get_footer() ?>