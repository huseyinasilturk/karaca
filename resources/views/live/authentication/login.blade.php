@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="#" class="brand-logo">
                        <i class="fa-solid fa-cake-candles" style="padding: 4px; font-size: 20px;"></i>
                        <h2 class="brand-text text-primary">Karaca</h2>
                    </a>

                    <h4 class="card-title mb-1">KARACA YÖNETİM PANELİ</h4>
                    <p class="card-text mb-2">Size atanan kullanıcı adı ve şifre ile giriş yapabilirsiniz</p>

                    <form class="auth-login-form mt-2" onsubmit="submitHandler(event)">
                        <div class="mb-1">
                            <label for="login-username" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="login-username" name="user_name"
                                placeholder="admin" aria-describedby="login-username" tabindex="1" autofocus />
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Şifre</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="login-password"
                                    name="password" tabindex="2"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="login-password" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" tabindex="4" type="submit">Giriş Yap</button>
                    </form>
                </div>
            </div>
            <!-- /Login basic -->
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/pages/auth-login.js')) }}"></script>
    <script>
        function submitHandler(e) {
            e.preventDefault();

            const formData = $(e.target).serialize();

            $.ajax({
                method: "POST",
                url: "{{ route('auth.loginUser') }}",
                dataType: "json",
                data: formData,
                success: res => {
                    if (res.status === 200) {
                        console.log(res.message);
                        toastr["success"](
                            res.message,
                            "Giriş başarılı!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 1500,
                                progressBar: true
                            }
                        );
                        setTimeout(() => {
                            window.location.href = "/";
                        }, 1550);
                    }
                },
                error: err => {
                    if (err.responseJSON.errors !== undefined) {
                        console.log()
                        Object.values(err.responseJSON.errors).map((errMessage) => {
                            toastr["error"](
                                errMessage,
                                "Hata!", {
                                    closeButton: true,
                                    tapToDismiss: true,
                                    timeOut: 3000,
                                    progressBar: true
                                }
                            );
                        })
                    } else {
                        toastr["error"](
                            err.responseJSON.error,
                            "Hata!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 3000,
                                progressBar: true
                            }
                        );
                    }


                }
            });
        }
    </script>
@endsection
