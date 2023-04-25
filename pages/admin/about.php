<main class="grid">
    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
    <?php

    $start_form = $form->createView();

    use App\Table\Pictures;

    foreach ($contents as $content) : ?>

        <div class="form_content">
            <?=

            $form
                ->change("id", ['value' => $content->getId()])
                ->change("img", [
                    'value' => $content->getJoin(Pictures::class)->getSrc(),
                    'html' =>
                    '<img src="' . URL . '/assets/img/' . $content->getJoin(Pictures::class)->getSrc() . '" alt="' . $content->getJoin(Pictures::class)->getAlt() . '">
                    <input name="alt" type="text" placeholder="Description image" class="img_alt" value="' . $content->getJoin(Pictures::class)->getAlt() . '">
                    <span class="del_image btn">delete</span>'
                ])
                ->change("file", ['class' => 'file', 'label' => 'file', 'id' => uniqid()])
                ->change("subtitle", ['value' => $content->getSubtitle(), 'label' => 'Subtitle', 'id' => "subtitle"])
                ->change("text", ['value' => $content->getText(), 'label' => 'Text', 'id' => "text"])
                ->createView();
            ?>
            <button class="del btn del_content">
                delete
            </button>
        </div>
    <?php endforeach;

    echo $start_form;

    ?>
</main>