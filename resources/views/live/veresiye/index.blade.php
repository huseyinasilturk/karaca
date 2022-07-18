@extends('layouts/contentLayoutMaster')

@section('title', 'Veresiye Listesi')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
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

        <!-- list and filter start -->
        <div class="card">
            <button type="button" data-bs-toggle="modal" data-bs-target="#modals-slide-in" class="btn btn-gradient-primary">
                Veresiye Ekle
            </button>



            <div class="row">
                <div class="col">
                    <div class="row m-2">
                        <div class="col-4">
                            <div class="row">
                                <label for="colFormLabelSm" class="col-sm-4 col-form-label-lg">Ay</label>
                                <div class="col-sm-8">
                                    <input type="month" class="form-control" name="date" min="2020-03"
                                        onchange="filterIncome()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-datatable table-responsive p-0">
                <table class="datatables-basic table" id="expenseStatements_table">
                    <thead>
                        <tr>
                            <th>Detay</th>
                            <th>Müşteri Adı</th>
                            <th>Veresiye Tipi</th>
                            <th>T. Fiyat</th>
                            <th>Kalan Fiyat</th>
                            <th>Ödenen Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ExpenseObjective as $value)
                            <tr dataid="{{ $value->aid }}">
                                <td>{{ $value->detail }}</td>
                                <td>{{ !empty($value->table_name) ? ($value->table_name != 'expense' ? $value->table_name : 'Diğer Gider') : 'Diğer Gider' }}
                                </td>
                                <td>{{ $value->table_name == 'users' ? 'Maaş' : $value->text1 }}</td>
                                <td>{{ $value->price }}</td>
                                <td>
                                   @can("expense.delete")
                                        @if ($value->table_name == 'expense')
                                            <button class="btn bg-transparent p-0" onclick="ıncomeStatementDelete(this)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash font-small-4 text-danger">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                   @endcan
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <section class="app-user-list">


                <!-- list and filter start -->
                <div class="card">

                    <div class="modal modal-slide-in new-user-modal fade " id="modals-slide-in">
                        <div class="modal-dialog">
                            <form id="insertOrUpdate" class="add-new-user modal-content pt-0"
                                action="{{ route('veresiye.store') }}" method="POST">
                                @csrf
                                <button type="button" class="btn-close modalCloseBtn" data-bs-dismiss="modal"
                                    aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Veresiye Ekle</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Detay</label>
                                        <textarea type="text" class="form-control" name="detail"></textarea>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="fp-default">T. Fiyat</label>
                                        <input type="text" name="price" class="form-control incomePrice flatpickr-basic"
                                            autocomplete="off" />
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="select2-basic">Müşteri Seçin</label>
                                        <select class="select2 form-select customerSelect" name="musteri_id">
                                        ];
                                            <option value="-1">Diğer</option>
                                            @foreach ($musteriler as $expns)
                                                <option value="{{ $expns->id }}">{{ $expns->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="select2-basic">Veresiye Tipi Seçin</label>
                                        <select class="select2 form-select customerSelect" name="veresiye_tipi">
                                            <option value="-1">Diğer</option>
                                            @foreach ($ExpenseType as $expns)
                                                <option value="{{ $expns->id }}">{{ $expns->text1 }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary me-1 data-submit data-submit-btn insert-or-update">Ekle</button>
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
        </div>
    @endsection

    @section('vendor-script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"
                integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
        <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>


    @endsection

    @section('page-script')
        <script src="{{ asset(mix('js/scripts/cards/card-analytics.js')) }}"></script>
        <script>
            cardRendered();

            function cardRendered() {
                $("#revenue-report-chart").children().eq(0).remove();
                const rapor = [];

                const aylar_value = [
                    "Ocak",
                    "Şubat",
                    "Mart",
                    "Nisan",
                    "Mayıs",
                    "Haziran",
                    "Temmuz",
                    "Ağustos",
                    "Eylül",
                    "Ekim",
                    "Kasım",
                    "Aralık",
                ];

                let product = $("select[name='product']").val();
                let date = $("input[name='date']").val();
                let customer = $("select[name='customer']").val();

                let aylar_vEkran = [];
                let gider = [];

                axios.post(route("expenseStatements.selectee"), {
                    product,
                    customer,
                    date
                }).then((res) => {
                    aylar_vEkran = [];
                    gider = [];
                    res.data.rapor.map((val) => {
                        aylar_vEkran.push(aylar_value[val["mouth"]]);
                        gider.push(val["totalSum"]);
                    });
                }).then(() => {
                    test(gider, aylar_vEkran);
                });

                function test(gider, aylar_vEkran) {

                    "use strict";
                    var $textMutedColor = "#b9b9c3";
                    var revenueReportChart;

                    var $revenueReportChart = document.querySelector("#revenue-report-chart");

                    var revenueReportChartOptions;
                    revenueReportChartOptions = {
                        chart: {
                            height: 230,
                            stacked: true,
                            type: "bar",
                            toolbar: {
                                show: false
                            },
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: "15px",
                            },
                            distributed: true,
                        },
                        colors: [window.colors.solid.primary, window.colors.solid.warning],
                        series: [{
                            name: "Gider",
                            data: gider,
                        }, ],
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            show: false,
                        },
                        grid: {
                            yaxis: {
                                lines: {
                                    show: false
                                },
                            },
                        },
                        xaxis: {
                            categories: aylar_vEkran,
                            labels: {
                                style: {
                                    colors: $textMutedColor,
                                    fontSize: "0.86rem",
                                },
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: $textMutedColor,
                                    fontSize: "0.86rem",
                                },
                            },
                        },
                    };
                    revenueReportChart = new ApexCharts(
                        $revenueReportChart,
                        revenueReportChartOptions
                    );
                    revenueReportChart.render();
                }


            }

            function filterIncome(params) {

                let date = $("input[name='date']").val();

                cardRendered();

                axios.post(route("expenseStatements.filter"), {
                    date
                }).then((res) => {
                    $("#expenseStatements_table").find("tbody").html("");

                    res.data.income.map((value, key) => {
                        islemlerTd = ``;
                        if (value.table_name == 'expense') {
                            islemlerTd = `
                                <button class="btn bg-transparent p-0" onclick="ıncomeStatementDelete(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-trash font-small-4 text-danger">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                </button>
                            `;
                            value.table_name = 'Diğer Gider';
                        }
                        $("#expenseStatements_table").find("tbody").append(

                            `
                        <tr dataid="${value.aid}">
                            <td>${value.detail}</td>
                            <td>${value.table_name}</td>
                            <td>${value.text1}</td>
                            <td>${value.price}</td>
                            <td>${islemlerTd}</td>
                        </tr>
`
                        )


                    })

                });
            }


            function ıncomeStatementDelete(ths) {
                let incomeId = $(ths).closest("tr").attr("dataid");
                let getUrl = route("expenseStatements.destroy", incomeId);
                axios.get(getUrl)
                    .then((response) => {
                        if (response.status == 202) {
                            let income = $('#expenseStatements_table').DataTable();
                            income.row($(ths).closest('tr')).remove().draw();
                            toastr["success"]("Gider başarıyla silindi.", "Silme İşlemi Başarılı");
                            cardRendered();
                        }
                    });
            }
        </script>
    @endsection

