<div class="massage"><?=$massage?></div>

<form method="post" class="form" action="../update/?id=<?=$field['id']?>">

    <label for="firstName" class="label">First Name</label>
    <input type="text" class="form-control" name="firstName" id="firstName" value="<?=$field['first_name']?>">

    <label for="lastName" class="label">Last Name</label>
    <input type="text" class="form-control" name="lastName" id="lastName" value="<?=$field['last_name']?>">

    <label for="age" class="label">Age</label>
    <input type="number" class="form-control" name="age" id="age" value="<?=$field['age']?>">

    <input type="submit" value="Save" class="btn-success">

    <a href="../index" class="link">Users list</a> <!--todo: not existing link-->

</form>
