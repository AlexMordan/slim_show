<?php
require_once __DIR__ . "/../header.php";

/** @var \App\Model\User $user */

?>

<div class="container">

    <div class="profile">
        <div class="avatar">
            <img src="<?php echo $user->getAvatar() ?>"
        </div>
        <div class="info">
            <span>
                <?= $user->getEmail() ?>
            </span>
        </div>
    </div>

</div>

<?php require_once __DIR__ . "/../footer.php"; ?>

