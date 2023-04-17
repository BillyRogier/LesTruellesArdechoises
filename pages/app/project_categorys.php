<main class="grid">
    <div class="section-container grid">
        <section id="categories">
            <div class="data grid">
                <h1 class="categories_title"><?= $h1 ?></h1>
                <div class="projects-container grid">
                    <?php

                    use App\Table\Pages;
                    use App\Table\Pictures;

                    foreach ($projects as $project) : ?>
                        <a href="<?= URL ?>/project/<?= $project_category->getUrl() ?>/<?= $project->getJoin(Pages::class)->getUrl() ?>" class="slider-item grid">
                            <img src="<?= URL ?>\assets\img\<?= $project->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $project->getJoin(Pictures::class)->getAlt() ?>">
                            <div class="slider-item-container">
                                <div class="project-title-arrow grid">
                                    <h3><?= $project->getJoin(Pages::class)->getTitle() ?></h3>
                                    <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </div>
</main>