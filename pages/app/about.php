<main class="grid">
    <div class="section-container grid">
        <div class="projects data grid">
            <h1 class="contact_title">À propos</h1>
            <div class="contents grid">
                <?php

                use App\Table\Pictures;

                foreach ($contents as $content) : ?>
                    <section class="about">
                        <div class="data grid">
                            <div class="subtitle">
                                <h2><?= $content->getSubtitle() ?></h2>
                            </div>
                            <img src="<?= URL ?>/assets/img/<?= $content->getJoin(Pictures::class)->getSrc() ?>" alt="<?= $content->getJoin(Pictures::class)->getAlt() ?>">
                            <div class="about_data grid">
                                <div class="subtitle">
                                    <h2><?= $content->getSubtitle() ?></h2>
                                </div>
                                <p><?= $content->getText() ?></p>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>