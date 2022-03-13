@extends('layouts/contentLayoutMaster')

@section('title', 'Ürün Listeleme')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
@endsection

@section('page-style')

@endsection

@section('content')

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
