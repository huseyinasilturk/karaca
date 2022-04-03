@extends('layouts/detachedLayoutMaster')

@section('title', 'Stok')

@section('vendor-style')
    <!-- Vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/nouislider.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sliders.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
    <style>

    </style>
@endsection

@section('content-sidebar')
    <!-- Ecommerce Sidebar Starts -->
    <div class="sidebar-shop">
        <div class="row">
            <div class="col-sm-12">
                <h6 class="filter-heading d-none d-lg-block">Filtreler</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form onsubmit="filterHandler(event)">
                    <!-- Price Filter starts -->
                    <div class="multi-range-price">
                        <h6 class="filter-title mt-0">Fiyat Aralığı</h6>
                        <div class="mb-1">
                            <input type="number" placeholder="Minimum Fiyat" name="min_price" autocomplete="off"
                                class="form-control" />
                        </div>
                        <div class="mb-1">
                            <input type="number" placeholder="Maksimum Fiyat" name="max_price" autocomplete="off"
                                class="form-control" />
                        </div>
                    </div>
                    <!-- Price Filter ends -->

                    <!-- Categories Starts -->
                    <div id="product-categories">
                        <h6 class="filter-title">Ürün Kategorileri</h6>
                        <ul class="list-unstyled categories-list">
                            @foreach ($productCategories as $productCategory)
                                <li>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                            id="category-{{ $productCategory->id }}" name="categories[]"
                                            value="{{ $productCategory->id }}" />
                                        <label class="form-check-label"
                                            for="category-{{ $productCategory->id }}">{{ $productCategory->text1 }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Categories Ends -->

                    <!-- Clear Filters Starts -->
                    <div id="clear-filters">
                        <button type="submit" class="btn w-100 btn-primary mb-1">Filtrele</button>
                        <button type="button" class="btn w-100 btn-primary">Tüm Filtreleri Temizle</button>
                    </div>
                    <!-- Clear Filters Ends -->
                </form>
            </div>
        </div>
    </div>
    <!-- Ecommerce Sidebar Ends -->

@endsection

@section('content')
    <!-- E-commerce Content Section Starts -->
    <section id="ecommerce-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="ecommerce-header-items">
                    <div class="result-toggler">
                        <button class="navbar-toggler shop-sidebar-toggler" type="button" data-bs-toggle="collapse">
                            <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
                        </button>
                    </div>
                    <div class="view-options d-flex">
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="radio_options" id="radio_option1"
                                autocomplete="off" checked />
                            <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn" for="radio_option1"><i
                                    data-feather="grid" class="font-medium-3"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- E-commerce Content Section Starts -->

    <!-- background Overlay when sidebar is shown  starts-->
    <div class="body-content-overlay"></div>
    <!-- background Overlay when sidebar is shown  ends-->

    <!-- E-commerce Search Bar Starts -->
    <section id="ecommerce-searchbar" class="ecommerce-searchbar">
        <div class="row mt-1">
            <div class="col-sm-12">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control search-product" id="shop-search" placeholder="Ürün Ara"
                        aria-label="Search..." aria-describedby="shop-search" />
                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                </div>
            </div>
        </div>
    </section>
    <!-- E-commerce Search Bar Ends -->

    <!-- E-commerce Products Starts -->
    <section id="ecommerce-products" class="grid-view">
        @if (count($products) == 0)
            <div class="card col-12">
                <div class="card-body">
                    <p>Önce ürün eklemelisiniz</p>
                    <p class="mb-0">
                        <a href="{{ route('product.create') }}" class="text-primary"
                            style="font-weight: bold">Buradan</a>
                        gidebilirsiniz
                    </p>
                </div>
            </div>
        @endif
        @foreach ($products as $product)
            <div class="card ecommerce-card">
                <div class="item-img text-center">
                    <a href="{{ route('product.edit', $product->id) }}">
                        @if (count($product->productFileData) > 0)
                            <img class="img-fluid card-img-top"
                                src="{{ asset('images/product/' . $product->productFileData[0]->file_name) }}"
                                alt="img-placeholder" />
                        @else
                            <img class="img-fluid card-img-top" src="http://via.placeholder.com/600x350"
                                alt="img-placeholder" />
                        @endif

                    </a>
                </div>
                <div class="card-body">
                    <div class="item-wrapper justify-content-end">
                        <h6 class="item-price">
                            {{ $product->productCompanyGet[0]->list_price }} ₺
                        </h6>
                    </div>
                    <h6 class="item-name">
                        <a class="text-body"
                            href="{{ route('product.edit', $product->id) }}">{{ $product->name }}</a>
                    </h6>
                </div>
                <div class="item-options text-center">
                    <div class="item-wrapper justify-content-end">
                        <div class="item-cost">
                            <h4 class="item-price">
                                {{ $product->productCompanyGet[0]->list_price }} ₺
                            </h4>
                        </div>
                    </div>
                    <button data-bs-toggle="modal" data-bs-target="#stockModal"
                        data-stock="{{ !empty($product->productStock) ? $product->productStock->amount : '0' }}"
                        data-product="{{ $product->id }}" onclick="modalDataHandler(this)"
                        class="btn btn-primary btn-cart">
                        <i data-feather="layers"></i>
                        <span class="add-to-cart">Stoğa Ekle</span>
                    </button>
                </div>
            </div>
        @endforeach
    </section>
    <!-- E-commerce Products Ends -->

    <!-- Modal Starts -->
    <div class="modal fade text-start" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="stockModalLabel">Stoğa Ürün Ekle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form onsubmit="stockFormHandler(event)">
                    <input type="hidden" name="product_id" value="-1" />
                    <div class="modal-body">
                        <label style="margin-bottom: 5px">Ürün Miktarı</label>
                        <div class="mb-1">
                            <input type="number" placeholder="Ürün Miktarı" oninput="onAmountChange(this)" name="amount"
                                autocomplete="off" class="form-control" />
                        </div>

                        <label style="margin-bottom: 5px">Alış Fiyatı</label>
                        <div class="mb-1">
                            <input type="text" placeholder="Alış Fiyatı" name="purchase_price" autocomplete="off"
                                oninput="onPriceChange(this)" class="form-control" />
                        </div>

                        <label style="margin-bottom: 5px">Birim Tipi</label>
                        <div class="mb-1">
                            <select class="form-select {{ !count($unitTypes) > 0 ? 'border-warning' : '' }}"
                                name="unit_type">
                                @if (count($unitTypes) > 0)
                                    <option value="-1" disabled>Birim tipi seçiniz</option>
                                    @foreach ($unitTypes as $unitType)
                                        <option value="{{ $unitType->id }}">{{ $unitType->text1 }}</option>
                                    @endforeach
                                @else
                                    <option value="-1" disabled selected>Birim Tipi eklemeniz gerekli
                                    </option>
                                @endif
                            </select>
                        </div>
                        <label style="margin-bottom: 5px">Firma</label>
                        <div class="mb-1">
                            <select class="form-select {{ !count($companies) > 0 ? 'border-warning' : '' }}"
                                name="company_id">
                                @if (count($companies) > 0)
                                    <option value="-1" disabled>Firma seçiniz</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                @else
                                    <option value="-1" disabled selected>Firma eklemeniz gerekli</option>
                                @endif
                            </select>
                        </div>
                        <p class="stock-amount">Bu üründen stokta <span style="font-weight: bold">7</span> adet bulunmakta
                        </p>
                        <p class="text-muted" id="total-buy-price">Toplam Alış Fiyatı: <span>0</span> ₺</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->
@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    <script src="{{ asset(mix('vendors/js/extensions/wNumb.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/nouislider.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script>
        $(function() {
            // RTL Support
            var direction = "ltr",
                isRTL = false;
            if ($("html").data("textdirection") == "rtl") {
                direction = "rtl";
            }

            if (direction === "rtl") {
                isRTL = true;
            }

            var sidebarToggler = $(".shop-sidebar-toggler"),
                sidebarShop = $(".sidebar-shop"),
                overlay = $(".body-content-overlay"),
                sidebarCart = $(".sidebar-shop").find(".card");

            // Show sidebar
            if (sidebarToggler.length) {
                sidebarToggler.on("click", function() {
                    sidebarShop.toggleClass("show");
                    overlay.toggleClass("show");
                    sidebarCart.toggleClass("full-height");
                    $("body").addClass("modal-open");
                });
            }

            // Overlay Click
            if (overlay.length) {
                overlay.on("click", function(e) {
                    sidebarShop.removeClass("show");
                    overlay.removeClass("show");
                    sidebarCart.removeClass("full-height");
                    sidebarShop.css("min-height", "100vh");
                    $("body").removeClass("modal-open");
                });
            }
        });

        // on window resize hide sidebar
        $(window).on("resize", function() {
            if ($(window).outerWidth() >= 991) {
                $(".sidebar-shop").removeClass("show");
                $(".body-content-overlay").removeClass("show");
            }
        });

        function modalDataHandler(el) {
            const productId = $(el).attr("data-product");
            const stockAmount = $(el).attr("data-stock");

            $("input[name='product_id']").val(productId);
            $(".stock-amount").find("span").text(stockAmount);
        }

        function stockFormHandler(e) {
            e.preventDefault();

            $.ajax({
                method: "POST",
                url: "{{ route('stock.store') }}",
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

                        console.log($(e.target).find(".stock-amount").find("span").text())
                    }
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
                    }

                    $(e.target).trigger("reset");
                },
                error: (err) => {
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

        function onAmountChange(el) {
            const price = $("input[name='price']").val();
            const amount = $(el).val();
            if (price !== undefined && amount !== undefined) {
                $("#total-buy-price").find("span").text((Math.round(price * amount * 100) / 100).toFixed(2))
            }
        }

        function onPriceChange(el) {
            const amount = $("input[name='amount']").val();
            const price = $(el).val();
            if (price !== undefined && amount !== undefined) {
                $("#total-buy-price").find("span").text((Math.round(price * amount * 100) / 100).toFixed(2))
            }
        }

        function filterHandler(e) {
            e.preventDefault()

            $.ajax({
                method: "POST",
                url: "{{ route('stock.filterProducts') }}",
                data: $(e.target).serialize(),
                dataType: "json",
                success: (res, textStatus, xhr) => {
                    if (xhr.status === 200) {

                        const products = $("#ecommerce-products");

                        products.html("");

                        if (res.length > 0) {
                            res.forEach((product, key) => {
                                let imagePath = ''
                                if (product.product_file_data.length > 0) {
                                    imagePath = "{{ asset('images/product/:path') }}"
                                    imagePath = imagePath.replace(":path", product.product_file_data[0]
                                        .file_name)
                                } else {
                                    imagePath = 'http://via.placeholder.com/600x350'
                                }

                                let editUrl = "{{ route('product.edit', ':id') }}";
                                editUrl = editUrl.replace(":id", product.id)

                                const newProduct = `
                                <div class="card ecommerce-card">
                                    <div class="item-img text-center">
                                        <a href="${editUrl}">
                                            <img class="img-fluid card-img-top"
                                                src="${imagePath}"
                                                alt="img-placeholder" /></a>
                                    </div>
                                    <div class="card-body">
                                        <div class="item-wrapper justify-content-end">
                                            <h6 class="item-price">
                                                ${product.product_company_get[0].list_price} ₺
                                            </h6>
                                        </div>
                                        <h6 class="item-name">
                                            <a class="text-body" href="${editUrl}">${product.name}</a>
                                        </h6>
                                    </div>
                                    <div class="item-options text-center">
                                        <div class="item-wrapper justify-content-end">
                                            <div class="item-cost">
                                                <h4 class="item-price">
                                                    ${product.product_company_get[0].list_price} ₺
                                                </h4>
                                            </div>
                                        </div>
                                        <button data-bs-toggle="modal" data-bs-target="#stockModal" data-product="${product.id}"
                                            onclick="modalDataHandler(this)" class="btn btn-primary btn-cart">
                                            <i data-feather="layers"></i>
                                            <span class="add-to-cart">Stoğa Ekle</span>
                                        </button>
                                    </div>
                                </div>
                            `;
                                products.append(newProduct);
                            });

                            feather.replace()
                        } else {
                            const emptyFilter = `
                            <div class="card col-12">
                                <div class="card-body">
                                    <p>Kriterlere uygun ürün bulunamadı</p>
                                    <p class="mb-0">
                                        <a href="/product/add" class="text-primary" style="font-weight: bold">Buradan</a>
                                        ürün ekleyebilirsiniz
                                    </p>
                                </div>
                            </div>
                            `;
                            products.append(emptyFilter);
                        }
                    }
                },
                error: (err) => {
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
            });
        }
    </script>
@endsection
