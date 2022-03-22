@extends('layouts/contentLayoutMaster')

@section('title', 'İzinler')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form>
                        <div class="card-header justify-content-between align-items-end">
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="personal">Personel</label>
                                <select class="form-select" id="personal" name="personal_id">
                                    <option value="-1">Personel seçiniz</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-6 text-end">
                                <button class="btn btn-primary w-100" type="button">Filtrele</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <table class="table" id="company-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ad</th>
                                    <th>Soyad</th>
                                    <th>Başlangıç Tarihi</th>
                                    <th>Bitiş Tarihi</th>
                                    <th>Gün Sayısı</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
@endsection

@section('page-script')
    <script>
        $(function() {
            "use strict";

            $("#company-table").DataTable({
                serverSide: true,
                ajax: {
                    url: route("dayoff.dayOffs"),
                    method: "GET",
                    dataType: "json",
                    dataSrc: ""
                },
                columns: [{
                        data: "",
                        width: "5%"
                    },
                    {
                        data: "person.information.name"
                    },
                    {
                        data: "person.information.surname"
                    },
                    {
                        data: "start_date"
                    },
                    {
                        data: "end_date"
                    },
                    {
                        data: "day"
                    },
                    {
                        data: "",
                        width: "5%"
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        render: function(data, type, full, meta) {
                            console.log(meta)
                            return `<p style="font-weight: bold">${meta.row + 1}</p>`
                        }
                    },
                    {
                        targets: 1,
                        render: function(data, type, full, meta) {
                            if (data !== null) {
                                return `<p>${data}</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 2,
                        render: function(data, type, full, meta) {
                            if (data !== null) {
                                return `<p>${data}</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 3,
                        render: function(data, type, full, meta) {
                            if (data !== null) {
                                return `<p>${moment(data).format("DD.MM.YYYY")}</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            if (data !== null) {
                                return `<p>${moment(data).format("DD.MM.YYYY")}</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 5,
                        render: function(data, type, full, meta) {
                            if (data !== null) {
                                return `<p>${data} gün</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 6,
                        render: function(data, type, full, meta) {
                            return `<div class="btn-tooltip">
                                <a href="/dayoff/${full['id']}" class="btn bg-transparent p-0">${feather.icons["edit-2"].toSvg({
                                class: "font-small-4 text-primary",
                            })}</a>
                            <button class="btn bg-transparent p-0" onclick="deleteHandler(this,${full["id"]})">${feather.icons["trash"].toSvg({
                                class: "font-small-4 text-danger",
                            })}</button>
                            </div>`;
                        }
                    }
                ],
                searching: false,
                info: false,
                paginate: false,
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: "&nbsp;",
                        next: "&nbsp;",
                    },
                },
            })
        })

        function deleteHandler(el, id) {
            Swal.fire({
                title: "Silmek istediğinize emin misiniz ?",
                text: "Bu işlem geri alınamaz !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Evet, sil !",
                cancelButtonText: "İptal et !",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-outline-secondary ms-1",
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.isConfirmed) {
                    let url = "{{ route('company.delete', ':id') }}";
                    url = url.replace(":id", id);

                    $.ajax({
                        method: "DELETE",
                        url: url,
                        success: (res, textStatus, xhr) => {
                            if (xhr.status === 200) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Başarılı!",
                                    text: res.message,
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                    },
                                });

                                $(el).closest("tr").remove();
                            }
                        },
                        error: err => {
                            toastr["error"](
                                err.responseJSON.message,
                                "Başarılı!", {
                                    closeButton: true,
                                    tapToDismiss: true,
                                    timeOut: 3000,
                                    progressBar: true
                                }
                            );
                        }
                    })
                }
            });


        }
    </script>
@endsection
