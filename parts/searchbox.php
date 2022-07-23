<?php
    $isFilter = get_query_var('wprm_course') || get_query_var('wprm_cuisine') || get_query_var('wprm_keyword') || get_query_var('wprm_ingredient');
?>

<form id="searchbox" class="searchbox my-5" action="/">
        <div class="row mb-3">
            <div class="input-group searchbox-main-input-container" id="searchbox-main-input-container">
                <input
                        id="searchbox-main-input"
                        name="s"
                        class="form-control form-control-lg"
                        type="search" value="<?= get_search_query() ?>"
                        placeholder="Que désirez-vous manger ?"
                        aria-label="Que désirez-vous manger ?"
                        aria-describedby="title-search-icon"
                        autocomplete="off"
                >
                <label class="input-group-text" id="title-search-icon" for="searchbox-main-input"><i class="fa-solid fa-magnifying-glass"></i></label>
            </div>
        </div>
        <div class="accordion" id="searchbox-accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="searchbox-accordion-header">
                    <button class="accordion-button <?= $isFilter ? "" : "collapsed" ?>" type="button" data-bs-toggle="collapse" data-bs-target="#searchbox-accordion-collapse" aria-expanded="<?= $isFilter ?>" aria-controls="searchbox-accordion-collapse">
                        <div class="filter-btn-container">
                            <i class="fa-solid fa-filter"></i> Plus de filtres
                        </div>
                    </button>
                    <div class="resetBtn" id="resetBtn">
                        <div class="resetBtnGroup">
                            <span>Reset</span><i class="fa-solid fa-arrow-rotate-left"></i>
                        </div>
                    </div>
                </h2>
                <div id="searchbox-accordion-collapse" class="accordion-collapse collapse <?= $isFilter ? "show" : "" ?>" aria-labelledby="searchbox-accordion-header" data-bs-parent="#searchbox-accordion">
                    <div class="accordion-body">
                        <div class="recipe-type-country row mb-4">
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <label for="wprm_course" class="form-label mb-0">Type de plat : </label>
                                    </div>
                                    <div class="col">
                                        <select id="wprm_course" name="wprm_course" class="form-select" aria-label="Type de plat">
                                            <option value="">Tous</option>
                                            <?php
                                                $recipe_types = get_terms([
                                                    'taxonomy' => 'wprm_course',
                                                    'hide_empty' => false,
                                                ]);

                                                foreach ($recipe_types as $recipe_type) {
                                                    $selected = get_query_var('wprm_course') === $recipe_type->name;

                                                    echo '<option value="' . $recipe_type->name . '" '. ($selected ? "selected" : "") .'>' . $recipe_type->name . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-auto d-flex align-items-center">
                                        <label for="wprm_cuisine" class="form-label mb-0">Pays d'origine : </label>
                                    </div>
                                    <div class="col">
                                        <select id="wprm_cuisine" name="wprm_cuisine" class="form-select" aria-label="Pays d'origine">
                                            <option value="" selected>Tous</option>
                                            <?php
                                                $countries = get_terms([
                                                    'taxonomy' => 'wprm_cuisine',
                                                    'hide_empty' => false,
                                                ]);

                                                foreach ($countries as $country) {
                                                    $selected = get_query_var('wprm_cuisine') === $country->name;

                                                    echo '<option value="' . $country->name . '" '. ($selected ? "selected" : "") .'>' . $country->name . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="special-regime-container mb-4">
                            <input type="hidden" id="wprm_keyword" name="wprm_keyword" value="<?= get_query_var('wprm_keyword')?>">
                            <div class="special-regime-title">
                                Régime spéciaux :
                            </div>
                            <div class="special-regime-item-list">
                                <?php
                                $special_regimes = get_terms([
                                    'taxonomy' => 'wprm_keyword',
                                    'hide_empty' => false,
                                ]);

                                foreach ($special_regimes as $special_regime) : ?>
                                    <div class="special-regime-item" data-value="<?= $special_regime->name?>" data-checked="<?= in_array($special_regime->name, explode(',', get_query_var('wprm_keyword'))) ? "checked" : "" ?>">
                                        <i class="fa-solid fa-check"></i>
                                        <label class="special-regime-label"><?= $special_regime->name?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="ingredients-container mb-4">
                            <input type="hidden" id="wprm_ingredient" name="wprm_ingredient" value="<?= get_query_var('wprm_ingredient')?>">
                            <div class="ingredients-search-field-container row  mb-2">
                                <div class="ingredients-label col-sm-2">
                                    <label for="ingredients-input">
                                        Rechercher un ingrédient :
                                    </label>
                                </div>
                                <div id='ingredients-input-container' class="ingredients-input-container col-sm-auto">
                                    <div class="input-group">
                                        <input
                                                id="ingredients-input"
                                                class="form-control"
                                                type="search"
                                                list=""
                                                placeholder="Rechercher un ingrédient"
                                                autocomplete="off">
                                        <datalist id="ingredient-list">
                                        </datalist>
                                        <span id='ingredient-searchbar-icon' class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="ingredients-terms-container">
                                <ul class="ingredients-terms-list" id="ingredients-terms-list">
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="search-btn btn btn-secondary" id="filter-submit">Chercher une recette</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>