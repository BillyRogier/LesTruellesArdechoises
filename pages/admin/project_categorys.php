<main class="grid">
    <div class="error-container"></div>
    <div class="products_container grid">
        <?php

        use App\Table\Pictures;

        foreach ($project_categorys as $project_category) : ?>
            <div class="project grid">
                <a href="<?= URL ?>/admin/projects-categorie/<?= $project_category->getUrl() ?>" class="slider-item grid">
                    <img src="<?= URL ?>\assets\img\<?= $project_category->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $project_category->getJoin(Pictures::class)->getAlt() ?>">
                    <div class="slider-item-container">
                        <div class="project-title-arrow grid">
                            <h3><?= $project_category->getName() ?></h3>
                            <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                        </div>
                    </div>
                </a>
                <a href="<?= URL ?>/admin/projects-categorie/update/<?= $project_category->getId() ?>" class="btn">Changer</a>
                <?=

                $form
                    ->change("id", ['value' => $project_category->getId()])
                    ->createView();

                ?>
            </div>
        <?php endforeach; ?>
        <a href="<?= URL ?>/admin/projects-categorie/insert" class="card-insert grid">
            <img src="<?= URL ?>/assets/icon/plus_color.svg" alt="">
        </a>
    </div>
</main>