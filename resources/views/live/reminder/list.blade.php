@extends('layouts/contentLayoutMaster')

@section('title', 'Hatırlatıcı Takvimi')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-calendar.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('page-style')
    <style>
        .fc-daygrid-block-event {
            color: white !important;
        }
    </style>
@endsection

@section('content')

    <section>
        <div class="app-calendar overflow-hidden border">
            <div class="row g-0">
                <!-- Sidebar -->
                <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column"
                    id="app-calendar-sidebar">
                    @can('reminder.add')
                        <div class="sidebar-wrapper">
                            <div class="card-body d-flex justify-content-center">
                                <button class="btn btn-primary btn-toggle-sidebar w-100" data-bs-toggle="modal"
                                    data-bs-target="#add-new-sidebar">
                                    <span class="align-middle">Hatırlatıcı Ekle</span>
                                </button>
                            </div>
                        </div>
                    @endcan
                    <div class="card-body pb-0 d-none">
                        <h5 class="section-label mb-1">
                            <span class="align-middle">Filter</span>
                        </h5>
                        <div class="form-check mb-1">
                            <input type="checkbox" class="form-check-input select-all" id="select-all" />
                            <label class="form-check-label" for="select-all">View All</label>
                        </div>
                        <div class="calendar-events-filter">
                            <div class="form-check form-check-primary mb-1">
                                <input type="checkbox" class="form-check-input input-filter" id="select-all"
                                    data-value="select-all" />
                                <label class="form-check-label" for="select-all">Business</label>
                            </div>
                            <div class="form-check form-check-success mb-1">
                                <input type="checkbox" class="form-check-input input-filter" id="holiday"
                                    data-value="holiday">
                                <label class="form-check-label" for="holiday">Holiday</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <img src="{{ asset('images/pages/calendar-illustration.png') }}" alt="Calendar illustration"
                            class="img-fluid" />
                    </div>
                </div>
                <!-- /Sidebar -->

                <!-- Calendar -->
                <div class="col position-relative">
                    <div class="card shadow-none border-0 mb-0 rounded-0">
                        <div class="card-body pb-0">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <!-- /Calendar -->
                <div class="body-content-overlay"></div>
            </div>
        </div>
        <!-- Calendar Add/Update/Delete event modal-->
        <div class="modal modal-slide-in event-sidebar fade" id="add-new-sidebar">
            <div class="modal-dialog sidebar-lg">
                <div class="modal-content p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Hatırlatıcı</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <form class="event-form needs-validation" data-ajax="false" novalidate>
                            <div class="mb-1">
                                <label for="title" class="form-label">Başlık</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Başlık" required />
                            </div>
                            <div class="mb-1 position-relative">
                                <label for="date" class="form-label">Tarih</label>
                                <input type="date" class="form-control" id="start-date" name="date"
                                    placeholder="Tarih" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Açıklama</label>
                                <textarea name="detail" id="event-description-editor" class="form-control"></textarea>
                            </div>
                            <div class="mb-1">
                                <div class="d-flex flex-column">
                                    <label class="form-check-label mb-50" for="status">Bildirimleri Aç</label>
                                    <div class="form-check form-check-primary form-switch">
                                        <input type="checkbox" name="status" value="1" checked
                                            onchange="switchHandler(this)" class="form-check-input" id="status" />
                                    </div>
                                </div>
                                <div class="d-flex flex-column pt-3">
                                    <label class="form-check-label mb-50" for="status">1 Yıl boyunca</label>
                                    <div class="form-check form-check-primary form-switch">
                                        <input type="checkbox" name="year" value="1"
                                            onchange="switchHandler(this)" class="form-check-input" id="year" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 d-flex">
                                @can('reminder.add')
                                    <button type="submit" class="btn btn-primary add-event-btn me-1">Ekle</button>
                                @endcan
                                @can('reminder.update')
                                    <button type="submit"
                                        class="btn btn-primary update-event-btn d-none me-1">Güncelle</button>
                                @endcan
                                @can('reminder.delete')
                                    <button class="btn btn-outline-danger btn-delete-event d-none">Sil</button>
                                @endcan
                                <button type="button" class="btn btn-outline-secondary btn-cancel"
                                    data-bs-dismiss="modal">Vazgeç</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Calendar Add/Update/Delete event modal-->
    </section>

@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/tr.min.js"></script> --}}
    <script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/app-calendar-reminder-events.js')) }}"></script>
    {{-- <script src="{{ asset(mix('js/scripts/pages/app-calendar-reminder.js')) }}"></script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

@endsection

@section('page-script')
    <script>
        $(document).ready(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

        })

        function switchHandler(el) {
            $(el).val($(el).prop("checked") ? "1" : "0")
        }


        // RTL Support
        var direction = "ltr",
            assetPath = "../../../app-assets/";
        if ($("html").data("textdirection") == "rtl") {
            direction = "rtl";
        }

        if ($("body").attr("data-framework") === "laravel") {
            assetPath = $("body").attr("data-asset-path");
        }

        $(document).on("click", ".fc-sidebarToggle-button", function(e) {
            $(".app-calendar-sidebar, .body-content-overlay").addClass("show");
        });

        $(document).on("click", ".body-content-overlay", function(e) {
            $(".app-calendar-sidebar, .body-content-overlay").removeClass("show");
        });

        document.addEventListener("DOMContentLoaded", function() {
            var calendarEl = document.getElementById("calendar"),
                eventToUpdate,
                sidebar = $(".event-sidebar"),
                calendarsColor = {
                    Business: "primary",
                    Holiday: "success",
                    Personal: "danger",
                    Family: "warning",
                    ETC: "info",
                },
                eventForm = $(".event-form"),
                addEventBtn = $(".add-event-btn"),
                cancelBtn = $(".btn-cancel"),
                updateEventBtn = $(".update-event-btn"),
                toggleSidebarBtn = $(".btn-toggle-sidebar"),
                eventTitle = $("#title"),
                eventLabel = $("#select-label"),
                startDate = $("#start-date"),
                endDate = $("#end-date"),
                eventUrl = $("#event-url"),
                status = $("#status"),
                eventGuests = $("#event-guests"),
                eventLocation = $("#event-location"),
                allDaySwitch = $(".allDay-switch"),
                selectAll = $(".select-all"),
                calEventFilter = $(".calendar-events-filter"),
                filterInput = $(".input-filter"),
                btnDeleteEvent = $(".btn-delete-event"),
                calendarEditor = $("#event-description-editor");

            // --------------------------------------------
            // On add new item, clear sidebar-right field fields
            // --------------------------------------------
            $(".add-event button").on("click", function(e) {
                $(".event-sidebar").addClass("show");
                $(".sidebar-left").removeClass("show");
                $(".app-calendar .body-content-overlay").addClass("show");
            });

            // Label  select
            if (eventLabel.length) {
                function renderBullets(option) {
                    if (!option.id) {
                        return option.text;
                    }
                    var $bullet =
                        "<span class='bullet bullet-" +
                        $(option.element).data("label") +
                        " bullet-sm me-50'> " +
                        "</span>" +
                        option.text;

                    return $bullet;
                }
                eventLabel.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Select value",
                    dropdownParent: eventLabel.parent(),
                    templateResult: renderBullets,
                    templateSelection: renderBullets,
                    minimumResultsForSearch: -1,
                    escapeMarkup: function(es) {
                        return es;
                    },
                });
            }

            // Guests select
            if (eventGuests.length) {
                function renderGuestAvatar(option) {
                    if (!option.id) {
                        return option.text;
                    }

                    var $avatar =
                        "<div class='d-flex flex-wrap align-items-center'>" +
                        "<div class='avatar avatar-sm my-0 me-50'>" +
                        "<span class='avatar-content'>" +
                        "<img src='" +
                        assetPath +
                        "images/avatars/" +
                        $(option.element).data("avatar") +
                        "' alt='avatar' />" +
                        "</span>" +
                        "</div>" +
                        option.text +
                        "</div>";

                    return $avatar;
                }
                eventGuests.wrap('<div class="position-relative"></div>').select2({
                    placeholder: "Select value",
                    dropdownParent: eventGuests.parent(),
                    closeOnSelect: false,
                    templateResult: renderGuestAvatar,
                    templateSelection: renderGuestAvatar,
                    escapeMarkup: function(es) {
                        return es;
                    },
                });
            }

            // Start date picker
            if (startDate.length) {
                var start = startDate.flatpickr({
                    enableTime: true,
                    altFormat: "Y-m-dTH:i:S",
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr("step", null);
                        }
                    },
                });
            }

            // End date picker
            if (endDate.length) {
                var end = endDate.flatpickr({
                    enableTime: true,
                    altFormat: "Y-m-dTH:i:S",
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            $(instance.mobileInput).attr("step", null);
                        }
                    },
                });
            }

            // Event click function
            function eventClick(info) {
                if ("{{ auth()->user()->can('reminder.update') }}" === "1" ||
                    "{{ auth()->user()->can('reminder.delete') }}" === "1") {
                    eventToUpdate = info.event;
                    if (eventToUpdate.url) {
                        info.jsEvent.preventDefault();
                        //window.open(eventToUpdate.url, '_blank');
                    }

                    sidebar.modal("show");
                    addEventBtn.addClass("d-none");
                    cancelBtn.addClass("d-none");
                    updateEventBtn.removeClass("d-none");
                    btnDeleteEvent.removeClass("d-none");

                    eventTitle.val(eventToUpdate.title);
                    startDate.val(
                        new Date(eventToUpdate.extendedProps.date).toLocaleString()
                    );
                    status.val(eventToUpdate.extendedProps.status);
                    eventToUpdate.extendedProps.status === "1" ?
                        status.prop("checked", true) :
                        status.prop("checked", false);

                    // startDate.setDate(eventToUpdate.extendedProps.date, true, "Y-m-d");
                    // start.setDate(eventToUpdate.start, true, "Y-m-d");
                    eventToUpdate.allDay === true ?
                        allDaySwitch.prop("checked", true) :
                        allDaySwitch.prop("checked", false);
                    // eventToUpdate.end !== null
                    // ? end.setDate(eventToUpdate.end, true, "Y-m-d")
                    // : end.setDate(eventToUpdate.start, true, "Y-m-d");
                    sidebar
                        .find(eventLabel)
                        .val(eventToUpdate.extendedProps.calendar)
                        .trigger("change");
                    eventToUpdate.extendedProps.location !== undefined ?
                        eventLocation.val(eventToUpdate.extendedProps.location) :
                        null;
                    calendarEditor.val(eventToUpdate.extendedProps.detail);

                    if ("{{ auth()->user()->can('reminder.delete') }}" === "1") {
                        //  Delete Event
                        btnDeleteEvent.on("click", function() {
                            var eventData2 = {
                                id: eventToUpdate.id,
                            };
                            $.ajax({
                                url: route("reminder.delete"),
                                method: "POST",
                                data: eventData2,
                                success: (res) => {
                                    if (res.status === 201) {
                                        removeEvent(eventToUpdate.id);
                                        eventToUpdate.remove();
                                        sidebar.modal("hide");
                                        $(".event-sidebar").removeClass("show");
                                        $(".app-calendar .body-content-overlay").removeClass(
                                            "show"
                                        );
                                        Swal.fire(
                                            "Başarılı!",
                                            "Belirtilen tarihteki hatırlatıcı silindi.",
                                            "success"
                                        );
                                    } else {}
                                },
                            });
                        });
                    }
                } else {
                    toastr["error"](
                        "Hatırlatıcı güncelleme veya silme yetkiniz bulunmamakta",
                        "Hata!", {
                            closeButton: true,
                            tapToDismiss: true,
                            timeOut: 2000,
                            progressBar: true
                        }
                    );
                }
            }

            // Modify sidebar toggler
            function modifyToggler() {
                $(".fc-sidebarToggle-button")
                    .empty()
                    .append(feather.icons["menu"].toSvg({
                        class: "ficon"
                    }));
            }

            // Selected Checkboxes
            function selectedCalendars() {
                var selected = [];
                $(".calendar-events-filter input:checked").each(function() {
                    selected.push($(this).attr("data-value"));
                });
                return selected;
            }

            // --------------------------------------------------------------------------------------------------
            // AXIOS: fetchEvents
            // * This will be called by fullCalendar to fetch events. Also this can be used to refetch events.
            // --------------------------------------------------------------------------------------------------
            function fetchEvents(info, successCallback) {
                // Fetch Events from API endpoint reference
                /* $.ajax(
                   {
                     url: '../../../app-assets/data/app-calendar-events.js',
                     type: 'GET',
                     success: function (result) {
                       // Get requested calendars as Array
                       var calendars = selectedCalendars();

                       return [result.events.filter(event => calendars.includes(event.extendedProps.calendar))];
                     },
                     error: function (error) {
                       console.log(error);
                     }
                   }
                 ); */

                var calendars = selectedCalendars();
                // We are reading event object from app-calendar-events.js file directly by including that file above app-calendar file.
                // You should make an API call, look into above commented API call for reference
                selectedEvents = events.filter(function(event) {
                    // console.log(event.extendedProps.calendar.toLowerCase());
                    return calendars.includes(
                        event.extendedProps.calendar.toLowerCase()
                    );
                });
                // if (selectedEvents.length > 0) {
                successCallback(selectedEvents);
                // }
            }

            // Calendar plugins
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: "dayGridMonth",
                events: fetchEvents,
                editable: true,
                dragScroll: true,
                locale: "tr",
                dayMaxEvents: 2,
                buttonText: {
                    today: "Bugün",
                    month: "Ay",
                    week: "Hafta",
                    day: "Gün",
                    list: "Liste",
                },
                moreLinkContent: function(args) {
                    return "+" + args.num + " Daha Fazla";
                },
                eventResizableFromStart: true,
                customButtons: {
                    sidebarToggle: {
                        text: "Sidebar",
                    },
                },
                headerToolbar: {
                    start: "sidebarToggle, prev,next, title",
                    end: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
                },
                direction: direction,
                initialDate: new Date(),
                navLinks: true, // can click day/week names to navigate views
                eventClassNames: function({
                    event: calendarEvent
                }) {
                    const colorName =
                        calendarsColor[calendarEvent._def.extendedProps.calendar];

                    return [
                        // Background Color
                        "bg-light-" + colorName,
                    ];
                },
                dateClick: function(info) {
                    if ("{{ auth()->user()->can('reminder.add') }}" === "1") {
                        var date = moment(info.date).format("YYYY-MM-DD");
                        resetValues();
                        sidebar.modal("show");
                        addEventBtn.removeClass("d-none");
                        updateEventBtn.addClass("d-none");
                        btnDeleteEvent.addClass("d-none");
                        startDate.val(date);
                    } else {
                        toastr["error"](
                            "Hatırlatıcı ekleme yetkiniz bulunmamakta",
                            "Hata!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 2000,
                                progressBar: true
                            }
                        );
                    }

                },
                eventClick: function(info) {
                    eventClick(info);
                },
                datesSet: function() {
                    modifyToggler();
                },
                viewDidMount: function() {
                    modifyToggler();
                },
            });

            // Render calendar
            calendar.render();
            // Modify sidebar toggler
            modifyToggler();
            // updateEventClass();

            // Validate add new and update form
            if (eventForm.length) {
                eventForm.validate({
                    submitHandler: function(form, event) {
                        event.preventDefault();
                        if (eventForm.valid()) {
                            sidebar.modal("hide");
                        }
                    },
                    title: {
                        required: true,
                    },
                    rules: {
                        "start-date": {
                            required: true
                        },
                        "end-date": {
                            required: true
                        },
                    },
                    messages: {
                        "start-date": {
                            required: "Başlangıç tarihi gerekli"
                        },
                        "end-date": {
                            required: "Bitiş tarihi gerekli"
                        },
                    },
                });
            }

            // Sidebar Toggle Btn
            if (toggleSidebarBtn.length) {
                toggleSidebarBtn.on("click", function() {
                    cancelBtn.removeClass("d-none");
                });
            }

            // ------------------------------------------------
            // addEvent
            // ------------------------------------------------
            function addEvent(eventData) {
                calendar.addEvent(eventData);
                calendar.refetchEvents();
            }

            // ------------------------------------------------
            // updateEvent
            // ------------------------------------------------
            function updateEvent(eventData) {
                var propsToUpdate = ["id", "title"];
                var extendedPropsToUpdate = ["detail"];

                updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            }

            // ------------------------------------------------
            // removeEvent
            // ------------------------------------------------
            function removeEvent(eventId) {
                removeEventInCalendar(eventId);
            }

            // ------------------------------------------------
            // (UI) updateEventInCalendar
            // ------------------------------------------------
            const updateEventInCalendar = (
                updatedEventData,
                propsToUpdate,
                extendedPropsToUpdate
            ) => {
                const existingEvent = calendar.getEventById(updatedEventData.id);

                // --- Set event properties except date related ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setProp
                // dateRelatedProps => ['start', 'end', 'allDay']
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < propsToUpdate.length; index++) {
                    var propName = propsToUpdate[index];
                    existingEvent.setProp(propName, updatedEventData[propName]);
                }

                // --- Set date related props ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setDates
                existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
                    allDay: updatedEventData.allDay,
                });

                // --- Set event's extendedProps ----- //
                // ? Docs: https://fullcalendar.io/docs/Event-setExtendedProp
                // eslint-disable-next-line no-plusplus
                for (var index = 0; index < extendedPropsToUpdate.length; index++) {
                    var propName = extendedPropsToUpdate[index];
                    existingEvent.setExtendedProp(
                        propName,
                        updatedEventData.extendedProps[propName]
                    );
                }
            };

            // ------------------------------------------------
            // (UI) removeEventInCalendar
            // ------------------------------------------------
            function removeEventInCalendar(eventId) {
                calendar.getEventById(eventId).remove();
            }

            // Add new event
            $(addEventBtn).on("click", function() {
                if (eventForm.valid()) {
                    var newEvent = {
                        id: calendar.getEvents().length + 1,
                        title: eventTitle.val(),
                        start: startDate.val(),
                        end: endDate.val(),
                        startStr: startDate.val(),
                        endStr: endDate.val(),
                        display: "block",
                        extendedProps: {
                            location: eventLocation.val(),
                            guests: eventGuests.val(),
                            calendar: eventLabel.val(),
                            detail: calendarEditor.val(),
                        },
                    };
                    if (allDaySwitch.prop("checked")) {
                        newEvent.allDay = true;
                    }
                    $.ajax({
                        url: route("reminder.store"),
                        method: "POST",
                        data: $(".event-form").serialize(),
                        success: (res) => {
                            if (res.year == 1) {
                                Swal.fire(
                                    "Başarılı!",
                                    "1 yıl boyunca her ayın o gününe hatırlatıcı eklendi ( Sayfa yenilenmek zorunda lütfen bekle).",
                                    "success"
                                );
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            }
                            if (res.status === 201) {
                                newEvent.id = res.id;
                                addEvent(newEvent);
                                Swal.fire(
                                    "Başarılı!",
                                    "Belirtilen tarihe hatırlatıcı eklendi.",
                                    "success"
                                );
                            } else {
                                Swal.fire(
                                    "Eklenemedi!",
                                    "Hatırlatıcı eklenmesinde sorun oluştu yazılım destek ekibi ile iletişime geçin.",
                                    "error"
                                );
                            }
                        },
                    });
                }
            });

            // Update new event
            updateEventBtn.on("click", function() {
                if (eventForm.valid()) {
                    var eventData = {
                        id: eventToUpdate.id,
                        title: sidebar.find(eventTitle).val(),
                        start: sidebar.find(startDate).val(),
                        end: sidebar.find(endDate).val(),
                        status: sidebar.find(status).val(),
                        extendedProps: {
                            location: eventLocation.val(),
                            guests: eventGuests.val(),
                            calendar: eventLabel.val(),
                            detail: calendarEditor.val(),
                        },
                        display: "block",
                        allDay: allDaySwitch.prop("checked") ? true : false,
                    };
                    var eventData2 = {
                        id: eventToUpdate.id,
                        title: sidebar.find(eventTitle).val(),
                        status: sidebar.find(status).val(),
                        start_date: sidebar.find(startDate).val(),
                        end_date: sidebar.find(endDate).val(),
                        detail: calendarEditor.val(),
                    };
                    $.ajax({
                        url: route("reminder.update"),
                        method: "POST",
                        data: eventData2,
                        success: (res) => {
                            if (res.status === 201) {
                                updateEvent(eventData);
                                sidebar.modal("hide");
                                Swal.fire(
                                    "Başarılı!",
                                    "Belirtilen tarihteki hatırlatıcı güncellendi.",
                                    "success"
                                );
                            } else {
                                Swal.fire(
                                    "Güncellenemedi!",
                                    "Hatırlatıcı güncellemesinde sorun oluştu yazılım destek ekibi ile iletişime geçin.",
                                    "error"
                                );
                            }
                        },
                    });
                }
            });

            // Reset sidebar input values
            function resetValues() {
                endDate.val("");
                eventUrl.val("");
                startDate.val("");
                eventTitle.val("");
                eventLocation.val("");
                status.val("1");
                status.prop("checked", true);
                allDaySwitch.prop("checked", false);
                eventGuests.val("").trigger("change");
                calendarEditor.val("");
            }

            // When modal hides reset input values
            sidebar.on("hidden.bs.modal", function() {
                resetValues();
            });

            // Hide left sidebar if the right sidebar is open
            $(".btn-toggle-sidebar").on("click", function() {
                btnDeleteEvent.addClass("d-none");
                updateEventBtn.addClass("d-none");
                addEventBtn.removeClass("d-none");
                $(".app-calendar-sidebar, .body-content-overlay").removeClass("show");
            });

            // Select all & filter functionality
            if (selectAll.length) {
                selectAll.on("change", function() {
                    var $this = $(this);

                    if ($this.prop("checked")) {
                        calEventFilter.find("input").prop("checked", true);
                    } else {
                        calEventFilter.find("input").prop("checked", false);
                    }
                    calendar.refetchEvents();
                });
            }

            if (filterInput.length) {
                filterInput.on("change", function() {
                    $(".input-filter:checked").length <
                        calEventFilter.find("input").length ?
                        selectAll.prop("checked", false) :
                        selectAll.prop("checked", true);
                    calendar.refetchEvents();
                });
            }
        });
    </script>
@endsection
