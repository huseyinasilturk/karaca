@extends('layouts/contentLayoutMaster')

@section('title', 'Ürün Listeleme')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('page-style')

@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="product-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ürün</th>
                                    <th>Adı</th>
                                    <th>Tipi</th>
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

            $("#product-table").DataTable({
                serverSide: true,
                ajax: {
                    url: route("product.products"),
                    method: "GET",
                    dataType: "json",
                    dataSrc: ""
                },
                columns: [{
                        data: "",
                        width: "5%"
                    },
                    {
                        data: "product_file_data",
                        width: "15%",
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "product_type_get.text1"
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
                            if (data !== null && data.length > 0) {
                                let path = "{{ asset('images/product/:path') }}"
                                path = path.replace(":path", data[0].file_name)
                                return `<img class='img-fluid' width='150' src="${path}" />`
                            } else {
                                return "<p>Ürün resmi bulunmamakta</p>"
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
                            if (data !== null && data !== undefined) {
                                return `<p>${data}</p>`
                            } else {
                                return "---"
                            }
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, full, meta) {
                            return `<div class="btn-tooltip">
                                <a href="/product/edit/${full['id']}" class="btn bg-transparent p-0">${feather.icons["edit-2"].toSvg({
                                class: "font-small-4 text-primary",
                            })}</a>
                            <button class="btn bg-transparent p-0" onclick="productDelete(this,${full["id"]})">${feather.icons["trash"].toSvg({
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

        function productDelete(el, id) {
            Swal.fire({
                title: 'Silmek istediğinden emin misin?',
                text: "Ürün kalıcı olarak silinir!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Vazgeç',
                confirmButtonText: 'Evet sil.'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: route('product.delete', id),
                        method: "delete",
                        success: (res) => {
                            if (res.status === 202) {
                                $(el).closest("tr").remove();
                                Swal.fire(
                                    'Silindi!',
                                    'Ürün başarıyla silindi.',
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Silinemedi!',
                                    'Ürün silinmesinde bir sorun oluştu yazılımcı ile iletişime geçin',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        }
    </script>
@endsection
