<main class="grid">
    <div class="section-container grid">
        <section id="contact">
            <div class="data grid">
                <h1 class="contact_title"><?= $title ?></h1>
                <div class="form-container">
                    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
                    <?= $form ?>
                </div>
                <div class="contact-info grid">
                    <p class="contact-subtitle">Une question ou une demande particulère ? Utilisé le formulaire ou contacté nous via les informations ci-dessous</p>
                    <div class="info grid">
                        <p><?= $info->getEmail() ?></p>
                        <p><?= $info->getNum() ?></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>