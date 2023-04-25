<main class="grid">
    <div class="error-container"><?= isset($_SESSION['message']) ?  $_SESSION['message'] : "" ?></div>
    <h1 class="categories_title">Comptes</h1>
    <a href="<?= URL ?>/admin/register" class="btn">Ajouter un compte</a>
    <table class="table my-5">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">email</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user->getId() ?></td>
                    <td><?= $user->getEmail() ?></td>
                    <td><a href="<?= URL ?>/admin/users/update/<?= $user->getId() ?>" class="btn">modifier</a></td>
                    <td>
                        <?=

                        $form_delete
                            ->change("id", ['value' => $user->getId()])
                            ->createView()

                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>