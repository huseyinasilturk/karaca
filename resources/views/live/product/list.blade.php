@extends('layouts/contentLayoutMaster')

@section('title', 'Ürün Listeleme')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('page-style')

@endsection

@section('content')

<table class="table">
  <thead>
    <tr>
        <th scope="col">ÜRÜN ADI</th>
        <th scope="col">ÜRÜN TİPİ</th>
        @foreach ($Company as $firm)
            <th scope="col">{{ mb_strtoupper($firm->name, "UTF-8") }} LİSTE FİYATI</th>
        @endforeach
        <th scope="col">İŞLEMLER</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($Product as $pro)
        <tr>
            <td>{{ $pro->name }}</td>
            <td>{{ isset($pro->productTypeGet->text1) ? $pro->productTypeGet->text1 : '' }}</td>
            @foreach ($pro->productCompanyGet as $productPrice)
                <td>{{ $productPrice->list_price }}</td>
            @endforeach
            <td>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        İşlemler
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="{{ route('product.edit',$pro->id) }}"><i class="fa-solid fa-pen-to-square me-1"></i></i>Düzenle</a></li>
                        <li><a class="dropdown-item" href="#" onclick="productDelete(this)" dataID="{{ $pro->id }}"><i class="fa-solid fa-trash-can me-1"></i>Sil</a></li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>

<section id="column-search-datatable">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header border-bottom">
            <h4 class="card-title">Column Search</h4>
          </div>
          <div class="card-datatable">
            <table class="dt-column-search table table-responsive">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Post</th>
                  <th>City</th>
                  <th>Date</th>
                  <th>Salary</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Post</th>
                  <th>City</th>
                  <th>Date</th>
                  <th>Salary</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
</section>
  <!--/ Column Search -->

@endsection

@section('vendor-script')
    <script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
    <script src="{{asset('js/scripts/tables/table-datatables-advanced.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
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
   function productDelete(ths){
       Swal.fire({
           title: 'Silmek istediğinden emin misin?',
           text: "Ürün kalıcı olarak silinir!",
           icon: 'question',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           cancelButtonText: 'Vazgeç',
           confirmButtonText: 'Evet sil.'
       }).then((result) => {
           if (result.isConfirmed) {
               dataID=$(ths).attr("dataID");
               $.ajax({
                   url: route('product.delete',dataID),
                   method: "delete",
                   success: (res) => {
                       if (res.status === 202) {
                           $(ths).closest("tr").remove();
                           Swal.fire(
                               'Silindi!',
                               'Ürün başarıyla silindi.',
                               'success'
                           )
                       } else {
                           Swal.fire(
                               'Silinemedi!',
                               'Ürün silinmesinde bir sorun oluştu yazılımcı ile iletişime geçin',
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
