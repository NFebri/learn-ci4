<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-lg-6">
        <h1 class="mb-3">Create User</h1>
        <form action="<?= route_to('users_store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="username">username</label>
                <input type="text" name="username" class="form-control<?= session('errors.username') ? ' is-invalid' : '' ?>" id="username" value="<?= old('username') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.username'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email" class="form-control<?= session('errors.email') ? ' is-invalid' : '' ?>" id="email" value="<?= old('email') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.email'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password_hash">password</label>
                <input type="password" name="password_hash" class="form-control<?= session('errors.password_hash') ? ' is-invalid' : '' ?>" id="password_hash" value="<?= old('password_hash') ?>">
                <div class="invalid-feedback">
                    <?= session('errors.password_hash'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" class="form-control<?= session('errors.role_id') ? ' is-invalid' : '' ?>" id="role_id">
                    <?php foreach($roles as $role) : ?>
                        <option value="<?= $role->id ?>"><?= $role->name ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= session('errors.role_id'); ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>