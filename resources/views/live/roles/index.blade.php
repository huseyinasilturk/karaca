@extends('layouts/contentLayoutMaster')

@section('title', 'Roles')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <h3>Roller</h3>
    <!-- Role cards -->
    <div class="row">
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Toplam {{ $role->users->count() }} kullanıcı</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{ Str::title($role->name) }}</h4>
                                <a href="javascript:;" class="role-edit-modal" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                    <small class="fw-bolder">Rolü Düzenle</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end justify-content-center h-100">
                            <img src="{{ asset('images/illustration/faq-illustrations.svg') }}" class="img-fluid mt-2"
                                alt="Image" width="85" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="javascript:void(0)" data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="stretched-link text-nowrap add-new-role">
                                <span class="btn btn-primary mb-1">Yeni Rol Ekle</span>
                            </a>
                            <p class="mb-0">Eğer rol yoksa, rolü ekle</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                <div class="modal-content">
                    <div class="modal-header bg-transparent">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-5 pb-5">
                        <div class="text-center mb-4">
                            <h1 class="role-title">Yeni Rol Ekle</h1>
                            <p>Rol izinlerini ayarla</p>
                        </div>
                        <!-- Add role form -->
                        <form id="addRoleForm" class="row" onsubmit="newRoleFormHandler(event)">
                            <div class="col-12">
                                <label class="form-label" for="modalRoleName">Rol Adı</label>
                                <input type="text" id="modalRoleName" name="role_name" class="form-control"
                                    placeholder="Rol adını giriniz" tabindex="-1" data-msg="Lütfen rol adını giriniz" />
                            </div>
                            <div class="col-12">
                                <h4 class="mt-2 pt-50 mb-1">Yetkiler</h4>
                                <div class="row justify-content-between align-items-center">
                                    @foreach ($permissions as $permission)
                                        <div class="col-sm-12 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value={{ $permission->id }} id="{{ $permission->name }}" />
                                                <label class="form-check-label"
                                                    for="{{ $permission->name }}">{{ Str::title($permission->name) }}</label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="col-12 text-center mt-2">
                                <button type="submit" class="btn btn-primary me-1">Ekle</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    İptal Et
                                </button>
                            </div>
                        </form>
                        <!--/ Add role form -->
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add Role Modal -->

    </div>
    <!--/ Role cards -->

    {{-- @include('content/_partials/_modals/modal-add-role') --}}
@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
    <script>
        function newRoleFormHandler(e) {
            e.preventDefault();

            console.log($(e.target).serialize())
        }
    </script>
@endsection
