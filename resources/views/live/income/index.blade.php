@extends('layouts/contentLayoutMaster')

@section('title', 'User List')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
@endsection

@section('content')
    <!-- users list start -->

    <section class="app-user-list">


        <!-- list and filter start -->
        <div class="card">
            <button type="button"
                data-bs-toggle= "modal"
                data-bs-target= "#modals-slide-in"
                class="btn btn-gradient-primary">
                Diğer Gelir Ekle
            </button>
            <div class="card-datatable table-responsive p-0">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>Detay</th>
                            <th>Ürün</th>
                            <th>B. Fiyat</th>
                            <th>Adet</th>
                            <th>T. Fiyat</th>
                            <th>Müşteri</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($income as  $value)
                        <tr>
                            <td>{{$value->detail}}</td>
                            <td>{{(!empty($value->name) ? $value->name : "---")}}</td>
                            <td>{{$value->price}}</td>
                            <td>{{$value->amount}}</td>
                            <td>{{$value->amount*$value->price}}</td>
                            <td>{{($value->costumer_id == -1 ? "---" : $value->costumer_id)}}"Henüz müşteri tablosu yok"</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <section class="app-user-list">


                <!-- list and filter start -->
                <div class="card">

                    <div class="modal modal-slide-in new-user-modal fade " id="modals-slide-in">
                        <div class="modal-dialog">
                            <form id="insertOrUpdate" class="add-new-user modal-content pt-0" action="{{ route('income.store') }}" method="POST">
                                @csrf
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                                <div class="modal-header mb-1">
                                    <h5 class="modal-title" id="exampleModalLabel">Diğer Gelir Ekle.</h5>
                                </div>
                                <div class="modal-body flex-grow-1">
                                    <div class="mb-1">
                                        <label class="form-label" for="basic-icon-default-fullname">Detay</label>
                                        <textarea type="text" class="form-control" name="detail"></textarea>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="fp-default">T. Fiyat</label>
                                        <input type="text" name="price" class="form-control flatpickr-basic" />
                                    </div>
                                    <div class="col-md-12 mb-1">
                                        <label class="form-label" for="select2-basic">Müşteri Seçin</label>
                                        <select class="select2 form-select" name="costumer">
                                        <option value="-1">Müşterisiz</option>
                                        <option value="1">Anonim</option>
                                        <option value="2">Müşteri 1</option>
                                        <option value="3">Müşteri 2</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 data-submit data-submit-btn insert-or-update">Ekle</button>
                                    <button type="reset" onclick="modalHide(this)" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">İptal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Modal to add new user Ends-->
                </div>
                <!-- list and filter end -->
            </section>
        </div>
@endsection

@section('vendor-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.date.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/picker.time.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/pickadate/legacy.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/polyfill.min.js')) }}"></script>

@endsection

@section('page-script')
        <script>


            $("#insertOrUpdate").submit((e)=>{
                e.preventDefault();
                axios.post(route("income.store"),new FormData(e.target)).then((res)=>{
                    console.log(res);
                });
            })


        </script>
@endsection
