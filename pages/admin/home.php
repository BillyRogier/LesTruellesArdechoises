<main class="grid">
    <div class="error-container"> <?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?> </div>
    <?= $form ?>
</main>