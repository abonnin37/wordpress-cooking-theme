<?php get_header() ?>

<div class="searchbox-container">
    <?php get_template_part('parts/searchbox')?>
</div>

<div class="recipes-container mb-5">
    <?php if (have_posts()): ?>
        <div class="row">
            <?php while(have_posts()) : the_post() ?>
                <div class="col-sm-3">
                    <a class="permalink" href="<?= get_permalink()?>">
                        <?php
                        get_template_part('parts/recipe-card', 'post')
                        ?>
                    </a>
                </div>
            <?php endwhile; ?>

            <?php
                get_template_part('parts/pagination');
            ?>
        </div>
    <?php else: ?>
        <h1><?= __("Pas de recettes", 'casalbbb') ?></h1>
    <?php endif; ?>
</div>

<?php get_footer() ?>