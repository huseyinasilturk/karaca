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
      <th scope="col">Ürün Adı</th>
      <th scope="col">Ürün Tipi</th>
      <th scope="col">Liste Fiyatı</th>
      <th scope="col">İşlemler</th>
    </tr>
  </thead>
  <tbody>
      {{ dd($Product) }}
    <tr>
      <td>Pasta</td>
      <td>Tatlı</td>
      <td>12.50</td>
      <td>
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            İşlemler
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            {{-- <li><a class="dropdown-item" href="?s=urun&a=detay&id=id"><i class="fa-solid fa-circle-info me-1"></i>Detay</a></li> --}}
            <li><a class="dropdown-item" href="?s=urun&a=duzenle&id=id"><i class="fa-solid fa-pen-to-square me-1"></i></i>Düzenle</a></li>
            <li><a class="dropdown-item" href="?s=urun&a=listele&idx=id"><i class="fa-solid fa-trash-can me-1"></i>Sil</a></li>
          </ul>
        </div>
      </td>
    </tr>
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
@endsection

@section('page-script')

@endsection
