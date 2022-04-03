@extends('layouts/contentLayoutMaster')

@section('title', 'Limit Güncelle')

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
                    <h4 class="card-title">Limit Bilgileri</h4>
                </div>
                <div class="card-body">
                    <form class="form" onsubmit="submitHandler(event)">
                        <input type="hidden" name="id" value="{{ $stockLimit->id }}">
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="company">Firma</label>
                                    <select class="form-select" id="company" name="company_id">
                                        @if (count($Company) > 0)
                                            <option value="-1" disabled>Firma seçiniz</option>
                                            @foreach ($Company as $firm)
                                                @if ($firm->id == $stockLimit->company_id)
                                                    <option selected value="{{ $firm->id }}">{{ $firm->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $firm->id }}">{{ $firm->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="-1" disabled selected>Firma ekleyiniz</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="product">Ürün</label>
                                    <select class="form-select" id="product" name="product_id">
                                        @if (count($products) > 0)
                                            <option value="-1" disabled>Ürün seçiniz</option>
                                            @foreach ($products as $product)
                                                @if ($product->id == $stockLimit->product_id)
                                                    <option selected value="{{ $product->id }}">{{ $product->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="-1" disabled selected>Ürün ekleyiniz</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="limit">Limit</label>
                                    <input type="number" id="limit" class="form-control" placeholder="Limit"
                                        autocomplete="off" name="limit" value="{{ $stockLimit->limit }}" />
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

            const id = $('input[name="id"]').val();

            $.ajax({
                method: "POST",
                url: route("stockLimit.update", id),
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
