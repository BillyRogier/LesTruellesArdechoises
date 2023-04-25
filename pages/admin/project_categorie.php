<main class="grid">
    <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
    <?=

    $form
        ->change("id", ['value' => $project_categorie->getId()])
        ->createView();

    ?>
</main>