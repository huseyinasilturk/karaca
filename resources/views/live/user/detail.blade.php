@extends('layouts/contentLayoutMaster')

@section('title', 'User View - Account')

@section('vendor-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
<section class="app-user-view-account">
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <div class="user-info text-center">
                                <h4>{{$user->name_surname}}</h4>
                                <span class="badge bg-light-secondary">{{$user->role_title}}</span>
                            </div>
                        </div>
                    </div>
                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Detaylar</h4>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Username:</span>
                                <span>{{$user->user_name}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Billing Email:</span>
                                <span>{{$user->email}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Role:</span>
                                <span>{{$user->role_title}}</span>
                            </li>
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Yaş:</span>
                                @php
                                $date = \Carbon\Carbon::now()->diff( \Carbon\Carbon::parse($user->birthday)->format('Y')
                                );

                                @endphp
                                <span>{{$date->y}}</span>
                            </li>
                            @if ($user->role_name == "owner")
                            <li class="mb-75">
                                <span class="fw-bolder me-25">Maaş:</span>
                                <span>{{$user->wage_price}}</span>
                            </li>
                            @endif

                        </ul>
                        <div class="d-flex justify-content-center pt-2">
                            <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser"
                                data-bs-toggle="modal">
                                Edit
                            </a>
                            {{-- href="{{route("user.delete",$user->id)}}" --}}
                            <a class="btn btn-outline-danger suspend-user">Personeli Sil</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Card -->
            <!-- Plan Card -->
            <div class="card">

            </div>
            <!-- /Plan Card -->
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-2">
                                <li class="nav-item">
                                    <a class="nav-link active" id="homeIcon-tab" data-bs-toggle="tab" href="#homeIcon"
                                        aria-controls="home" role="tab" aria-selected="true">
                                        <i data-feather="user" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Account</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="change-password-tab" data-bs-toggle="tab"
                                        href="#change-password" aria-controls="profile" role="tab"
                                        aria-selected="false">
                                        <i data-feather="lock" class="font-medium-3 me-50"></i>
                                        <span class="fw-bold">Security</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="aboutIcon-tab" data-bs-toggle="tab" href="#aboutIcon"
                                        aria-controls="about" role="tab" aria-selected="false">
                                        <i data-feather="bell" class="font-medium-3 me-50"></i><span
                                            class="fw-bold">Notifications</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab"
                                    role="tabpanel">
                                    <p>
                                        Candy canes donut chupa chups candy canes lemon drops oat cake wafer. Cotton
                                        candy candy canes marzipan
                                        carrot cake. Sesame snaps lemon drops candy marzipan donut brownie tootsie roll.
                                        Icing croissant bonbon
                                        biscuit gummi bears. Pudding candy canes sugar plum cookie chocolate cake powder
                                        croissant.
                                    </p>
                                    <p>
                                        Carrot cake tiramisu danish candy cake muffin croissant tart dessert. Tiramisu
                                        caramels candy canes
                                        chocolate cake sweet roll liquorice icing cupcake. Candy cookie sweet roll bear
                                        claw sweet roll.
                                    </p>
                                </div>
                                <div class="tab-pane" id="change-password" aria-labelledby="change-password-tab"
                                    role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <form id="formChangePassword" method="POST" onsubmit="return false">
                                                <div class="alert alert-warning mb-2" role="alert"
                                                    style="margin-top: -31px ">
                                                    <h6 class="alert-heading">Lütfen dikkat edin.</h6>
                                                    <div class="alert-body fw-normal">Minimum 8 karakter. Harf,şekil ve
                                                        rakamlardan oluşan.</div>
                                                    <div class="alert-body fw-normal">ŞİFRELER DAHA GÜVENLİDİR</div>
                                                </div>

                                                <div class="row">
                                                    <div class="mb-2 col-md-6 form-password-toggle">
                                                        <label class="form-label" for="newPassword">New Password</label>
                                                        <div class="input-group input-group-merge form-password-toggle">
                                                            <input class="form-control" type="password" id="newPassword"
                                                                name="newPassword"
                                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                            <span class="input-group-text cursor-pointer">
                                                                <i data-feather="eye"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-2 col-md-6 form-password-toggle">
                                                        <label class="form-label" for="confirmPassword">Confirm New
                                                            Password</label>
                                                        <div class="input-group input-group-merge">
                                                            <input class="form-control" type="password"
                                                                name="confirmPassword" id="confirmPassword"
                                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                            <span class="input-group-text cursor-pointer"><i
                                                                    data-feather="eye"></i></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary me-2">Change
                                                            Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="aboutIcon" aria-labelledby="aboutIcon-tab" role="tabpanel">
                                    <p>
                                        Gingerbread cake cheesecake lollipop topping bonbon chocolate sesame snaps.
                                        Dessert macaroon bonbon
                                        carrot cake biscuit. Lollipop lemon drops cake gingerbread liquorice. Sweet
                                        gummies dragée. Donut bear
                                        claw pie halvah oat cake cotton candy sweet roll. Cotton candy sweet roll donut
                                        ice cream.
                                    </p>
                                    <p>
                                        Halvah bonbon topping halvah ice cream cake candy. Wafer gummi bears chocolate
                                        cake topping powder.
                                        Sweet marzipan cheesecake jelly-o powder wafer lemon drops lollipop cotton
                                        candy.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Content -->
    </div>
</section>

@include('content/_partials/_modals/modal-edit-user')
@include('content/_partials/_modals/modal-upgrade-plan')
@endsection

@section('vendor-script')
{{-- Vendor js files --}}
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
{{-- data table --}}
<script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
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
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>
@endsection

@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/pages/modal-edit-user.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-user-view-account.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/pages/app-user-view.js')) }}"></script>
@endsection
