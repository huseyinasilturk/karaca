/**
 * App Calendar Events
 */

"use strict";

var date = new Date();
var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
// prettier-ignore
var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
// prettier-ignore
var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var events = [];
$.ajax({
    url: route("reminder.events"),
    method: "POST",
    success: (res) => {
        if (res.status === 201) {
            var resEvents = res.events;
            $.each(resEvents, function (key, value) {
                value.date = new Date(value.date);
                value.url = "";
                value.allDay = false;
                value.extendedProps = {
                    calendar: value.status === "1" ? "select-all" : "holiday",
                    detail: value.detail,
                    date: value.date,
                    status: value.status,
                };
                resEvents[key] = value;
            });
            events = resEvents;
            $(".input-filter").click();
        }
    },
});
