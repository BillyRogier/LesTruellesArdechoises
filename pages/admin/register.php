<div class="login-container">
    <h1>Créer un compte</h1>
    <div class="login">
        <div class="error-container"><?= isset($_SESSION['message']) ? $_SESSION['message'] : "" ?></div>
        <?= $form ?>
    </div>
</div>