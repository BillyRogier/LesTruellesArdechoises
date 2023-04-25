<main class="grid">
    <section id="home" class="grid">
        <div class="carousel grid">
            <?php

            use App\Table\Pictures;

            foreach ($carousels as $img) : ?>
                <div class="carousel-item">
                    <img src="<?= URL ?>\assets\img\<?= $img->getSrc() ?>" alt="<?= $img->getAlt() ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="background-shadow"></div>
        <div class="data grid">
            <h1><?= $h1 ?></h1>
            <div class="carousel-container grid">
                <div class="carousel-indicators grid">
                    <?php foreach ($carousels as $img) : ?>
                        <div class="carousel-indicator"></div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($carousels) > 1) : ?>
                    <div class="carousel-arrows grid">
                        <div class="arrow left "><img src="<?= URL ?>/assets/icon/arrow-left.svg" alt=""></div>
                        <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="arrow down scroll-down"><img src="<?= URL ?>/assets/icon/arrow-down.svg" alt=""></div>
    </section>
    <div class="section-container grid">
        <?php if ($content) : ?>
            <section class="about">
                <div class="data grid">
                    <div class="subtitle">
                        <h2>À propos</h2>
                    </div>
                    <img src="<?= URL ?>/assets/img/<?= $content->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $content->getJoin(Pictures::class)->getAlt() ?>">
                    <div class="about_data grid">
                        <p><?= $content->getText() ?></p>
                        <a href="<?= URL ?>/about" class="btn">Voir plus</a>
                    </div>
                </div>
            </section>
        <?php endif ?>
        <section id="project">
            <div class="data grid">
                <div class="section_bar grid">
                    <div class="subtitle">
                        <h2>Nos projets</h2>
                    </div>
                </div>
                <div class="slider-container grid">
                    <?php require_once ROOT . "/pages/app/slider.php" ?>
                </div>
            </div>
        </section>
        <?php if (isset($reviews) && !empty($reviews)) : ?>
            <section id="review">
                <div class="data grid">
                    <div class="subtitle">
                        <h2>Nos Avis</h2>
                    </div>
                    <div class="carousel-wrapper grid">
                        <div class="carousel grid">
                            <?php foreach ($reviews as $review) : ?>
                                <div class="carousel-item grid">
                                    <div class="profil grid">
                                        <img src="<?= URL ?>/assets/img/<?= $review->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $review->getJoin(Pictures::class)->getAlt() ?>">
                                        <div class="data-user grid">
                                            <p class="user_name"><?= $review->getName() ?></p>
                                            <div class="stars grid">
                                                <?php for ($i = 0; $i < 5; $i++) :
                                                    if ($i < $review->getStar()) : ?>
                                                        <img src="<?= URL ?>/assets/icon/star_active.svg" alt="">
                                                    <?php else : ?>
                                                        <img src="<?= URL ?>/assets/icon/star.svg" alt="">
                                                <?php endif;
                                                endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <p> <?= $review->getText() ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="carousel-container grid">
                            <div class="carousel-indicators grid">
                                <?php foreach ($reviews as $review) : ?>
                                    <div class="carousel-indicator"></div>
                                <?php endforeach; ?>
                            </div>
                            <div class="carousel-arrows grid">
                                <div class="arrow left"><img src="<?= URL ?>/assets/icon/arrow-left.svg" alt=""></div>
                                <div class="arrow right"><img src="<?= URL ?>/assets/icon/arrow-right.svg" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif ?>
    </div>
</main>