<?= $this->extend('layouts/app'); ?>

<?= $this->section('style'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col">
        <h1 class="mb-3">News</h1>
        <a href="<?= route_to('news_create') ?>" class="btn btn-primary my-3">Create</a>

        <?= $this->include('components/flash-message'); ?>

        <table class="table table-sm" id="news-table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Body</th>
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
        showNews();
    });

    const showNews = () => {
        const columns = [
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'body',
                name: 'body'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];

        showDataTable('#news-table', "<?= route_to('news_datatables') ?>", columns)
    }

    const deleteNews = (id) => {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "untuk menghapus data tersebut!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let route = `<?= base_url('news/') ?>` + id
                ajaxRequest(null, route, 'DELETE')
                    .then(({ messages }) => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: messages,
                            icon: 'success',
                        }).then(() => {
                            showNews()
                        })
                    })
                    .catch((e) => {
                        if (typeof(e.responseJSON.messages) == 'object') {
                            let textError = '';
                            $.each(e.responseJSON.messages, function(key, value) {
                                textError += `${value}<br>`
                            });
                            Swal.fire({
                                title: 'Gagal!',
                                html: textError,
                                icon: 'error',
                            })
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: e.responseJSON.messages,
                                icon: 'error',
                            })
                        }
                    })
            }
        })
    }
</script>
<?= $this->endSection(); ?>