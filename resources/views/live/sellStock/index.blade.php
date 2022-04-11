@extends('layouts/contentLayoutMaster')

@section('title', 'Stok')

@section('vendor-style')
  <!-- Vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')) }}">

@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-pickadate.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-number-input.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/swiper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-swiper.css')) }}">

    <style>
        .e-cards{
            min-height:380px;
        }
        .e-cols{
            padding:0 10px;
        }
    </style>

@endsection

@section('content')

  <div class="bs-stepper-content pt-2">
      <div class="row">
        <div class="col-9">
            <div class="row">
        @foreach ($stocks as $key => $value )
                <div class="col-xl-3 col-sm-4 col-md-3 e-cols">
                    <div class="card ecommerce-card e-cards productCard{{$value->id}}">
                        <div class="item-img text-center">
                            <div class="swiper-navigations swiper-container  " style="min-height: 100px">
                                <div class="swiper-wrapper" >
                                    @if (count($value->productFileData)>0)
                                        @foreach ($value->productFileData as $file )
                                                <div class="swiper-slide">
                                                    <img class="img-fluid pt-1"  style="max-height: 95px" src="{{asset('images/product/'.$file->file_name)}}" alt="banner" />
                                                </div>
                                        @endforeach
                                    @else
                                        <div class="swiper-slide">
                                            <img class="img-fluid  pt-1" style="max-height: 95px" src="{{asset('images/banner/banner-14.jpg')}}" alt="banner" />
                                        </div>
                                    @endif
                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                              </div>
                        </div>
                        <div class="card-body">
                            <h6 class="item-name text-center">
                                    {{$value->name}}
                            </h6>
                        </div>
                        <div class="item-options text-center pb-2">
                            <div class="item-wrapper">
                                <span class="card-text item-company row justify-content-center"  style="">
                                    <div class="input-group  input-group-lg " style="">
                                        <input type="number"  class="touchspin adet touchspin{{$value->id}}"  min="0" max="{{$value->amount}}" value="1" />

                                    </div>
                                </span>
                                <div class="item-cost col-8 offset-2">
                                    <div class="input-group input-group-merge mb-1 mt-1">
                                        <input type="number" class="form-control " name="price" value="{{$value->list_price}}">
                                        <span class="input-group-text">₺</span>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text item-description">
                               Stok Adeti : <span class="stok" pro_id="{{$value->id}}"> {{$value->amount}} </span>
                              </p>
                            <button id="{{$value->id}}" list_price="{{$value->list_price}}" name="{{$value->name}}" class="btn btn-primary btn-cart clickSub">
                                <i data-feather="shopping-cart"></i>
                                <span class="add-to-cart">Ekle</span>
                            </button>
                        </div>
                    </div>
                </div>
        @endforeach
        </div>
    </div>

          <div class="col-3 p-0">
            <div class="checkout-options">
                <div class="card">
                  <div class="card-body p-1">
                      <form id="satisYap">

                        <label class="section-label form-label mb-1">Satış Faturası</label>
                            <div class="col-md-12 mb-1 text-center">
                                <label class="form-label" for="select2-basic">Müşteri Seçin</label>
                                <select class="select2 form-select" name="costumer">
                                @foreach ($customer as $value )
                                    <option value="{{$value->id}}"> {{$value->name}} </option>
                                @endforeach
                                </select>
                            </div>
                        <div class="price-details">
                        <h6 class="price-title text-center">Ürün List</h6>
                        <hr  />
                        <table class="w-100 text-center">
                            <thead>
                                <th>Adı</th>
                                <th>Adet</th>
                                <th>T.Fiyat</th>
                                <th>Sil</th>
                            </thead>
                            <tbody id="sellstock">

                            </tbody>
                        </table>
                        <hr />
                        <ul class="list-unstyled">
                            <li class="price-detail">
                            <div class="detail-title detail-total">Toplam</div>
                            <div class="detail-amt fw-bolder">0₺</div>
                            </li>
                        </ul>
                        <button type="submit" class="btn btn-primary w-100 btn-next place-order">Sat</button>
                        </div>

                    </form>
                  </div>
                </div>
                <!-- Checkout Place Order Right ends -->
              </div>
          </div>

  </div>
</div>
@endsection

@section('vendor-script')

  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/extensions/ext-component-swiper.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/extensions/swiper.min.js')) }}"></script>

@endsection

@section('page-script')
  <script src="{{ asset(mix('js/scripts/pages/app-ecommerce-checkout.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/forms/form-number-input.js'))}}"></script>

  <script>
$(function() {
                let ip_address = '127.0.0.1';
                let socket_port = '9699';
                let socket = io(ip_address + ':' + socket_port);

                $("#satisYap").on('submit', function(e){
                    e.preventDefault();

                    axios.post(route("sellstock.store"),new FormData(this)).then((res)=>{

                        if (res.data.stockLimit.length) {
                            let message=" ";
                            let id = [];
                            let companyId = {{auth()->user()->company_id}};
                            res.data.stockLimit.map((value,key)=>{
                                message += "-> "+value["c_name"]+" bayisinde "+value["name"]+" ürününden "+value["amount"]+" adet kaldı.\n";
                                id.push({id:value["id"],adet:value["amount"]});
                            })

                            socket.emit('sendToStockServer',message,id,companyId);
                        }
                    });
                })
    });

    $(".clickSub").on('click', function(e){
        let stok = parseInt($(this).closest(".card").find(".stok").html());
        let adet = parseInt($(this).closest(".card").find(".adet").val());
        if(adet==0){
            alert("Ürün Adedi 0'dan büyük olmalı");
            return;
        }
        if (stok<adet) {
            alert("Yetersiz Stok");
            return;
        }
        let kalanStok =stok-adet;
        $(this).closest(".card").find(".stok").html(kalanStok);

        productidNow=$(this).attr("id");
        productPriceNow=parseInt($(this).closest(".card").find("input[name='price']").val());
        productNumberControl=$('#sellstock tr[productID='+productidNow+']').length;
        if(productNumberControl>0){
            productNumber=parseInt($('#sellstock tr[productID='+productidNow+']').find(".productNumber").text());
            newProductNumber=(productNumber+adet);
            newProductPrice=(productPriceNow*newProductNumber);
            $('#sellstock tr[productID='+productidNow+']').find(".productNumber").text(newProductNumber);
            $('#sellstock tr[productID='+productidNow+']').find(".productPrice").text(newProductPrice);
            let test = {
                adet:newProductNumber,
                id:productidNow,
                price:newProductPrice
            };
            let value = JSON.stringify(test);
            productClass=".productList"+productidNow;
            $(productClass).val(value);
        } else {

            const tableRow = `
                <tr productId="${$(this).attr("id")}">
                    <td class="productName">
                        ${$(this).attr("name")}
                    </td>
                    <td class="productNumber">
                        ${adet}
                    </td>
                    <td class="productPrice">
                        ${parseInt($(this).closest(".card").find("input[name='price']").val())*adet}
                    </td>
                    <td class="productAction">
                        <button class="btn bg-transparent p-0" onclick="productDelete(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash font-small-4 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </td>
                </tr>
            `;
            let test = {
                adet:adet,
                id:$(this).attr("id"),
                price:parseInt($(this).closest(".card").find("input[name='price']").val())
            };
            let value = JSON.stringify(test);
            $("#sellstock").closest("form").append($(`<input type="hidden" name='product[]' class="productList${$(this).attr("id")}" value='${value}'/>`))
            $("#sellstock").append(tableRow);
        }
        productPriceSum();
    })

    function productPriceSum(ths){
        priceTotal=0;
        $('#sellstock tr').each(function(a,b){
            productPrice=parseInt($(b).find(".productPrice").text());
            priceTotal+=productPrice;
        })
        $(".detail-amt").html(priceTotal+"₺");
    }

    function productDelete(ths){
        productid=$(ths).closest("tr").attr("productid");
        productClass=".productList"+productid;
        productValue=$(productClass).val();
        const productValueObj = JSON.parse(productValue);
        productNumber=productValueObj.adet;
        productListClass=".productCard"+productid;
        productListStockNumber=parseInt($(productListClass).find(".stok").text());
        newProductNumberSum=(productNumber+productListStockNumber);
        $(productListClass).find(".stok").text(newProductNumberSum);
        $(ths).closest("tr").remove();
        $(productClass).remove();
        productPriceSum();
    }

 </script>

@endsection
