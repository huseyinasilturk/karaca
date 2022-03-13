@extends('layouts/contentLayoutMaster')

@section('title', 'Ürün Ekleme')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection

@section('page-style')

@endsection

@section('content')
    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="productName">Ürün Adı</label>
                    <input id="productName" class="form-control" name="name" type="text" placeholder="Ürün Adını Giriniz" autocomplete="off" required/>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="productListPrice">Liste Fiyatı</label>
                    <input id="productListPrice" class="form-control" name="list_price" type="number" placeholder="Liste Fiyatını Giriniz" min="0" step=".01" autocomplete="off" required/>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="productTypeID">Ürün Tipi</label>
                    <select class="select2 form-select" id="productTypeID" name="type_id" required>
                        <option value="0">Seçiniz</option>
                        @foreach ($ProductObjectives as $probj)
                            <option value="{{ $probj->id }}">{{ $probj->text1 }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-1">
                    <label class="form-label" for="files">Ürün Görselleri</label>
                    <input id="files" class="form-control" name="files[]" type="file" multiple/>
                </div>
            </div>
            <div class="col-12 mt-50">
                <button type="submit" class="btn btn-primary me-1 waves-effect waves-float waves-light">Kaydet</button>
                <button type="reset" class="btn btn-outline-secondary waves-effect">Sıfırla</button>
            </div>
        </div>
    </form>

@endsection

@section('vendor-script')
    <script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('js/scripts/forms/form-select2.js')}}"></script>
@endsection

@section('page-script')

@endsection
