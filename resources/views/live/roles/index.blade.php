@extends('layouts/contentLayoutMaster')

@section('title', 'Roles')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
@endsection

@section('content')
    <h3>Roller</h3>
    <!-- Role cards -->
    <div class="row" id="roles">
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6 role-card" data-role-id="{{ $role->id }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Toplam {{ $role->users->count() }} kullanıcı</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{ $role->title }}</h4>
                                <button class="role-edit-modal btn bg-transparent text-primary p-0"
                                    onclick="editRoleHandler(this)">
                                    <small class="fw-bolder">Rolü Düzenle</small>
                                </button>
                            </div>
                            <button class="text-body bg-transparent p-0 btn" onclick="deleteRoleHandler(this)">
                                <i data-feather="trash" class="font-medium-5 text-danger"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-xl-4 col-lg-6 col-md-6" id="insert-role-card">
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

    </div>
    <!--/ Role cards -->

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
                            <div class="row justify-content-start align-items-center">
                                @foreach ($permissions as $permission)
                                    <div class="col-sm-12 col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="{{ $permission->name }}" />
                                            <label class="form-check-label"
                                                for="{{ $permission->name }}">{{ Str::title($permission->title) }}</label>
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

    <!-- Add Role Modal -->
    <div class="modal fade" id="updateRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 pb-5">
                    <div class="text-center mb-4">
                        <h1 class="role-title">Rol Güncelle</h1>
                        <p>Rol izinlerini ayarla</p>
                    </div>
                    <!-- Add role form -->
                    <form id="updateRoleForm" class="row" onsubmit="updateRoleFormHandler(event)"
                        data-role-id="-1">
                        <div class="col-12">
                            <label class="form-label" for="updateModalRoleName">Rol Adı</label>
                            <input type="text" id="updateModalRoleName" name="role_name" class="form-control"
                                placeholder="Rol adını giriniz" tabindex="-1" data-msg="Lütfen rol adını giriniz" />
                        </div>
                        <div class="col-12">
                            <h4 class="mt-2 pt-50 mb-1">Yetkiler</h4>
                            <div class="row justify-content-start align-items-center" id="updateRolePermissions">
                                @foreach ($permissions as $permission)
                                    <div class="col-sm-12 col-md-3 mb-2 update-role-permission">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]"
                                                value="{{ $permission->name }}" id="{{ $permission->id }}" />
                                            <label class="form-check-label"
                                                for="{{ $permission->id }}">{{ $permission->title }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-1">Güncelle</button>
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

@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
@endsection
@section('page-script')
    <script>
        // Rol ekle
        function newRoleFormHandler(e) {
            e.preventDefault();

            console.log($(e.target).serialize())

            $.ajax({
                method: "POST",
                url: "{{ route('roles.store') }}",
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 201) {
                        console.log(res)
                        const newRoleEl = `
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span>Toplam 0 kullanıcı</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                                        <div class="role-heading">
                                            <h4 class="fw-bolder">${res.role.title}</h4>
                                            <a href="javascript:;" class="role-edit-modal" data-bs-toggle="modal"
                                                data-bs-target="#addRoleModal">
                                                <small class="fw-bolder">Rolü Düzenle</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        $(newRoleEl).insertBefore("#insert-role-card");
                    }
                },
                error: (err) => {
                    console.log(err.responseJSON.message)
                }
            })
        }

        // Rol bilgilerini getir
        function editRoleHandler(el) {
            const roleId = $(el).closest(".role-card").attr("data-role-id");

            $("#updateRoleForm").attr("data-role-id", roleId);

            let url = "{{ route('roles.detail', ':id') }}";
            url = url.replace(":id", roleId);

            $.ajax({
                method: "GET",
                url: url,
                success: (res, textStatus, xhr) => {
                    const rolePermissions = res.permissions.map((permission) => permission.name);

                    $("#updateRoleModal").find(".role-title").text(`${res.title} Güncelle`);
                    $("#updateModalRoleName").val(res.title);

                    $(".update-role-permission").each((key, el) => {
                        const inputEl = $(el).find("input");
                        if (rolePermissions.includes(inputEl.val())) {
                            inputEl.prop("checked", true)
                        } else {
                            inputEl.prop("checked", false)
                        }
                    })

                    $('#updateRoleModal').modal('toggle');
                }
            })
        }

        // Rol güncelle
        function updateRoleFormHandler(e) {
            e.preventDefault();

            const roleId = $(e.target).attr("data-role-id")

            let url = "{{ route('roles.update', ':id') }}";
            url = url.replace(":id", roleId);

            $.ajax({
                method: "POST",
                url: url,
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 200) {
                        $("#roles").find(`.role-card[data-role-id='${roleId}']`).find("h4").text($(
                            "#updateModalRoleName").val());

                        toastr["success"](
                            res.message,
                            "Başarılı!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 2000,
                                progressBar: true
                            }
                        );
                    }
                },
                error: (err) => {
                    toastr["error"](
                        err.responseJSON.message,
                        "Hata!", {
                            closeButton: true,
                            tapToDismiss: true,
                            timeOut: 3000,
                            progressBar: true
                        }
                    );
                }
            })
        }

        // Rolü sil
        function deleteRoleHandler(el) {
            const roleId = $(el).closest(".role-card").attr("data-role-id");

            let url = "{{ route('roles.update', ':id') }}";
            url = url.replace(":id", roleId);

            Swal.fire({
                title: "Silmek istediğinize emin misiniz ?",
                text: "Bu işlem geri alınamaz !",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Evet, sil !",
                cancelButtonText: "İptal et !",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-outline-secondary ms-1",
                },
                buttonsStyling: false,
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        success: (res, textStatus, xhr) => {
                            $(el).closest(".role-card").remove();

                            Swal.fire({
                                icon: "success",
                                title: "Başarılı!",
                                text: res.message,
                                customClass: {
                                    confirmButton: "btn btn-success",
                                },
                            });
                        },
                        error: err => {
                            toastr["error"](
                                err.responseJSON.message,
                                "Hata!", {
                                    closeButton: true,
                                    tapToDismiss: true,
                                    timeOut: 3000,
                                    progressBar: true
                                }
                            );
                        }
                    })
                }
            });


        }
    </script>
@endsection
