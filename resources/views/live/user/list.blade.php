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
            <div class="card-datatable table-responsive p-3">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>Name</th>
                            <th>EMAIL</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal modal-slide-in new-user-modal fade " id="modals-slide-in">
                <div class="modal-dialog">
                    <form id="add-new-user" class="add-new-user modal-content pt-0" action="{{ route('user.store') }}" method="POST">
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
                                <label class="form-label" for="user-plan">Firma</label>
                                <select name="company_id" class="select2 form-select">

                                    @foreach ($company as $value )
                                        <option value="{{$value['id']}}">{{$value["name"]}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 data-submit data-submit-btn">Ekle</button>
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
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>

@endsection

@section('page-script')
    {{-- Page js files --}}
    <script>
/**
 * DataTables Basic
 */

 $(function () {
    "use strict";

    var dt_basic_table = $(".datatables-basic"),
        assetPath = "../../../app-assets/";

    if ($("body").attr("data-framework") === "laravel") {
        assetPath = $("body").attr("data-asset-path");
    }

    if (dt_basic_table.length) {
        var dt_basic = dt_basic_table.DataTable({
            ajax: route("user.userList"),
            columns: [
                { data: "user_id" },
                { data: "id" },
                { data: "id" }, // used for sorting so will hide this column
                { data: "name_surname" },
                { data: "email" },
                { data: "birthday" },
                { data: "role_title" },
                { data: "" },
            ],
            columnDefs: [

                {
                    // For Responsive
                    className: "control",
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                            data +
                            '" /><label class="form-check-label" for="checkbox' +
                            data +
                            '"></label></div>'
                        );
                    },
                    checkboxes: {
                        selectAllRender:
                            '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
                    },
                },
                {
                    targets: 2,
                    visible: false,
                },
                {
                    // Avatar image/badge, Name and post
                    targets: 3,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        let  $post = full["user_name"];
                        // For Avatar badge
                        var stateNum = full["status"];
                        var states = [
                            "success",
                            "danger",
                            "warning",
                            "info",
                            "dark",
                            "primary",
                            "secondary",
                        ];
                        var $state = states[stateNum],
                            $name = full["name_surname"],
                            $initials = $name.match(/\b\w/g) || [];

                        $initials = (
                            ($initials.shift() || "") +
                            ($initials.pop() || "")
                        ).toUpperCase();

                        let $output =
                            '<span class="avatar-content">' +
                            $initials +
                            "</span>";

                        var colorClass = " bg-light-" + $state + " " ;
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar ' +
                            colorClass +
                            ' me-1">' +
                            $output +
                            "</div>" +
                            '<div class="d-flex flex-column">' +
                            '<span class="emp_name text-truncate fw-bold">' +
                            $name +
                            "</span><span class='tr-companyId d-none'>"+ full["company_id"]+"</span> <span class='tr-name d-none'>"+full["name"]+"</span> <span class='tr-surname d-none'>"+full["surname"]+"</span>" +
                            "<small class='emp_post text-truncate text-muted'> <span class='tr-user-name'>"+ $post+"</span></small>" +
                            "</div>" +
                            "</div>";
                        return $row_output;
                    },
                },
                {
                    targets: -4,
                    render: function (data, type, full, meta) {
                         return "<span class='tr-email'>"+ data+"</span>";

                    },
                },
                {
                    targets: -3,
                    render: function (data, type, full, meta) {
                        return "<span class='tr-birthday'>"+ moment(data).format("DD.MM.YYYY")+"</span>";
                    },
                },
                {
                    // Label
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var $status_number = full["role_name"];
                        var $status = {
                            admin: {
                                title: "Current",
                                class: "badge-light-primary",
                            },
                            user: {
                                title: "Professional",
                                class: " badge-light-success",
                            }
                        };
                        if (typeof $status[$status_number] === "undefined") {
                            return (
                            '<span class="badge rounded-pill badge-light-danger">' +
                            data +
                            "</span><span class='tr-role d-none'>"+ full["role_name"]+"</span>"
                        );
                        }
                        return (
                            '<span class="badge rounded-pill ' +
                            $status[$status_number].class +
                            '">' +
                            data +
                            "</span><span class='tr-role d-none'>"+ full["role_name"]+"</span>"
                        );
                    },
                },
                {
                    // Actions
                    targets: -1,
                    title: "Actions",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        console.log(full);
                        return (
                            '<div class="d-inline-flex">' +
                            '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                            feather.icons["more-vertical"].toSvg({
                                class: "font-small-4",
                            }) +
                            "</a>" +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                            '<a href="javascript:;" class="dropdown-item">' +
                            feather.icons["file-text"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "Details</a>" +
                            '<a href="javascript:;" class="dropdown-item">' +
                            feather.icons["archive"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "Archive</a>" +
                            '<a href="javascript:;" class="dropdown-item delete-record">' +
                            feather.icons["trash-2"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            `Delete</a>
                            </div>
                            </div>
                            <a onclick="fun_userEdit(this)"   user_id="${full["user_id"]}" class="item-edit">` +
                            feather.icons["edit"].toSvg({
                                class: "font-small-4",
                            }) +
                            "</a>"
                        );
                    },
                },
            ],
            createdRow: function( row, data, dataIndex ) {
                $(row).attr('user_id', data["user_id"]);
            },
            order: [[2, "desc"]],
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [
                {
                    extend: "collection",
                    className: "btn btn-outline-secondary dropdown-toggle me-2",
                    text:
                        feather.icons["share"].toSvg({
                            class: "font-small-4 me-50",
                        }) + "Çıktı Al",
                    buttons: [
                        {
                            extend: "print",
                            text:
                                feather.icons["printer"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Yazdır",
                            className: "dropdown-item",
                            exportOptions: { columns: [3, 4, 5, 6, 7] },
                        },
                        {
                            extend: "csv",
                            text:
                                feather.icons["file-text"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Csv",
                            className: "dropdown-item",
                            exportOptions: { columns: [3, 4, 5, 6, 7] },
                        },
                        {
                            extend: "excel",
                            text:
                                feather.icons["file"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Excel",
                            className: "dropdown-item",
                            exportOptions: { columns: [3, 4, 5, 6, 7] },
                        },
                        {
                            extend: "pdf",
                            text:
                                feather.icons["clipboard"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Pdf",
                            className: "dropdown-item",
                            exportOptions: { columns: [3, 4, 5, 6, 7] },
                        },
                        {
                            extend: "copy",
                            text:
                                feather.icons["copy"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Copy",
                            className: "dropdown-item",
                            exportOptions: { columns: [3, 4, 5, 6, 7] },
                        },
                    ],
                    init: function (api, node, config) {
                        $(node).removeClass("btn-secondary");
                        $(node).parent().removeClass("btn-group");
                        setTimeout(function () {
                            $(node)
                                .closest(".dt-buttons")
                                .removeClass("btn-group")
                                .addClass("d-inline-flex");
                        }, 50);
                    },
                },
                {
                    text:
                        feather.icons["plus"].toSvg({
                            class: "me-50 font-small-4",
                        }) + "Yeni Personel Ekle",
                    className: "create-new btn btn-primary",
                    attr: {
                        "data-bs-toggle": "modal",
                        "data-bs-target": "#modals-slide-in",
                        "id":"personal-add-update",
                    },
                    init: function (api, node, config) {
                        $(node).removeClass("btn-secondary");
                    },
                },
            ],
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
        $("div.head-label").html(
            '<h3 class="mb-0">Personeller</h3>'
        );
    }




    // Delete Record
    $(".datatables-basic tbody").on("click", ".delete-record", function () {
        dt_basic.row($(this).parents("tr")).remove().draw();
        $.ajax({
                url: "{{ route('objective.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function() {
                    $(el).attr('disabled', true);
                },
                success: (res) => {

                },
                error: (err) => {

                },
                complete: function() {

                },
            });





    });

});


$("body").on("click", "#personal-add-update", function () {

    $("input[name='name']").val("");
    $("input[name='surname']").val("");
    $("input[name='birthday']").val("");
    $("input[name='email']").val("");
    $("input[name='user_name']").val("");
    $("select[name='user_role']").val("");
    $("select[name='company_id']").val("");
    document.getElementById("add-new-user").setAttribute("action", route('user.store'));

});



function fun_userEdit(params) {

    const tr = $(params).closest("tr");
    $("input[name='name']").val($(tr).find(".tr-name").html());
    $("input[name='surname']").val($(tr).find(".tr-surname").html());
    $("input[name='birthday']").val($(tr).find(".tr-birthday").html());
    $("input[name='email']").val($(tr).find(".tr-email").html());
    $("input[name='user_name']").val($(tr).find(".tr-user-name").html());
    $("select[name='user_role']").val($(tr).find(".tr-role").html());
    $("select[name='company_id']").val($(tr).find(".tr-companyId").html());

    const userId = $(params).attr("user_id");

    document.getElementById("add-new-user").setAttribute("action", route("user.update", { id:userId  }));
    $('#modals-slide-in').modal('toggle');

    console.log($(tr).find(".tr-name").html());
}

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
