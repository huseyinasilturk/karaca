/**
 * App Calendar Events
 */

 'use strict';

 var date = new Date();
 var nextDay = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
 // prettier-ignore
 var nextMonth = date.getMonth() === 11 ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
 // prettier-ignore
 var prevMonth = date.getMonth() === 11 ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})
 var events = [];
 $.ajax({
    url: route('reminder.events'),
    method: "POST",
    success: (res) => {
        if (res.status === 201) {
            var resEvents=res.events;
            $.each( resEvents, function( key, value ) {
                value.start = new Date(value.start);
                value.end = new Date(value.end);
                value.url='';
                value.allDay=false;
                value.extendedProps={ calendar: 'business',detail: value.detail};
                resEvents[key]=value;
            });
            events = resEvents;
            $('.input-filter').click();
        }
    }
})
//  var events = [
//    {
//      id: 2,
//      url: '',
//      title: 'Meeting With Client',
//      start: new Date(date.getFullYear(), date.getMonth() + 1, -11),
//      end: new Date(date.getFullYear(), date.getMonth() + 1, -10),
//      allDay: true,
//      extendedProps: {
//        calendar: 'Business'
//      }
//    },
//  ];
