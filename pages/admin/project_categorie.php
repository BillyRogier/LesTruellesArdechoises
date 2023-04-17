<main class="grid">
    <div class="error-container"></div>
    <?=

    $form
        ->change("id", ['value' => $project_categorie->getId()])
        ->createView();

    ?>
</main>