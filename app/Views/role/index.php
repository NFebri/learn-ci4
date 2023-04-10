<?= $this->extend('layouts/app'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col">
        <h1 class="mb-3">Roles</h1>

        <?= $this->include('components/flash-message'); ?>

        <table class="table table-sm" id="roles-table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function () {
    $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= route_to('roles_datatables') ?>"
        },
        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
    });
});
</script>
<?= $this->endSection(); ?>