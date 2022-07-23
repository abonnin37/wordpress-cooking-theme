<?php if (get_previous_posts_link() || get_next_posts_link()) : ?>
<div class="pagination mt-5">
    <div class="pagination-item pagination-prev">
        <?= get_previous_posts_link("Recettes précédentes") ?>
    </div>
    <div class="pagination-item pagination-next">
        <?= get_next_posts_link("Recettes suivantes") ?>
    </div>
</div>
<?php endif; ?>