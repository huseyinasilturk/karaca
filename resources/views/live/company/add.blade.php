@extends('layouts/contentLayoutMaster')

@section('title', 'Firma Ekle')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Firma Bilgileri</h4>
                </div>
                <div class="card-body">
                    <form class="form" onsubmit="submitHandler(event)">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-name">Firma Adı</label>
                                    <input type="text" id="company-name" class="form-control" placeholder="Firma Adı"
                                        autocomplete="off" name="name" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-phone">Telefon Numarası</label>
                                    <input type="text" id="company-phone" class="form-control" autocomplete="off"
                                        placeholder="Telefon Numarası" name="phone" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-address">Firma Adresi</label>
                                    <input type="text" id="company-address" class="form-control" autocomplete="off"
                                        placeholder="Firma Adresi" name="address" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-note">Firma Notu</label>
                                    <input type="text" id="company-note" class="form-control" placeholder="Firma Notu"
                                        autocomplete="off" name="note" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company-type">Firma Tipi</label>
                                    <select class="form-select" id="company-type" name="company_type">
                                        <option value="-1">Firma tipi seçiniz</option>
                                        @foreach ($companyTypes as $companyType)
                                            <option value="{{ $companyType->id }}">{{ $companyType->text1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success px-3">Ekle</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('page-script')
    <script>
        function submitHandler(e) {
            e.preventDefault();

            $.ajax({
                method: "POST",
                url: "{{ route('company.store') }}",
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 201) {
                        toastr["success"](
                            res.message,
                            "Başarılı!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 2000,
                                progressBar: true
                            }
                        );

                        $(e.target).trigger("reset");
                    }
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
    </script>
@endsection
