@extends('layouts/contentLayoutMaster')

@section('title', 'Müşteri Güncelle')

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
                    <h4 class="card-title">Müşteri Bilgileri</h4>
                </div>
                <div class="card-body">
                    <form class="form" onsubmit="submitHandler(event)">
                        <input type="hidden" name="id" value="{{ $customer->id }}" />
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="customer-name">Müşteri Adı</label>
                                    <input type="text" id="customer-name" class="form-control" placeholder="Müşteri Adı"
                                        autocomplete="off" name="name" value="{{ $customer->name }}" />
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="customer-type">Müşteri Tipi</label>
                                    <select class="form-select" id="customer-type" name="customer_type_id">
                                        @if (count($customerTypes) > 0)
                                            <option value="-1" disabled>Müşteri tipi seçiniz</option>
                                            @foreach ($customerTypes as $customerType)
                                                @if ($customerType->id == $customer->type->id)
                                                    <option value="{{ $customerType->id }}" selected>
                                                        {{ $customerType->text1 }}
                                                    </option>
                                                @else
                                                    <option value="{{ $customerType->id }}">{{ $customerType->text1 }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="-1" disabled>Müşteri tipi ekleyiniz</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-success px-3">Güncelle</button>
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

            const id = $("input[name='id']").val()

            $.ajax({
                method: "POST",
                url: route("customer.update", id),
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 200) {
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
