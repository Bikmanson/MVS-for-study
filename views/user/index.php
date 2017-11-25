<?php
/**
 * @var $users UserModel[]
 * @var $title string
 * view code
 */
?>

<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $title ?></div>
    </div>
    <div class="page-header-right">
        <a href="/user/create" class="create-btn">Create user</a>
    </div>
</div>

<div class="clear"></div>

<table class="table">
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->getFirstName() ?></td>
            <td><?= $user->getLastName() ?></td>
            <td><?= $user->getAge() ?></td>
        </tr>
    <?php endforeach; ?>
</table>