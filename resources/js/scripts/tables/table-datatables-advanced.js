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
    var dt_ajax_table = $(".datatables-ajax"),
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
            ajax: route("stockTransfer.list"),
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
            columns: [
                {
                    defaultContent:
                        '<input type="button" class="name" value="Name"/><input type="button" class="position" value="Position"/>',
                },
                { data: "company_name" },
                { data: "product_name" },
                { data: "amount" },
                { data: "purchase_price" },
                { data: "id" },
            ],
        });
    }

    // Filter form control to default size for all tables
    $(".dataTables_filter .form-control").removeClass("form-control-sm");
    $(".dataTables_length .form-select")
        .removeClass("form-select-sm")
        .removeClass("form-control-sm");
});
