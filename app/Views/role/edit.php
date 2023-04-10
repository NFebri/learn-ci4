<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-lg-6">
        <h1 class="mb-3">Edit Role</h1>
        <form action="<?= route_to('roles_update', $role->id) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control<?= session('errors.name') ? ' is-invalid' : '' ?>" id="name" value="<?= old('name') ?? $role->name ?>">
                <div class="invalid-feedback">
                    <?= session('errors.name'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="description">description</label>
                <textarea name="description" class="form-control<?= session('errors.description') ? ' is-invalid' : '' ?>" id="description">
                    <?= old('description') ?? $role->description ?>
                </textarea>
                <div class="invalid-feedback">
                    <?= session('errors.description'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="">Permissions</label><br>
                <?php foreach($permissions as $permission) : ?>
                <div class="form-check form-check-inline">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="permissions[]"
                        id="<?= $permission['name'] ?>"
                        value="<?= $permission['id'] ?>"
                        <?= in_array($permission['id'], $role_permissions) ? 'checked' : '' ?>
                    >
                    <label class="form-check-label" for="<?= $permission['name'] ?>"><?= $permission['name'] ?></label>
                </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>