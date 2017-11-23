<?php
/**
 * @var $users UserModel[]
 * @var $title string
 */
?>
<h1><?= $title ?></h1>

<table>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->getFirstName() ?></td>
            <td><?= $user->getLastName() ?></td>
            <td><?= $user->getAge() ?></td>
        </tr>
    <?php endforeach; ?>
</table>