@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
    <!-- users list start -->

    <section class="app-user-list">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">21,459</h3>
                            <span>Total Users</span>
                        </div>
                        <div class="avatar bg-light-primary p-50">
                            <span class="avatar-content">
                                <i data-feather="user" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">4,567</h3>
                            <span>Paid Users</span>
                        </div>
                        <div class="avatar bg-light-danger p-50">
                            <span class="avatar-content">
                                <i data-feather="user-plus" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">19,860</h3>
                            <span>Active Users</span>
                        </div>
                        <div class="avatar bg-light-success p-50">
                            <span class="avatar-content">
                                <i data-feather="user-check" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">237</h3>
                            <span>Pending Users</span>
                        </div>
                        <div class="avatar bg-light-warning p-50">
                            <span class="avatar-content">
                                <i data-feather="user-x" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- list and filter start -->
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title">Search & Filter</h4>
                <div class="row">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_plan"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Salary</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->


            <div class="modal modal-slide-in new-user-modal fade " id="modals-slide-in">
                <div class="modal-dialog">
                    <form class="add-new-user modal-content pt-0" action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni personel kaydet.</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Adı (*)</label>
                                <input type="text" class="form-control dt-full-name" id="name" name="name"
                                    value="{{ old('name') }}" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Soyadı (*)</label>
                                <input type="text" class="form-control dt-full-name" name="surname"
                                    value="{{ old('surname') }}" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="fp-default">Doğum Tarihi</label>
                                <input type="text" name="birthday" class="form-control flatpickr-basic"
                                    placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-uname">Username (*)</label>
                                <input type="text" class="form-control dt-uname" name="user_name"
                                    value="{{ old('user_name') }}" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-email">Email (*)</label>
                                <input type="text" class="form-control dt-email" placeholder="john.doe@example.com"
                                    name="email" value="{{ old('email') }}" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="user-role">User Role</label>
                                <select id="user-role" class="select2 form-select" name="user_role">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="user-plan">Birimi</label>
                                <select id="user-plan" class="select2 form-select">
                                    <option value="basic">Basic</option>
                                    <option value="enterprise">Enterprise</option>
                                    <option value="company">Company</option>
                                    <option value="team">Team</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 data-submit">Ekle</button>
                            <button type="reset" onclick="modalHide(this)" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">İptal</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
        </div>
        <!-- list and filter end -->
    </section>
    <!-- users list ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script>
/**
 * DataTables Advanced
 */

 "use strict";

// Advanced Search Functions Starts
// --------------------------------------------------------------------

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
        onClose: function (selectedDates, dateStr, instance) {
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
var filterByDate = function (column, startDate, endDate) {
    // Custom filter syntax requires pushing the new filter to the global filter array
    $.fn.dataTableExt.afnFiltering.push(function (
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
var normalizeDate = function (dateString) {
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

$(function () {
    var isRtl = $("html").attr("data-textdirection") === "rtl";

    var dt_ajax_table = $(".datatables-ajax"),
        dt_filter_table = $(".dt-column-search"),
        dt_adv_filter_table = $(".dt-advanced-search"),
        dt_responsive_table = $(".dt-responsive"),
        assetPath = "../../../app-assets/";

    if ($("body").attr("data-framework") === "laravel") {
        assetPath = $("body").attr("data-asset-path");
    }

    // Ajax Sourced Server-side
    // --------------------------------------------------------------------

    if (dt_ajax_table.length) {
        var dt_ajax = dt_ajax_table.dataTable({
            processing: true,
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: assetPath + "data/ajax.php",
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        });
    }

    // Column Search
    // --------------------------------------------------------------------

    if (dt_filter_table.length) {
        // Setup - add a text input to each footer cell
        $(".dt-column-search thead tr")
            .clone(true)
            .appendTo(".dt-column-search thead");
        $(".dt-column-search thead tr:eq(1) th").each(function (i) {
            var title = $(this).text();
            $(this).html(
                '<input type="text" class="form-control form-control-sm" placeholder="Search ' +
                    title +
                    '" />'
            );

            $("input", this).on("keyup change", function () {
                if (dt_filter.column(i).search() !== this.value) {
                    dt_filter.column(i).search(this.value).draw();
                }
            });
        });

        var dt_filter = dt_filter_table.DataTable({
            ajax: assetPath + "data/table-datatable.json",
            columns: [
                { data: "full_name" },
                { data: "email" },
                { data: "post" },
                { data: "city" },
                { data: "start_date" },
                { data: "salary" },
            ],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            orderCellsTop: true,
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        });
    }

    // Advanced Search
    // --------------------------------------------------------------------

    // Advanced Filter table
    if (dt_adv_filter_table.length) {
        var dt_adv_filter = dt_adv_filter_table.DataTable({
            ajax: assetPath + "data/table-datatable.json",
            columns: [
                { data: "responsive_id" },
                { data: "full_name" },
                { data: "email" },
                { data: "post" },
                { data: "city" },
                { data: "start_date" },
                { data: "salary" },
            ],

            columnDefs: [
                {
                    className: "control",
                    orderable: false,
                    targets: 0,
                },
            ],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            orderCellsTop: true,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return "Details of " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIndex +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      "<td>" +
                                      col.title +
                                      ":" +
                                      "</td> " +
                                      "<td>" +
                                      col.data +
                                      "</td>" +
                                      "</tr>"
                                : "";
                        }).join("");

                        return data
                            ? $('<table class="table"/><tbody />').append(data)
                            : false;
                    },
                },
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        });
    }

    // on key up from input field
    $("input.dt-input").on("keyup", function () {
        filterColumn($(this).attr("data-column"), $(this).val());
    });

    // Responsive Table
    // --------------------------------------------------------------------

    if (dt_responsive_table.length) {
        var dt_responsive = dt_responsive_table.DataTable({
            ajax: assetPath + "data/table-datatable.json",
            columns: [
                { data: "responsive_id" },
                { data: "full_name" },
                { data: "email" },
                { data: "post" },
                { data: "city" },
                { data: "start_date" },
                { data: "salary" },
                { data: "age" },
                { data: "experience" },
                { data: "status" },
            ],
            columnDefs: [
                {
                    className: "control",
                    orderable: false,
                    targets: 0,
                },
                {
                    // Label
                    targets: -1,
                    render: function (data, type, full, meta) {
                        var $status_number = full["status"];
                        var $status = {
                            1: {
                                title: "Current",
                                class: "badge-light-primary",
                            },
                            2: {
                                title: "Professional",
                                class: " badge-light-success",
                            },
                            3: {
                                title: "Rejected",
                                class: " badge-light-danger",
                            },
                            4: {
                                title: "Resigned",
                                class: " badge-light-warning",
                            },
                            5: { title: "Applied", class: " badge-light-info" },
                        };
                        if (typeof $status[$status_number] === "undefined") {
                            return data;
                        }
                        return (
                            '<span class="badge rounded-pill ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            "</span>"
                        );
                    },
                },
            ],
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return "Details of " + data["full_name"];
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIdx +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      "<td>" +
                                      col.title +
                                      ":" +
                                      "</td> " +
                                      "<td>" +
                                      col.data +
                                      "</td>" +
                                      "</tr>"
                                : "";
                        }).join("");

                        return data
                            ? $('<table class="table"/>').append(
                                  "<tbody>" + data + "</tbody>"
                              )
                            : false;
                    },
                },
            },
            language: {
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
});


    </script>
    <script src="{{ asset(mix('js/scripts/forms/pickers/form-pickers.js')) }}"></script>

    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#modals-slide-in').modal('toggle');
            });
        </script>
    @endif
@endsection
