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

@endsection

@section('content')

<section>
    <div class="app-calendar overflow-hidden border">
        <div class="row g-0">
        <!-- Sidebar -->
        <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
            <div class="sidebar-wrapper">
                <div class="card-body d-flex justify-content-center">
                    <button
                    class="btn btn-primary btn-toggle-sidebar w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#add-new-sidebar"
                    >
                    <span class="align-middle">Hatırlatıcı Ekle</span>
                    </button>
                </div>
            </div>
            <div class="mt-auto">
            <img
                src="{{asset('images/pages/calendar-illustration.png')}}"
                alt="Calendar illustration"
                class="img-fluid"
            />
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
                    <input type="text" class="form-control" id="title" name="title" placeholder="Başlık" required />
                </div>
                <div class="mb-1 position-relative">
                    <label for="start-date" class="form-label">Başlangıç Tarihi</label>
                    <input type="text" class="form-control" id="start-date" name="start_date" placeholder="Başlangıç Tarihi" />
                </div>
                <div class="mb-1 position-relative">
                    <label for="end-date" class="form-label">Bitiş Tarihi</label>
                    <input type="text" class="form-control" id="end-date" name="end_date" placeholder="Bitiş Tarihi" />
                </div>
                <div class="mb-1">
                    <label class="form-label">Açıklama</label>
                    <textarea name="detail" id="event-description-editor" class="form-control"></textarea>
                </div>
                <div class="mb-1 d-flex">
                    <button type="submit" class="btn btn-primary add-event-btn me-1">Ekle</button>
                    <button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-primary update-event-btn d-none me-1">Güncelle</button>
                    <button class="btn btn-outline-danger btn-delete-event d-none">Sil</button>
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
    <script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/app-calendar-reminder-events.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/pages/app-calendar-reminder.js')) }}"></script>
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
    </script>
@endsection
