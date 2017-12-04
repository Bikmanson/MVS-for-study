<?php
/**
 * @var $users User[]
 * @var $title string
 * view code
 */
?>

<div class="page-header">
    <div class="page-header-left">
        <div class="page-title"><?= $title ?></div>
    </div>
    <div class="page-header-right">
        <a href="create" class="create-btn">Create user</a>
    </div>
</div>

<div class="clear"></div>

<div class="tableBlock">
<table class="table">
    <tr>
        <td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Age</b></td>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->getFirstName() ?></td>
            <td><?= $user->getLastName() ?></td>
            <td><?= $user->getAge() ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</div>