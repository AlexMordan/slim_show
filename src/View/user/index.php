<?php
require_once __DIR__ . "/../header.php";
?>

<div class="container">
    <table class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Логин</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php
    /** @var \App\Model\User[] $users */
    foreach ($users as $user): ?>
        <tr>
            <td>
                <?= $user->getFullName() ?>
            </td>
            <td>
                <?= $user->getLogin() ?>
            </td>
            <td>
                <?= $user->getEmail() ?>
            </td>
            <td>
                <?= $user->getRole() ?>
            </td>
            <td><a href="/users/<?= $user->getId()?>">Show</a></td>
        </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . "/../footer.php"; ?>

