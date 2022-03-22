@extends('layouts/contentLayoutMaster')

@section('title', 'İzin Ekle')

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
                    <h4 class="card-title"></h4>
                </div>
                <div class="card-body">
                    <form class="form" onsubmit="submitHandler(event)">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="personal">Personel</label>
                                    <select class="form-select" id="personal" name="personal_id">
                                        <option value="-1">Personel seçiniz</option>
                                        @if (count($personals) > 0)
                                            @foreach ($personals as $personal)
                                                <option value="{{ $personal->id }}">
                                                    {{ $personal->information->name . ' ' . $personal->information->surname }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="start-date">İzin Başlangıç Tarihi</label>
                                    <input type="date" id="start-date" class="form-control" name="start_date" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="end-date">İzin Bitiş Tarihi</label>
                                    <input type="date" id="end-date" class="form-control" name="end_date" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="detail">İzin Detayı</label>
                                    <input type="text" id="detail" class="form-control" name="detail" />
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
                url: "{{ route('dayoff.store') }}",
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
                    const errors = err.responseJSON.errors
                    Object.values(errors).map((error) => {
                        toastr["error"](
                            error,
                            "Hata!", {
                                closeButton: true,
                                tapToDismiss: true,
                                timeOut: 5000,
                                progressBar: true
                            }
                        );
                    })

                }
            })

        }
    </script>
@endsection
