<?= $this->extend('layouts/app'); ?>
<?= $this->section('content'); ?>

<div class="row">
    <div class="col-lg-6">
        <h1 class="mb-3">Edit News</h1>
        <form action="<?= route_to('news_update', $news['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= $news['id'] ?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control<?= session('errors.title') ? ' is-invalid' : '' ?>" id="title" value="<?= old('title') ?? $news['title'] ?>">
                <div class="invalid-feedback">
                    <?= session('errors.title'); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea name="body" class="form-control<?= session('errors.body') ? ' is-invalid' : '' ?>" id="body">
                    <?= old('body') ?? $news['body'] ?>
                </textarea>
                <div class="invalid-feedback">
                    <?= session('errors.body'); ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>