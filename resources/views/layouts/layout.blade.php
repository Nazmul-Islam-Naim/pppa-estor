<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="Shah Ali Mazar">
        <meta name="author" content="ParkerThemes">
        <link rel="shortcut icon" href="{{asset('custom/img/fav.png')}}">

        <!-- Title -->
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Google Font -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;500&display=swap" rel="stylesheet">


        <!-- *************
            ************ Common Css Files *************
        ************ -->
        <!-- Bootstrap css -->
        {!!Html::style('custom/css/bootstrap.min.css')!!}
        
        <!-- Icomoon Font Icons css -->
        {!!Html::style('custom/fonts/style.css')!!}
        <!-- Main css for green -->
        {!!Html::style('custom/css/green-main.css')!!}


        <!-- *************
            ************ Vendor Css Files *************
        ************ -->

        <!-- Mega Menu -->
        {!!Html::style('custom/vendor/megamenu/css/megamenu.css')!!}

        <!-- Search Filter JS -->
        {!!Html::style('custom/vendor/search-filter/search-filter.css')!!}
        {!!Html::style('custom/vendor/search-filter/custom-search-filter.css')!!}

        <!-- Data Tables -->
        {!!Html::style('custom/vendor/datatables/dataTables.bs4.css')!!}
        {!!Html::style('custom/vendor/datatables/dataTables.bs4-custom.css')!!}
        {!!Html::style('custom/vendor/datatables/buttons.bs.css')!!}
        <!-- Date Range CSS -->
        {!!Html::style('custom/vendor/daterange/daterange.css')!!}

        <!-- Bootstrap Select CSS -->
        {!!Html::style('custom/vendor/bs-select/bs-select.css')!!}

        <style type="text/css">
            @keyframes zoominoutsinglefeatured {
                0% {
                    transform: scale(1,1);
                }
                50% {
                    transform: scale(1.2,1.2);
                }
                100% {
                    transform: scale(1,1);
                }
            }
            .logo img {
                animation: zoominoutsinglefeatured 1s infinite ;
            }

            /*.sidebar-wrapper .sidebar-tabs .nav{
                width: 100% !important;
            }*/

            .slimScrollBar {
                width: 15px !important;
            }

            .default-sidebar-wrapper .default-sidebar-menu ul li.active a span {
                /*background: #e02539;
                color: #ffffff;
                border-radius: 4px;
                padding: 9px;*/
                font-weight: bold;
            }

            .default-sidebar-wrapper .default-sidebar-menu ul li.active a.current-page {
                background: #17995e;
                pointer-events: auto;
                position: relative;
                color: #ffffff;
            }
            .default-sidebar-wrapper .default-sidebar-menu ul li.active a.current-page:hover {
                background: #17995e;
                /*pointer-events: none;*/
                position: relative;
                color: #ffffff;
            }
            table.dataTable tr.odd {
            	background: #f6f6fd;
            }
            table.dataTable tr.even {
            	background: #ffffff;
            }
            table.dataTable td {
                border: 0;
                padding: 0.5rem 0.75rem;
                white-space: normal;
            }
            div.dataTables_wrapper div.dataTables_info {
            	padding: 0.425em 1.5em;
            	display: inline-block;
            	font-size: .725rem;
            	background: #f6f6fd !important;
            	margin-top: 10px;
            	border-radius: 2px;
            }
            
            /* Pagination */
            .pagination .page-link {
                color: #7980a2;
                border: 1px solid #dee2e6;
                background: #fff;
            }
            .pagination .page-link:hover {
                background: #dee2e6;
            }
            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #4285f4;
                border-color: #4285f4;
            }
            .page-item.disabled .page-link {
                color: #7980a2;
                pointer-events: none;
                background-color: #fff;
                border-color: #dee2e6;
            }
        </style>
        
    </head>
    <?php
        $baseUrl = URL::to('/');
        $url = Request::path();
    ?>
    <body class="default-sidebar">

        <!-- Loading wrapper start -->
        <div id="loading-wrapper">
            <div class="spinner-border"></div>
        </div>
        <!-- Loading wrapper end -->

        <!-- Page wrapper start -->
        <div class="page-wrapper">
            
            <!-- Sidebar wrapper start -->
            <nav class="sidebar-wrapper">
                
                <!-- Default sidebar wrapper start -->
                <div class="default-sidebar-wrapper">

                    <!-- Sidebar brand starts -->
                    <div class="default-sidebar-brand">
                        <a href="{{URL::to('/home')}}" class="logo">
                            <!-- <img src="{{asset('custom/img/logo.svg')}}" alt="Admin" /> -->
                            <!-- <h5>E-Store</h5><br> -->
                            <h6>{{Auth::user()->name}}</h6>
                        </a>
                    </div>
                    <!-- Sidebar brand starts -->

                    <!-- Sidebar menu starts -->
                    <div class="defaultSidebarMenuScroll">
                        <div class="default-sidebar-menu">
                            <ul>
                                <!-------------- dashboard part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url=='home' || 
                                    $url==config('app.account').'/daily-transaction') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-home2"></i>
                                        <span class="menu-text">{{ __('menu.dashboard') }}</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/home'}}"  class="{{($url=='home') ? 'current-page':''}}">{{ __('menu.home') }}</a>
                                            </li>
                                            @can('app.accounttype.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/daily-transaction'}}"  class="{{($url==config('app.account').'/daily-transaction') ? 'current-page':''}}">{{ __('menu.Daily_Transaction') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @can('app.accounttype.index')
                                <!-------------- account part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.account').'/account-type' || $url==(request()->is(config('app.account').'/account-type/*/edit')) ||
                                    $url==config('app.account').'/bank-account' || 
                                    $url==config('app.account').'/cheque-book' || 
                                    $url==config('app.account').'/cheque-no' || 
                                    $url==(request()->is(config('app.account').'/bank-deposit/*')) || 
                                    $url==(request()->is(config('app.account').'/amount-withdraw/*')) || 
                                    $url==(request()->is(config('app.account').'/amount-transfer/*')) || 
                                    $url==(request()->is(config('app.account').'/bank-report/*'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-dollar-sign"></i>
                                        <span class="menu-text">{{ __('menu.account_management') }}</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.accounttype.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/account-type'}}" class="{{($url==config('app.account').'/account-type' || $url==(request()->is(config('app.account').'/account-type/*/edit'))) ? 'current-page':''}}">{{ __('menu.account_type') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.bankaccount.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/bank-account'}}" class="{{($url==config('app.account').'/bank-account' || $url==(request()->is(config('app.account').'/bank-deposit/*')) || $url==(request()->is(config('app.account').'/amount-withdraw/*')) || $url==(request()->is(config('app.account').'/amount-transfer/*')) || $url==(request()->is(config('app.account').'/bank-report/*'))) ? 'current-page':''}}">{{ __('menu.bank_account') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.chequebook.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/cheque-book'}}" class="{{($url==config('app.account').'/cheque-book') ? 'current-page':''}}">{{ __('menu.cheque_book') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.chequenumber.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.account').'/cheque-no'}}" class="{{($url==config('app.account').'/cheque-no') ? 'current-page':''}}">{{ __('menu.cheque_no') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.product.index')
                                <!-------------- product part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.product').'/product-type' || $url==config('app.product').'/product-type/create' || $url==(request()->is(config('app.product').'/product-type/*/edit')) ||
                                    $url==config('app.product').'/product-category' || $url==config('app.product').'/product-category/create' || $url==(request()->is(config('app.product').'/product-category/*/edit')) ||
                                    $url==config('app.product').'/product-sub-category' || $url==config('app.product').'/product-sub-category/create' || $url==(request()->is(config('app.product').'/product-sub-category/*/edit')) ||
                                    $url==config('app.product').'/product-unit' || $url==config('app.product').'/product-unit/create' || $url==(request()->is(config('app.product').'/product-unit/*/edit')) ||
                                    $url==config('app.product').'/product-brand' || $url==config('app.product').'/product-brand/create' || $url==(request()->is(config('app.product').'/product-brand/*/edit')) ||
                                    $url==config('app.product').'/product/create' || $url==(request()->is(config('app.product').'/product/*/edit'))||
                                    $url==config('app.product').'/product' ||
                                    $url==config('app.product').'/previous-stock-product' || $url==config('app.product').'/previous-stock-product/create' || $url==(request()->is(config('app.product').'/previous-stock-product/*/edit')) ||
                                    $url==config('app.product').'/previous-stock-report'||
                                    $url==config('app.product').'/stock-product' || $url==config('app.product').'/stock-product/create' || $url==(request()->is(config('app.product').'/stock-product/*/edit')) ||
                                    $url==config('app.product').'/date-wise-stock-report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-box"></i>
                                        <span class="menu-text">{{ __('menu.Product_Management') }}</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <!--<li>-->
                                            <!--    <a href="{{$baseUrl.'/'.config('app.product').'/product-type'}}" class="{{($url==config('app.product').'/product-type' || $url==config('app.product').'/product-type/create' || $url==(request()->is(config('app.product').'/product-type/*/edit'))) ? 'current-page':''}}">{{ __('menu.Product_Type') }}</a>-->
                                            <!--</li>-->
                                            @can('app.productcategory.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product-category'}}" class="{{($url==config('app.product').'/product-category' || $url==config('app.product').'/product-category/create' || $url==(request()->is(config('app.product').'/product-category/*/edit'))) ? 'current-page':''}}">Product Category</a>
                                            </li>
                                            @endcan
                                            @can('app.productsubcategory.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product-sub-category'}}" class="{{($url==config('app.product').'/product-sub-category' || $url==config('app.product').'/product-sub-category/create' || $url==(request()->is(config('app.product').'/product-sub-category/*/edit'))) ? 'current-page':''}}">Product Sub Category</a>
                                            </li>
                                            @endcan
                                            @can('app.productunit.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product-unit'}}" class="{{($url==config('app.product').'/product-unit' || $url==config('app.product').'/product-unit/create' || $url==(request()->is(config('app.product').'/product-unit/*/edit'))) ? 'current-page':''}}">{{ __('menu.Product_Unit') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.productbrand.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product-brand'}}" class="{{($url==config('app.product').'/product-brand' || $url==config('app.product').'/product-brand/create' || $url==(request()->is(config('app.product').'/product-brand/*/edit'))) ? 'current-page':''}}">{{ __('menu.Product_Brand') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.product.create')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product/create'}}" class="{{($url==config('app.product').'/product/create' || $url==(request()->is(config('app.product').'/product/*/edit'))) ? 'current-page':''}}">{{ __('menu.Product') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.product.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/product'}}" class="{{($url==config('app.product').'/product') ? 'current-page':''}}">{{ __('menu.Product') }} List</a>
                                            </li>
                                            @endcan
                                            @can('app.previousstock.create')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/previous-stock-product'}}" class="{{($url==config('app.product').'/previous-stock-product' || $url==config('app.product').'/previous-stock-product/create' || $url==(request()->is(config('app.product').'/previous-stock-product/*/edit'))) ? 'current-page':''}}">Add Previous Stock</a>
                                            </li>
                                            @endcan
                                            @can('app.previousstock.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/previous-stock-report'}}" class="{{($url==config('app.product').'/previous-stock-report') ? 'current-page':''}}">Previous Stock Report</a>
                                            </li>
                                            @endcan
                                            @can('app.stock.report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/stock-product'}}" class="{{($url==config('app.product').'/stock-product' || $url==config('app.product').'/stock-product/create' || $url==(request()->is(config('app.product').'/stock-product/*/edit'))) ? 'current-page':''}}">{{ __('menu.Stock_Product') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.datewisestock.report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.product').'/date-wise-stock-report'}}" class="{{($url==config('app.product').'/date-wise-stock-report') ? 'current-page':''}}">Date Wise Stock Report</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.supplier.index')
                                <!-------------- supplier part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.supplier').'/product-supplier' || $url==config('app.supplier').'/product-supplier/create' || $url==(request()->is(config('app.supplier').'/product-supplier/*/edit')) ||
                                    $url==config('app.supplier').'/supplier-due-report' || 
                                    $url==config('app.supplier').'/supplier-payment-list' ||
                                    $url==config('app.supplier').'/supplier-payment-report' ||
                                    $url==config('app.supplier').'/supplier-payment-amendment') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-truck"></i>
                                        <span class="menu-text">Supplier Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.supplier.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.supplier').'/product-supplier'}}" class="{{($url==config('app.supplier').'/product-supplier' || $url==config('app.supplier').'/product-supplier/create' || $url==(request()->is(config('app.supplier').'/product-supplier/*/edit'))) ? 'current-page':''}}">{{ __('menu.Supplier') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.supplierreport.paymentlist')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-payment-list'}}" class="{{($url==config('app.supplier').'/supplier-payment-list') ? 'current-page':''}}">Supplier Payment List</a>
                                            </li>
                                            @endcan
                                            @can('app.supplierreport.duereport')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-due-report'}}" class="{{($url==config('app.supplier').'/supplier-due-report') ? 'current-page':''}}">Supplier Due Report</a>
                                            </li>
                                            @endcan
                                            @can('app.supplierreport.paymentreport')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-payment-report'}}" class="{{($url==config('app.supplier').'/supplier-payment-report') ? 'current-page':''}}">{{ __('menu.Supplier_Payment_Report') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.supplierreport.paymentamendment')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-payment-amendment'}}" class="{{($url==config('app.supplier').'/supplier-payment-amendment') ? 'current-page':''}}">Supplier Payment Amendment</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.productpurchase.index')
                                <!-------------- purchase part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.purchase').'/product-purchase' || $url==config('app.purchase').'/product-purchase/create' || $url==(request()->is(config('app.purchase').'/product-purchase/*/edit')) ||
                                    $url==config('app.purchase').'/purchase-report' || $url==config('app.purchase').'/purchase-details/{tok}' ||
                                    $url==config('app.purchase').'/purchase-amendment') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-shopping-cart"></i>
                                        <span class="menu-text">{{ __('menu.Purchase_Management') }}</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.productpurchase.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/product-purchase'}}" class="{{($url==config('app.purchase').'/product-purchase' || $url==config('app.purchase').'/product-purchase/create' || $url==(request()->is(config('app.purchase').'/product-purchase/*/edit'))) ? 'current-page':''}}">{{ __('menu.Product_Purchase') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.productpurchase.report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-report'}}" class="{{($url==config('app.purchase').'/purchase-report' || $url==config('app.purchase').'/purchase-details/{tok}') ? 'current-page':''}}">{{ __('menu.Purchase_Report') }}</a>
                                            </li>
                                            @endcan
                                            @can('app.productpurchase.amendment')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.purchase').'/purchase-amendment'}}" class="{{($url==config('app.purchase').'/purchase-amendment') ? 'current-page':''}}">Purchase Amendment</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.requisition.index')
                                <!-------------- requisition part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.requisition').'/requisition/create' || $url==(request()->is(config('app.requisition').'/requisition/*/edit')) ||
                                    $url==config('app.requisition').'/requisition' ||
                                    $url==config('app.requisition').'/report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-send1"></i>
                                        <span class="menu-text">Requisition Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.requisition.create')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.requisition').'/requisition/create'}}" class="{{($url==config('app.requisition').'/requisition/create' || $url==(request()->is(config('app.requisition').'/requisition/*/edit'))) ? 'current-page':''}}">Send Requisition</a>
                                            </li>
                                            @endcan
                                            @can('app.requisition.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.requisition').'/requisition'}}" class="{{($url==config('app.requisition').'/requisition') ? 'current-page':''}}">Requisition List</a>
                                            </li>
                                            @endcan
                                            @can('app.requisition.report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.requisition').'/report'}}" class="{{($url==config('app.requisition').'/report') ? 'current-page':''}}">Report</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.requisition.index')
                                 <!-------------- Damage Request part ------------>
                                 <li class="default-sidebar-dropdown {{(
                                    $url==config('app.damagerequest').'/damagerequests/create' || $url==(request()->is(config('app.damagerequest').'/damagerequests/*/edit')) ||
                                    $url==config('app.damagerequest').'/damagerequests' ||
                                    $url==config('app.damagerequest').'/report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-autorenew"></i>
                                        <span class="menu-text">Damage Request Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.requisition.create')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.damagerequest').'/damagerequests/create'}}" class="{{($url==config('app.damagerequest').'/damagerequests/create' || $url==(request()->is(config('app.damagerequest').'/damagerequests/*/edit'))) ? 'current-page':''}}">Send Damage Request</a>
                                            </li>
                                            @endcan
                                            @can('app.requisition.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.damagerequest').'/damagerequests'}}" class="{{($url==config('app.damagerequest').'/damagerequests') ? 'current-page':''}}">Request List's</a>
                                            </li>
                                            @endcan
                                            @can('app.requisition.report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.damagerequest').'/report'}}" class="{{($url==config('app.damagerequest').'/report') ? 'current-page':''}}">Report</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.assettype.index')
                                <!-------------- asset part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.asset').'/asset-type' || $url==config('app.asset').'/asset-type/create' || $url==(request()->is(config('app.asset').'/asset-type/*/edit')) ||
                                    $url==config('app.asset').'/asset-sub-type' || $url==config('app.asset').'/asset-sub-type/create' || $url==(request()->is(config('app.asset').'/asset-sub-type/*/edit')) ||
                                    $url==config('app.asset').'/asset' || $url==config('app.asset').'/asset/create' || $url==(request()->is(config('app.asset').'/asset/*/edit')) ||
                                    $url==config('app.asset').'/assign-asset/create' ||
                                    $url==config('app.asset').'/assign-asset' ||
                                    $url==config('app.asset').'/assign-asset-amendment' ||
                                    $url==config('app.asset').'/add-damage' ||
                                    $url==config('app.asset').'/damage-report') ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-tv"></i>
                                        <span class="menu-text">Asset Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.assettype.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.asset').'/assign-asset/create'}}" class="{{($url==config('app.asset').'/assign-asset/create') ? 'current-page':''}}">Assign Asset</a>
                                            </li>
                                            @endcan
                                            @can('app.assignasset.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.asset').'/assign-asset'}}" class="{{($url==config('app.asset').'/assign-asset') ? 'current-page':''}}">Assign Asset Report</a>
                                            </li>
                                            @endcan
                                            @can('app.assignasset.amendment')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.asset').'/assign-asset-amendment'}}" class="{{($url==config('app.asset').'/assign-asset-amendment') ? 'current-page':''}}">Assign Asset Amendment</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.assettype.index')
                                <!-------------- library  part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.library').'/asset-type' || $url==config('app.library').'/asset-type/create' || $url==(request()->is(config('app.library').'/asset-type/*/edit')) ||
                                    $url==config('app.library').'/asset-sub-type' || $url==config('app.library').'/asset-sub-type/create' || $url==(request()->is(config('app.library').'/asset-sub-type/*/edit')) ||
                                    $url==config('app.library').'/asset' || $url==config('app.library').'/asset/create' || $url==(request()->is(config('app.library').'/asset/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-book"></i>
                                        <span class="menu-text">Library Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.assettype.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.library').'/asset-type'}}" class="{{($url==config('app.library').'/asset-type' || $url==config('app.library').'/asset-type/create' || $url==(request()->is(config('app.library').'/asset-type/*/edit'))) ? 'current-page':''}}">Books Type</a>
                                            </li>
                                            @endcan
                                            @can('app.assetsubtype.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.library').'/asset-sub-type'}}" class="{{($url==config('app.library').'/asset-sub-type' || $url==config('app.library').'/asset-sub-type/create' || $url==(request()->is(config('app.library').'/asset-sub-type/*/edit'))) ? 'current-page':''}}">Books Sub Type</a>
                                            </li>
                                            @endcan
                                            @can('app.asset.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.library').'/asset'}}" class="{{($url==config('app.library').'/asset' || $url==config('app.library').'/asset/create' || $url==(request()->is(config('app.library').'/asset/*/edit'))) ? 'current-page':''}}">Books</a>
                                            </li> 
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                @can('app.roles.index')
                                <!-------------- user part ------------>
                                <li class="default-sidebar-dropdown {{(
                                    $url==config('app.user').'/department' || $url==config('app.user').'/department/create' || $url==(request()->is(config('app.user').'/department/*/edit')) ||
                                    $url==config('app.user').'/designation' || $url==config('app.user').'/designation/create' || $url==(request()->is(config('app.user').'/designation/*/edit')) ||
                                    $url==config('app.user').'/user-list' || $url==config('app.user').'/user-list/create' || $url==(request()->is(config('app.user').'/user-list/*/edit')) ||
                                    $url==config('app.user').'/designation-wise-product/create' || $url==(request()->is(config('app.user').'/designation-wise-product/*/edit')) ||
                                    $url==config('app.user').'/designation-wise-product'||
                                    $url==config('app.user').'/designation-wise-product-amendment'||
                                    $url==config('app.user').'/user-role' || $url==config('app.user').'/user-role/create' || $url==(request()->is(config('app.user').'/user-role/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-user"></i>
                                        <span class="menu-text">Employee Management</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            @can('app.departments.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/department'}}" class="{{($url==config('app.user').'/department' || $url==config('app.user').'/department/create' || $url==(request()->is(config('app.user').'/department/*/edit'))) ? 'current-page':''}}">Department</a>
                                            </li>
                                            @endcan
                                            @can('app.designations.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/designation'}}" class="{{($url==config('app.user').'/designation' || $url==config('app.user').'/designation/create' || $url==(request()->is(config('app.user').'/designation/*/edit'))) ? 'current-page':''}}">Designation</a>
                                            </li>
                                            @endcan
                                            @can('app.users.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/user-list'}}" class="{{($url==config('app.user').'/user-list' || $url==config('app.user').'/user-list/create' || $url==(request()->is(config('app.user').'/user-list/*/edit'))) ? 'current-page':''}}">Employee</a>
                                            </li>
                                            @endcan
                                            @can('app.productassign.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/designation-wise-product/create'}}" class="{{($url==config('app.user').'/designation-wise-product/create' || $url==(request()->is(config('app.user').'/designation-wise-product/*/edit'))) ? 'current-page':''}}">Designation Wise Product</a>
                                            </li>
                                            @endcan
                                            @can('app.User Wise Product Report')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/designation-wise-product'}}" class="{{($url==config('app.user').'/designation-wise-product') ? 'current-page':''}}">Designation Wise Product Report</a>
                                            </li>
                                            @endcan
                                            @can('app.productassign.amendment')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/designation-wise-product-amendment'}}" class="{{($url==config('app.user').'/designation-wise-product-amendment') ? 'current-page':''}}">Designation Product Amendment</a>
                                            </li>
                                            @endcan
                                            @can('app.roles.index')
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.user').'/user-role'}}" class="{{($url==config('app.user').'/user-role' || $url==config('app.user').'/user-role/create' || $url==(request()->is(config('app.user').'/user-role/*/edit'))) ? 'current-page':''}}">User Role</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </li>
                                @endcan
                                <!-------------- change password part ------------>
                                <li class="default-sidebar {{($url=='settings') ? 'active':''}}">
                                    <a href="{{URL::to('settings')}}">
                                        <i class="icon-lock"></i>
                                        <span class="menu-text">Change Password</span>
                                    </a>
                                </li>
                                <!-------------- amendment part ------------>
                                <!-- <li class="default-sidebar-dropdown {{(
                                    $url==config('app.amendment').'/other-receive-amenment' || $url==config('app.amendment').'/other-receive-amenment/create' || $url==(request()->is(config('app.amendment').'/other-receive-amenment/*/edit')) ||
                                    $url==config('app.amendment').'/other-payment-amenment' || $url==config('app.amendment').'/other-payment-amenment/create' || $url==(request()->is(config('app.amendment').'/other-payment-amenment/*/edit')) ||
                                    $url==config('app.amendment').'/bank-deposit-amendment' || $url==config('app.amendment').'/bank-deposit-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-deposit-amendment/*/edit')) ||
                                    $url==config('app.amendment').'/bank-withdraw-amendment' || $url==config('app.amendment').'/bank-withdraw-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-withdraw-amendment/*/edit')) ||
                                    $url==config('app.amendment').'/bank-transfer-amendment' || $url==config('app.amendment').'/bank-transfer-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-transfer-amendment/*/edit')) ||
                                    $url==config('app.amendment').'/customer-bill-amendment' || $url==config('app.amendment').'/customer-bill-amendment/create' || $url==(request()->is(config('app.amendment').'/customer-bill-amendment/*/edit')) ||
                                    $url==config('app.amendment').'/purchase-product-amendment' || $url==config('app.amendment').'/purchase-product-amendment/create' || $url==(request()->is(config('app.amendment').'/purchase-product-amendment/*/edit'))) ? 'active':''}}">
                                    <a href="javascript::void(0)">
                                        <i class="icon-user"></i>
                                        <span class="menu-text">{{ __('menu.Amendment') }}</span>
                                    </a>
                                    <div class="default-sidebar-submenu">
                                        <ul>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/other-receive-amenment'}}" class="{{($url==config('app.amendment').'/other-receive-amenment' || $url==config('app.amendment').'/other-receive-amenment/create' || $url==(request()->is(config('app.amendment').'/other-receive-amenment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Income_Voucher') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/other-payment-amenment'}}" class="{{($url==config('app.amendment').'/other-payment-amenment' || $url==config('app.amendment').'/other-payment-amenment/create' || $url==(request()->is(config('app.amendment').'/other-payment-amenment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Expense_Voucher') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/bank-deposit-amendment'}}" class="{{($url==config('app.amendment').'/bank-deposit-amendment' || $url==config('app.amendment').'/bank-deposit-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-deposit-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Bank_Deposit') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/bank-withdraw-amendment'}}" class="{{($url==config('app.amendment').'/bank-withdraw-amendment' || $url==config('app.amendment').'/bank-withdraw-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-withdraw-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Bank_Withdraw') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/bank-transfer-amendment'}}" class="{{($url==config('app.amendment').'/bank-transfer-amendment' || $url==config('app.amendment').'/bank-transfer-amendment/create' || $url==(request()->is(config('app.amendment').'/bank-transfer-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Bank_Transfer') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/customer-bill-amendment'}}" class="{{($url==config('app.amendment').'/customer-bill-amendment' || $url==config('app.amendment').'/customer-bill-amendment/create' || $url==(request()->is(config('app.amendment').'/customer-bill-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Bill_Collection') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/sell-product-amendment'}}" class="{{($url==config('app.amendment').'/sell-product-amendment' || $url==config('app.amendment').'/sell-product-amendment/create' || $url==(request()->is(config('app.amendment').'/sell-product-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Sell_Product') }}</a>
                                            </li>
                                            <li>
                                                <a href="{{$baseUrl.'/'.config('app.amendment').'/purchase-product-amendment'}}" class="{{($url==config('app.amendment').'/purchase-product-amendment' || $url==config('app.amendment').'/purchase-product-amendment/create' || $url==(request()->is(config('app.amendment').'/purchase-product-amendment/*/edit'))) ? 'current-page':''}}">{{ __('menu.Purchase_Product') }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar menu ends -->

                </div>
                <!-- Default sidebar wrapper end -->
                
            </nav>
            <!-- Sidebar wrapper end -->

            <!-- *************
                ************ Main container start *************
            ************* -->
            <div class="main-container">

                <!-- Page header starts -->
                <div class="page-header">
                    
                    <!-- Row start -->
                    <div class="row gutters">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-9">

                            <!-- Search container start -->
                            <div class="search-container">

                                <!-- Toggle sidebar start -->
                                <div class="toggle-sidebar" id="toggle-sidebar">
                                    <i class="icon-menu"></i>
                                </div>
                                <!-- Toggle sidebar end -->
                            </div>
                            <!-- Search container end -->

                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-3">

                            <!-- Header actions start -->
                            <ul class="header-actions">
                                <li class="dropdown">
                                    <a href="{{ route('user-list.show',auth()->user()->id) }}" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                        <span class="avatar">
                                            @if (!empty(auth()->user()->image))
                                            <img class="profile-user-img img-responsive img-fluid" src="{{asset('upload/user/'.auth()->user()->image)}}" alt="User profile picture">
                                            @else
                                            <img class="profile-user-img img-responsive img-fluid" src="{{asset('upload/logo/no-image.jpg')}}" alt="User profile picture">
                                            @endif
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end sm" aria-labelledby="userSettings" style="width: 21rem">
                                        <div class="header-profile-actions">
                                            <a href="{{ route('user-list.show',auth()->user()->id) }}"><i class="icon-user1"></i>Profile</a>
                                            <a href="{{URL::to('settings')}}"><i class="icon-lock"></i>Change Password</a> 
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-log-out1"></i>Logout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- Header actions end -->

                        </div>
                    </div>
                    <!-- Row end -->                    

                </div>
                <!-- Page header ends -->
                @yield('content') 
                <!-- App footer start -->
                <div class="app-footer">© BinaryIT <?php echo date('Y')?></div>
                <!-- App footer end -->
            </div>
            <!-- ************************* Main container end ************************** -->

        </div>
        <!-- Page wrapper end -->

        <!-- *************
            ************ Required JavaScript Files *************
        ************* -->
        <!-- Required jQuery first, then Bootstrap Bundle JS -->
        {!!Html::script('custom/js/jquery.min.js')!!}
        {!!Html::script('custom/js/bootstrap.bundle.min.js')!!}
        {!!Html::script('custom/js/modernizr.js')!!}
        {!!Html::script('custom/js/moment.js')!!}
        
        {!!Html::script('custom/js/webcam.min.js')!!}

        <!-- *************
            ************ Vendor Js Files *************
        ************* -->
        
        <!-- Megamenu JS -->
        {!!Html::script('custom/vendor/megamenu/js/megamenu.js')!!}
        {!!Html::script('custom/vendor/megamenu/js/custom.js')!!}

        <!-- Slimscroll JS -->
        {!!Html::script('custom/vendor/slimscroll/slimscroll.min.js')!!}
        {!!Html::script('custom/vendor/slimscroll/custom-scrollbar.js')!!}

        <!-- Search Filter JS -->
        {!!Html::script('custom/vendor/search-filter/search-filter.js')!!}
        {!!Html::script('custom/vendor/search-filter/custom-search-filter.js')!!}

        <!-- Data Tables -->
        {!!Html::script('custom/vendor/datatables/dataTables.min.js')!!}
        {!!Html::script('custom/vendor/datatables/dataTables.bootstrap.min.js')!!}
        
        <!-- Custom Data tables -->
        {!!Html::script('custom/vendor/datatables/custom/custom-datatables.js')!!}

        <!-- Download / CSV / Copy / Print -->
        {!!Html::script('custom/vendor/datatables/buttons.min.js')!!}
        {!!Html::script('custom/vendor/datatables/jszip.min.js')!!}
        {!!Html::script('custom/vendor/datatables/pdfmake.min.js')!!}
        {!!Html::script('custom/vendor/datatables/vfs_fonts.js')!!}
        {!!Html::script('custom/vendor/datatables/html5.min.js')!!}
        {!!Html::script('custom/vendor/datatables/buttons.print.min.js')!!}

        <!-- Apex Charts -->
         <!-- {!!Html::script('custom/vendor/apex/apexcharts.min.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/salesGraph.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/ordersGraph.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/earningsGraph.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/visitorsGraph.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/customersGraph.js')!!}
        {!!Html::script('custom/vendor/apex/custom/home/sparkline.js')!!} -->

        {!!Html::script('custom/vendor/apex/apexcharts.min.js')!!}
        {!!Html::script('custom/vendor/apex/examples/pie/basic-pie-graph.js')!!}

        <!-- Circleful Charts -->
        <!-- {!!Html::script('custom/vendor/circliful/circliful.min.js')!!}
        {!!Html::script('custom/vendor/circliful/circliful.custom.js')!!} -->

        <!-- Main Js Required -->
        {!!Html::script('custom/js/main.js')!!}

        <!-- Date Range JS -->
        {!!Html::script('custom/vendor/daterange/daterange.js')!!}
        {!!Html::script('custom/vendor/daterange/custom-daterange.js')!!}

        <!-- Bootstrap Select JS -->
        {!!Html::script('custom/vendor/bs-select/bs-select.min.js')!!}
        {!!Html::script('custom/vendor/bs-select/bs-select-custom.js')!!}

        <!-- Sweet alert -->
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            $('.confirmdelete').on('click', function (event) {
              event.preventDefault();
                  var $form = $(this).closest('form');
                  swal({
                      title: "Are you sure?",
                      text: $(this).attr('confirm'),
                      type: "warning",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      $form.submit();
                    }
                  });
            });

            $(document).ready( function () {
              $('#dataTable').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
              });
            });

            function printReportOld() {
                //("#print_icon").hide();
                var reportTablePrint=document.getElementById("printTable");
                newWin= window.open("");
                //newWin.document.write('<table width="100%"><tr><td><center>শুকরিয়া মার্কেট<br>জিন্দা বাজার, সিলেট<br>(+৮৮০) ১৭১১৭২১০৮০</center></td></tr></table><br>');
                newWin.document.write('<table width="100%"><tr><td><center>Baby Land Park</center></td></tr></table><br>');
                newWin.document.write(reportTablePrint.innerHTML);
                newWin.print();
                newWin.close();
                ("#print_icon").show();
            }

            function printReport() {
                //("#print_icon").hide();
                var reportTablePrint=document.getElementById("printTable");
                newWin= window.open();
                var is_chrome = Boolean(newWin.chrome);
                // var top = '<center><img src="{{URL::to("logo/logo.png")}}" width="40px" height="40px"></center>';
                //   top += '<center><h3>Baby Land Park</h3></center>';
                //   top += '<center><p style="margin-top:-10px">Address</p></center>';
                // newWin.document.write(top);
                newWin.document.write(reportTablePrint.innerHTML);
                if (is_chrome) {
                    setTimeout(function () { // wait until all resources loaded 
                    newWin.document.close(); // necessary for IE >= 10
                    newWin.focus(); // necessary for IE >= 10
                    newWin.print();  // change window to winPrint
                    newWin.close();// change window to winPrint
                    }, 250);
                }
                else {
                    newWin.document.close(); // necessary for IE >= 10
                    newWin.focus(); // necessary for IE >= 10

                    newWin.print();
                    newWin.close();
                }
            }


            $('.keyup').on('keyup', function () {
              if ($('#newPass').val() == $('#confirmPass').val()) {
                $('#confirmMsg').html('Password Matched !').css('color', 'green');
              } else 
                $('#confirmMsg').html('Password Do not Matched !').css('color', 'red');
            });
            
            jQuery('.decimal').on('keydown', function (event) {return isNumberOveride(event, this);});

            function isNumberOveride(evt, element) {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode != 190 || $(element).val().indexOf('.') != -1) // “.” CHECK DOT, AND ONLY ONE.
                && (charCode != 110 || $(element).val().indexOf('.') != -1) // “.” CHECK DOT, AND ONLY ONE.
                && ((charCode < 48 && charCode != 8)
                || (charCode > 57 && charCode < 96)
                || charCode > 105))
                return false;
                return true;
            }
        </script>

        <!--jquery datepicker-->
        <!-- <link href= "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script>
            $(function() {
              $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

              $(".monthpicker").datepicker({
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: "MM-yy",
                  showButtonPanel: true,
                  currentText: "This Month",
                  onChangeMonthYear: function (year, month, inst) {
                      $(this).val($.datepicker.formatDate('MM-yy', new Date(year, month - 1, 1)));
                  },
                  onClose: function(dateText, inst) {
                      var month = $(".ui-datepicker-month :selected").val();
                      var year = $(".ui-datepicker-year :selected").val();
                      $(this).val($.datepicker.formatDate('MM-yy', new Date(year, month, 1)));
                  }
              }).focus(function () {
                  $(".ui-datepicker-calendar").hide();
              }).after(
                  $("<a href='javascript: void(0);'>clear</a>").click(function() {
                      $(this).prev().val('');
                  })
              );
            });
        </script> -->
        <!--./jquery datepicker-->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
        <script type="text/javascript">
            /*$(document).ready(function(){
              $('.select2').select2({ width: '100%', height: '100%', placeholder: "Select an Option", allowClear: true });

            });*/
        </script>

        <!--jquery datepicker-->
          <link href= "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
          <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
          <script>
            $(function() {
              $( ".datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
          </script>
          <!--./jquery datepicker-->
        
        @stack("custom_script")  
    </body>
</html>