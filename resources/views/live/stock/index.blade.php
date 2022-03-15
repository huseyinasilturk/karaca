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
                <!-- Price Filter starts -->
                <div class="multi-range-price">
                    <h6 class="filter-title mt-0">Fiyat Aralığı</h6>
                    <ul class="list-unstyled price-range" id="price-range">
                        <li>
                            <div class="form-check">
                                <input type="radio" id="priceAll" name="price-range" class="form-check-input" checked />
                                <label class="form-check-label" for="priceAll">All</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input type="radio" id="priceRange1" name="price-range" class="form-check-input" />
                                <label class="form-check-label" for="priceRange1">&lt;=$10</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input type="radio" id="priceRange2" name="price-range" class="form-check-input" />
                                <label class="form-check-label" for="priceRange2">$10 - $100</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input type="radio" id="priceARange3" name="price-range" class="form-check-input" />
                                <label class="form-check-label" for="priceARange3">$100 - $500</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check">
                                <input type="radio" id="priceRange4" name="price-range" class="form-check-input" />
                                <label class="form-check-label" for="priceRange4">&gt;= $500</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Price Filter ends -->

                <!-- Categories Starts -->
                <div id="product-categories">
                    <h6 class="filter-title">Ürün Kategorileri</h6>
                    <ul class="list-unstyled categories-list">
                        @foreach ($productCategories as $productCategory)
                            <li>
                                <div class="form-check">
                                    <input type="radio" id="category-{{ $productCategory->id }}" name="category-filter"
                                        class="form-check-input" />
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
                    <button type="button" class="btn w-100 btn-primary">Tüm Filtreleri Temizle</button>
                </div>
                <!-- Clear Filters Ends -->
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
        @foreach ($products as $product)
            <div class="card ecommerce-card">
                <div class="item-img text-center">
                    <a href="{{ url('app/ecommerce/details') }}">
                        <img class="img-fluid card-img-top"
                            src="{{ asset('images/product/' . $product->productFileData[0]->file_name) }}"
                            alt="img-placeholder" /></a>
                </div>
                <div class="card-body">
                    <div class="item-wrapper justify-content-end">
                        <h6 class="item-price">
                            {{ !empty($product->list_price) ? $product->list_price : 'Fiyatı belirtilmedi' }}
                        </h6>
                    </div>
                    <h6 class="item-name">
                        <a class="text-body" href="{{ url('app/ecommerce/details') }}">{{ $product->name }}</a>
                    </h6>
                </div>
                <div class="item-options text-center">
                    <div class="item-wrapper justify-content-end">
                        <div class="item-cost">
                            <h4 class="item-price">
                                {{ !empty($product->list_price) ? $product->list_price : 'Fiyatı belirtilmedi' }}
                            </h4>
                        </div>
                    </div>
                    <button data-bs-toggle="modal" data-bs-target="#stockModal" class="btn btn-primary btn-cart">
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
                <form>
                    <div class="modal-body">
                        <label>Ürün Miktarı</label>
                        <div class="mb-1">
                            <input type="number" placeholder="Ürün Miktarı" autocomplete="off" class="form-control" />
                        </div>

                        <label>Alış Fiyatı</label>
                        <div class="mb-1">
                            <input type="number" placeholder="Alış Fiyatı" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Login</button>
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
    <script src="{{ asset(mix('js/scripts/pages/app-ecommerce.js')) }}"></script>
@endsection
