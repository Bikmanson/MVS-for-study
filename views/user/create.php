<?php
/**
 * @var string $massage
 * @var $firstName
 * @var $lastName
 * @var $age
 *
 * view code
 */
?>

<div class="massage"><?=$massage?></div>

<form method="post" class="form">

    <label for="firstName" class="label">First Name</label>
    <input type="text" class="input" name="firstName" id="firstName" value="<?=$firstName?>">

    <label for="lastName" class="label">Last Name</label>
    <input type="text" class="input" name="lastName" id="lastName" value="<?=$lastName?>">

    <label for="age" class="label">Age</label>
    <input type="number" class="input" name="age" id="age" value="<?=$age?>">

    <input type="submit" value="Save">

    <a href="index" class="link">Users list</a>

</form>
