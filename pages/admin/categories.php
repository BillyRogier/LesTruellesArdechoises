<main class="grid">
    <h1 class="categories_title"><?= $title ?></h1>
    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
    <div class="products_container grid">
        <?php

        use App\Table\Pages;
        use App\Table\Pictures;

        foreach ($projects as $project) : ?>
            <div class="project grid">
                <a href="<?= URL ?>/admin/projects/<?= $project_categorie->getUrl() ?>/<?= $project->getJoin(Pages::class)->getUrl() ?>/update" class="slider-item grid">
                    <img src="<?= URL ?>\assets\img\<?= $project->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $project->getJoin(Pictures::class)->getAlt() ?>">
                    <div class="slider-item-container">
                        <div class="project-title-arrow grid">
                            <h3><?= $project->getJoin(Pages::class)->getTitle() ?></h3>
                            <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                        </div>
                    </div>
                </a>
                <?=

                $form
                    ->change("id", ['value' => $project->getId()])
                    ->createView();

                ?>
            </div>
        <?php endforeach ?>
        <a href="<?= URL ?>/admin/projects/insert" class="card-insert grid">
            <img src="<?= URL ?>/assets/icon/plus_color.svg" alt="">
        </a>
    </div>
</main>