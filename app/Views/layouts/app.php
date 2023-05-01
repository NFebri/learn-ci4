<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <?= $this->renderSection('style'); ?>

        <title><?= $title; ?></title>
    </head>
    <body>
        <?= $this->include('layouts/navbar'); ?>
        <div class="container mt-5">
            <?= $this->renderSection('content'); ?>
        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.20/dist/sweetalert2.all.min.js"></script>

        <script>
            const showDataTable = (targetID, routes, columns, dataFilter = null) => {
                var table = $(targetID).DataTable({
                    processing: true,
                    serverSide: true,
                    paging: true,
                    searching: true,
                    destroy: true,
                    ajax: routes,
                    columns: columns,
                    data: dataFilter
                });
            }

            const ajaxRequest = (data = null, route, method = 'post') => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: route,
                        type: method,
                        dataType: 'json',
                        data: data,
                        beforeSend: function() {
                            Swal.fire({
                                allowOutsideClick: false,
                                title: 'Harap Menunggu',
                                text: 'Permintaan sedang di proses.',
                                showCancelButton: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                        },
                        success: function(response) {
                            Swal.close()
                            if (response.status) {
                                resolve(response)
                            } else {
                                reject(response)
                            }
                        },
                        error: function(err) {
                            Swal.close()
                            reject(err)
                        }
                    });
                })
            }

            const ajaxRequestFormData = (formData = null, route, method = 'post') => {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: route,
                        type: method,
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend:function(){
                            Swal.fire({
                                allowOutsideClick: false,
                                title: 'Harap Menunggu',
                                text: 'Permintaan sedang di proses.',
                                imageUrl: "{{ asset('assets/img/loading.png') }}",
                                imageHeight: 150,
                                imageWidth: 150,
                                showCancelButton: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            })
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.close()
                            if (response.status) {
                                resolve(response)
                            } else {
                                reject(response)
                            }
                        },
                        error: function(err) {
                            Swal.close()
                            reject(err)
                        }
                    });
                })
            }
        </script>

        <?= $this->renderSection('script'); ?>
    </body>
</html>