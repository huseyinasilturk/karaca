@extends('layouts/detachedLayoutMaster')

@section('title', 'Stok Aktarma')

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('page-style')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/plugins/forms/pickers/form-flat-pickr.css') }}">
@endsection



@section('content')
    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-datatable">
                        <table class="datatables-ajax table table-responsive">
                            <thead>
                                <tr>
                                    <th>Firma Adı</th>
                                    <th>Ürün Adı</th>
                                    <th>Adeti</th>
                                    <th>Alış Fiyatı</th>
                                    <th>-</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="stokTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="card">
                            <div class="card-body">
                                <form onsubmit="stockTransferFormHandler(event)" class="form form-horizontal">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="first-name">Firma</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="d-none" name="stock_id" id="stock_id" />
                                                    <input class="d-none" name="price" id="price" />
                                                    <input class="d-none" name="unit_type" id="unit_type" />
                                                    <input class="d-none" name="product_id" id="product_id" />
                                                    <select name="company_id" class="form-select"
                                                        aria-label="Default select example">
                                                        @foreach ($companies as $value)
                                                            <option value="{{ $value['id'] }}">{{ $value['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-1 row">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label" for="first-name">Adet</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="number" name="amount" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit"
                                                class="btn btn-primary me-1 waves-effect waves-float waves-light">Aktar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')

    <script>
        function stokAktar(el) {
            const stokId = $(el).attr("stkid");
            const max = $(el).closest("tr").find("td").eq(2).html();
            const price = $(el).closest("tr").find("td").eq(3).html();
            const product_id = $(el).attr("product_id");;
            const unit_type = $(el).attr("unit_type");;

            $("#stokTransfer").find("#stock_id").val(stokId);
            $("input[name='amount']").attr({
                "max": max, // substitute your own
                "min": 0 // values (or variables) here
            });
            $("input[name='price']").val(price);
            $("input[name='product_id']").val(product_id);
            $("input[name='unit_type']").val(unit_type);
            $("#stokTransfer").modal("show");
        }



        "use strict";

        // Filter column wise function
        function filterColumn(i, val) {
            if (i == 5) {
                var startDate = $(".start_date").val(),
                    endDate = $(".end_date").val();
                if (startDate !== "" && endDate !== "") {
                    filterByDate(i, startDate, endDate); // We call our filter function
                }

                $(".dt-advanced-search").dataTable().fnDraw();
            } else {
                $(".dt-advanced-search")
                    .DataTable()
                    .column(i)
                    .search(val, false, true)
                    .draw();
            }
        }

        // Datepicker for advanced filter
        var separator = " - ",
            rangePickr = $(".flatpickr-range"),
            dateFormat = "MM/DD/YYYY";
        var options = {
            autoUpdateInput: false,
            autoApply: true,
            locale: {
                format: dateFormat,
                separator: separator,
            },
            opens: $("html").attr("data-textdirection") === "rtl" ? "left" : "right",
        };

        //
        if (rangePickr.length) {
            rangePickr.flatpickr({
                mode: "range",
                dateFormat: "m/d/Y",
                onClose: function(selectedDates, dateStr, instance) {
                    var startDate = "",
                        endDate = new Date();
                    if (selectedDates[0] != undefined) {
                        startDate =
                            selectedDates[0].getMonth() +
                            1 +
                            "/" +
                            selectedDates[0].getDate() +
                            "/" +
                            selectedDates[0].getFullYear();
                        $(".start_date").val(startDate);
                    }
                    if (selectedDates[1] != undefined) {
                        endDate =
                            selectedDates[1].getMonth() +
                            1 +
                            "/" +
                            selectedDates[1].getDate() +
                            "/" +
                            selectedDates[1].getFullYear();
                        $(".end_date").val(endDate);
                    }
                    $(rangePickr).trigger("change").trigger("keyup");
                },
            });
        }

        // Advance filter function
        // We pass the column location, the start date, and the end date
        var filterByDate = function(column, startDate, endDate) {
            // Custom filter syntax requires pushing the new filter to the global filter array
            $.fn.dataTableExt.afnFiltering.push(function(
                oSettings,
                aData,
                iDataIndex
            ) {
                var rowDate = normalizeDate(aData[column]),
                    start = normalizeDate(startDate),
                    end = normalizeDate(endDate);

                // If our date from the row is between the start and end
                if (start <= rowDate && rowDate <= end) {
                    return true;
                } else if (rowDate >= start && end === "" && start !== "") {
                    return true;
                } else if (rowDate <= end && start === "" && end !== "") {
                    return true;
                } else {
                    return false;
                }
            });
        };

        // converts date strings to a Date object, then normalized into a YYYYMMMDD format (ex: 20131220). Makes comparing dates easier. ex: 20131220 > 20121220
        var normalizeDate = function(dateString) {
            var date = new Date(dateString);
            var normalized =
                date.getFullYear() +
                "" +
                ("0" + (date.getMonth() + 1)).slice(-2) +
                "" +
                ("0" + date.getDate()).slice(-2);
            return normalized;
        };
        // Advanced Search Functions Ends

        if ($(".datatables-ajax").length) {
            var dt_ajax = $(".datatables-ajax").dataTable({
                serverSide: false,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                ajax: {
                    "url": "http://127.0.0.1:8000/stockTransfer/list",
                    "type": "GET",
                },
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: "&nbsp;",
                        next: "&nbsp;",
                    },
                },
                columns: [{
                        "data": "company_name"
                    },
                    {
                        "data": "product_name"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "purchase_price"
                    },
                    {
                        "data": "id"
                    }
                ],
                columnDefs: [{
                    targets: 4,
                    render: function(data, type, full, meta) {
                        return `<a onclick="stokAktar(this)" unit_type="${full['unit_type']}" product_id="${full['product_id']}" class="badge bg-primary" style="color:white" stkid="${data}" > Stok Aktar </a>`;
                    }
                }],
                searching: false,
                info: false,
                paginate: true,
                language: {
                    lengthMenu: "_MENU_ adet limit göster",
                    emptyTable: "Filtreye uygun veri bulunmamakta",
                    zeroRecords: "Eşleşen veri bulunamadı",
                    paginate: {
                        // remove previous & next text from pagination
                        previous: "&nbsp;",
                        next: "&nbsp;",
                    },
                },

            });
        }

        // Filter form control to default size for all tables
        $(".dataTables_filter .form-control").removeClass("form-control-sm");
        $(".dataTables_length .form-select")
            .removeClass("form-select-sm")
            .removeClass("form-control-sm");

        function stockTransferFormHandler(e) {
            e.preventDefault();

            const formData = new FormData(e.target)

            axios.post("{{ route('stockTransfer.transfer') }}", formData).then(res => {
                console.log(res);
                toastr["success"](
                    res.data.message,
                    "Başarılı!", {
                        closeButton: true,
                        tapToDismiss: true,
                        timeOut: 2000,
                        progressBar: true
                    }
                );
                $(".datatables-ajax").DataTable().ajax.reload();
            })
        }
    </script>

@endsection
