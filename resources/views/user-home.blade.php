@extends('layouts.layout')
@section('title', 'User Dashboard')
@section('content')
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

	<!-- Content wrapper start -->
	<div class="content-wrapper">

		<!-- Row start -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			@include('common.commonFunction')
			</div>
			@can('app.departments.index')
			<!------------------- number of department ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('department.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/department.gif')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$department}}</h4>
                            <p>Department</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>

			@endcan
			@can('app.designations.index')
			<!------------------- number of designation ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('designation.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/destination.gif')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$designation}}</h4>
                            <p>Designation</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>

			@endcan
			@can('app.producttype.index')
			<!------------------- total product ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('product.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/product.png')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$product}}</h4>
                            <p>Total Product</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>

			@endcan
			@can('app.stock.report')
			<!------------------- total stock ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('stock-product.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/stock.png')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$stock}}</h4>
                            <p>Available Stock</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.assettype.index')
			<!------------------- available asset ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('assign-asset.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/asset.gif')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{round($asset)}}</h4>
                            <p>Available Asset</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.users.index')
			<!------------------- total user ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('user-list.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/user.gif')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$user}}</h4>
                            <p>Employee</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.requisition.index')
			<!------------------- pending requisition  ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('requisition.index',['status'=>auth()->user()->isStoreKeeper()?'Approver':'Published'])}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/requisition.gif')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{$pendingrequisition}}</h4>
                            <p>Pending Requisition</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.stock.report')
			<!------------------- stock Product Notify  ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('stock-notify')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/bell.png')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{!empty($stockNotify) ? $stockNotify: '0'}}</h4>
                            <p>Stock Notification</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.assettype.index')
			<!------------------- available books  ---------------------->
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{route('asset.index')}}">
                    <div class="stats-tile">
                        <div class="sale-icon">
                            <i ><img src="{{asset('upload/logo/books.png')}}" alt="" width="60px"></i>
                        </div>
                        <div class="sale-details">
                            <h4>{{!empty($books) ? $books: '0'}}</h4>
                            <p>Available Books</p>
                        </div>
                        <div class="sale-graph">
                            <div id="sparklineLine5"></div>
                        </div>
                    </div>
                </a>
            </div>
            
			@endcan
			@can('app.stock.report')
			<!------------------- chart  ---------------------->
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
				<div class="card">
					<div class="card-header">
						<div class="card-title">Stock product current state</div>
					</div>
					<div class="card-body">
						<div id="basic-pie-graph" style="width: 50%; margin-left: 11%"></div>
					</div>
				</div>
			</div>
			@endcan
		</div>
		<!-- Row end -->
	</div>
	<!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
{!!Html::script('custom/js/jquery.min.js')!!}
@endsection