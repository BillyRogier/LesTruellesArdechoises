<div class="slider grid">
    <?php

    use App\Table\Pictures;

    foreach ($project_categorys as $project_category) : ?>
        <a href="<?= URL ?>/project/<?= $project_category->getUrl() ?>" class="slider-item grid">
            <img src="<?= URL ?>\assets\img\<?= $project_category->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $project_category->getJoin(Pictures::class)->getAlt() ?>">
            <div class="slider-item-container">
                <div class="project-title-arrow grid">
                    <h3><?= $project_category->getName() ?></h3>
                    <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<div class="slider-arrows grid">
    <div class="arrow left"><img src="<?= URL ?>/assets/icon/arrow-left.svg" alt=""></div>
    <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
</div>
<div class="slider-indicators grid">
    <?php foreach ($project_categorys as $project_category) : ?>
        <div class="slider-indicator"></div>
    <?php endforeach; ?>
</div>