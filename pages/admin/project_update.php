<main class="grid">
    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
    <?= $formPage ?>
    <?php

    use App\Table\Pictures;

    if (count($contents) > 0) {
        foreach ($contents as $content) : ?>
            <div class="form_content">
                <?php
                echo $formContent
                    ->change("id", ['value' => $content->getId()])
                    ->change("img", [
                        'value' => $content->getJoin(Pictures::class)->getSrc(),
                        'html' =>
                        '<img src="' . URL . '/assets/img/' . $content->getJoin(Pictures::class)->getSrc() . '" alt="' . $content->getJoin(Pictures::class)->getAlt() . '">
                        <input name="alt" type="text" placeholder="Description image" class="img_alt" value="' . $content->getJoin(Pictures::class)->getAlt() . '">
                        <span class="del_image btn">delete</span>'
                    ])
                    ->change("file", ['class' => 'file', 'label' => 'file', 'id' => uniqid()])
                    ->change("subtitle", ['value' => $content->getSubtitle(), 'label' => 'Subtitle', 'id' => uniqid()])
                    ->change("text", ['value' => $content->getText(), 'label' => 'Descripition', 'id' => uniqid()])
                    ->createView(); ?>
                <button class="del btn del_content">
                    delete
                </button>
            </div>
        <?php endforeach ?>
    <?php }  ?>
    <div class="form_content">
        <?php echo $formContent
            ->change("id")
            ->change("img")
            ->change("file", ['class' => 'file', 'label' => 'file', 'id' => uniqid()])
            ->change("subtitle", ['label' => 'Subtitle', 'id' => uniqid()])
            ->change("text", ['label' => 'Descripition', 'id' => uniqid()])
            ->createView(); ?>
    </div>
    </div>
</main>