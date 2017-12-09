<div class="container">
    <div class="page-header-left">
        <h1><?= $title ?></h1>
    </div>
</div>


<div class="pull-right">
    <a href="create" class="btn btn-success">Create user</a>
</div>

<div class="clear"></div>

<table class="table table-bordered table-hover">
    <tr>
        <td><b>First Name</b></td>
        <td><b>Last Name</b></td>
        <td><b>Age</b></td>
        <td style="width: 120px"></td>
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user->first_name ?></td>
            <td><?= $user->last_name ?></td>
            <td><?= $user->age ?></td>
            <td>
                <a href="update/?id=" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-danger" name="delete"><i class="fa fa-remove"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>