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
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form onsubmit="filterHandler(event)">
                        <div class="card-header justify-content-between align-items-end">
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="personal">Personel</label>
                                <select class="form-select" id="personal" name="personal_id">
                                    <option value="-1" disabled>Personel seçiniz</option>
                                    @if (count($personals) > 0)
                                        @foreach ($personals as $person)
                                            <option value="{{ $person->id }}">{{ $person->information->name }}
                                                {{ $person->information->surname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label" for="date">Tarih</label>
                                <input class="form-control" type="month" name="date" id="date" />
                            </div>
                            <div class="col-md-3 col-6 text-end">
                                <button class="btn btn-primary" type="button" onclick="clearFilters()">Filtreleri
                                    Temizle</button>
                                <button class="btn btn-primary" type="submit">Filtrele</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <table class="table" id="dayoff-table">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('page-script')
    <script>
        $(function() {
            "use strict";
        })

        var datatable = $("#dayoff-table").DataTable({
            serverSide: false,
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

                        let elements = "<div class='btn-tooltip'>";

                        if ("{{ auth()->user()->can('dayoff.update') }}" === "1") {
                            elements += ` <a href="/dayoff/${full['id']}" class="btn bg-transparent p-0">${feather.icons["edit-2"].toSvg({
                                class: "font-small-4 text-primary",
                            })}</a>`
                        }

                        if ("{{ auth()->user()->can('dayoff.delete') }}" === "1") {
                            elements += `<button class="btn bg-transparent p-0" onclick="deleteHandler(this,${full["id"]})">${feather.icons["trash"].toSvg({
                                class: "font-small-4 text-danger",
                            })}</button>`
                        }

                        elements += '</div>'

                        return elements;

                    }
                }
            ],
            searching: false,
            info: false,
            paginate: true,
            language: {
                lengthMenu: "_MENU_ adet izin göster",
                emptyTable: "Filtreye uygun veri bulunmamakta",
                zeroRecords: "Eşleşen veri bulunamadı",
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        })

        function filterHandler(e) {
            e.preventDefault();

            $.ajax({
                method: "POST",
                url: route('dayoff.filter'),
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 200) {
                        datatable.clear()
                        datatable.rows.add(res).draw();
                        toastr["success"](
                            res.message,
                            "Başarılı!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 2000,
                                progressBar: true
                            }
                        );
                    }
                },
                error: err => {
                    const errors = err.responseJSON.errors
                    Object.values(errors).map((error) => {
                        toastr["error"](
                            error,
                            "Hata!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 5000,
                                progressBar: true
                            }
                        );
                    })

                }
            })
        }

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

                    $.ajax({
                        method: "DELETE",
                        url: route('dayoff.delete', id),
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

        function clearFilters() {
            $.ajax({
                method: "GET",
                url: route('dayoff.dayOffs'),
                dataType: "json",
                success: res => {
                    $("#personal").val("-1")
                    $("#date").val("")
                    datatable.clear()
                    datatable.rows.add(res).draw();
                }
            })
        }
    </script>
@endsection
