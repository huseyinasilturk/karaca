/*=========================================================================================
    File Name: card-analytics.js
    Description: Card Analytics page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
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

const aylar_vEkran = [];
const gelir = [];

axios.get(route("income.selectee")).then((res) => {
    console.log(res);
    res.data.map((val) => {
        aylar_vEkran.push(aylar_value[val["mouth"]]);
        gelir.push(val["totalSum"]);
    });
    console.log(aylar_vEkran);
});
$(window).on("load", function () {
    "use strict";
    var $textMutedColor = "#b9b9c3";
    var revenueReportChart;

    var $revenueReportChart = document.querySelector("#revenue-report-chart");

    var revenueReportChartOptions;
    // Revenue Report Chart
    // ----------------------------------
    revenueReportChartOptions = {
        chart: {
            height: 230,
            stacked: true,
            type: "bar",
            toolbar: { show: false },
        },
        plotOptions: {
            bar: {
                columnWidth: "15px",
            },
            distributed: true,
        },
        colors: [window.colors.solid.primary, window.colors.solid.warning],
        series: [
            {
                name: "Gelir",
                data: gelir,
            },
        ],
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            yaxis: {
                lines: { show: false },
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
});
