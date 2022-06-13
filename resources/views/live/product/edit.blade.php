@extends('layouts/contentLayoutMaster')

@section('title', 'Ürün Güncelleme')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/pages/app-ecommerce-details.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('page-style')

@endsection

@section('content')
    {{-- {{ dd($Product->productType) }} --}}
    <form action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="productName">Ürün Adı</label>
                    <input id="productName" class="form-control" name="name" type="text" placeholder="Ürün Adını Giriniz"
                        autocomplete="off" value="{{ $Product->name }}" required />
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="productTypeID">Ürün Tipi</label>
                    <select class="select2 form-select" id="productTypeID" name="type_id" required>
                        <option value="0">Seçiniz</option>
                        @foreach ($ProductTypeObjectives as $probj)
                            <option value="{{ $probj->id }}"
                                @if ($probj->id == $Product->type_id) {{ 'selected' }} @endif>{{ $probj->text1 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @foreach ($Company as $firm)
                <div class="col-md-6 col-12">
                    <div class="mb-1">
                        <label class="col-form-label" for="productListPrice{{ $firm->id }}">{{ $firm->name }} Liste
                            Fiyatı</label>
                        <input id="productListPrice{{ $firm->id }}" class="form-control"
                            name="listPrice[{{ $firm->id }}]" type="number" placeholder="Liste Fiyatını Giriniz"
                            min="0" step=".01" autocomplete="off"
                            value="{{ isset($Product->productCompanyGetAll[$firm->id]->list_price) ? $Product->productCompanyGetAll[$firm->id]->list_price : 0 }}"
                            required />
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 col-12">
                <div class="mb-1">
                    <label class="form-label" for="files">Ürün Görselleri</label>
                    <input id="files" class="form-control" name="files[]" type="file" multiple />
                </div>
            </div>

            <div class="col-12 mt-50">
                <input type="hidden" name="id" value="{{ $Product->id }}">
                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Kaydet</button>
                <button type="reset" class="btn btn-outline-secondary waves-effect">Sıfırla</button>
            </div>
            <div class="card-body">
                <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
                    <div class="swiper-wrapper">
                        @foreach ($Product->productFileData as $probj)
                            <div class="swiper-slide">
                                <a href="#">
                                    <div class="img-container w-50 mx-auto py-75">
                                        <img src="{{ asset('images/product/' . $probj->file_name) }}" class="img-fluid"
                                            alt="image" />
                                    </div>
                                    <div class="item-meta text-center">
                                        <span class="btn btn-danger btn-sm p-0" onclick="productImageDelete(this)"
                                            dataID="1"><i class="fa-solid fa-trash p-1"></i></span>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('js/scripts/pages/app-ecommerce-details.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

        function productImageDelete(ths) {
            Swal.fire({
                title: 'Silmek istediğinden emin misin?',
                text: "Resim kalıcı olarak silinir!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Vazgeç',
                confirmButtonText: 'Evet sil.'
            }).then((result) => {
                if (result.isConfirmed) {
                    dataID = $(ths).attr("dataID");
                    $.ajax({
                        url: "{{ route('product.imageDestroy') }}",
                        method: "POST",
                        data: {
                            'id': dataID
                        },
                        success: (res) => {
                            if (res.status === 202) {
                                $(ths).closest(".swiper-slide").remove();
                                Swal.fire(
                                    'Silindi!',
                                    'Resim başarıyla silindi.',
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Silinemedi!',
                                    'Resim silinmesinde bir sorun oluştu yazılımcı ile iletişime geçin',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        }
    </script>
@endsection
