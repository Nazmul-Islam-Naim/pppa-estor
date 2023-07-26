@extends('layouts.layout')
@section('title', 'Profile')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="profile-header">
                    <h1>Welcome, {{$userinfo->name}}</h1>
                    <div class="profile-header-content">
                        <div class="profile-header-tiles">
                            <div class="row gutters">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="profile-tile">
                                        <span class="icon">
                                            <i class="icon-map-pin"></i>
                                        </span>
                                        <h6>Designation - <span>{{$userinfo->designation->title}}</span></h6>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="profile-tile">
                                        <span class="icon">
                                            <i class="icon-layers"></i>
                                        </span>
                                        <h6>Department - <span>{{$userinfo->department->title}}</span></h6>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="profile-tile">
                                        <span class="icon">
                                            <i class="icon-email"></i>
                                        </span>
                                        <h6>E-mail - <span>{{$userinfo->email}}</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-avatar-tile">
                          @if (!empty($userinfo->image))
                          <img class="profile-user-img img-responsive img-fluid" src="{{asset('upload/user/'.$userinfo->image)}}" alt="User profile picture">
                          @else
                          <img class="profile-user-img img-responsive img-fluid" src="{{asset('upload/logo/no-image.jpg')}}" alt="User profile picture">
                          @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Row end -->

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Asset List</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Asset Name</th>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                                    </thead>
                                    <tbody>
                                      <?php $sl=0;?>
                                      @foreach($userasset as $asset)
                                      <?php $sl++;?>
                                      <tr>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl}}</td>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$asset->asset->name}}</td>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$asset->quantity}}</td>
                                      </tr>
                                      @endforeach
                                      @if($sl == 0)
                                      <tr>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px; text-align:center" colspan="3">No data found.....</td>
                                      </tr>
                                      @endif
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Product List</div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Product Name</th>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Category</th>
                                      <th style="border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                                    </thead>
                                    <tbody>
                                      <?php $sl1=0;?>
                                      @foreach($userproduct as $product)
                                      <?php $sl1++;?>
                                      <tr>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl1}}</td>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$product->product->name}}</td>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$product->product->category->name}}</td>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$product->quantity >= 999 ? 'Unlimited' : $product->quantity}}</td>
                                      </tr>
                                      @endforeach
                                      @if($sl1 == 0)
                                      <tr>
                                        <td style="border: 1px solid #ddd; padding: 3px 3px; text-align:center" colspan="3">No data found.....</td>
                                      </tr>
                                      @endif
                                    </tbody>
                                    <tfoot>
                                        {{$userproduct->links()}}
                                    </tfoot>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Requisition Details</div>
                            </div>
                            <div class="card-body">
                                <div class="customScroll250">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Date</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Product Name</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Category</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Unit</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                                      </thead>
                                      <tbody>
                                        <?php $sl4=0;?>
                                        @foreach($userrequsition as $productdetails)
                                        @foreach($productdetails->requisitionProducts as $value)
                                        <?php $sl4++;?>
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl4}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{date('d-m-Y',strtotime($value->requisition->date))}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$value->product->name}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$value->product->category->name}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$value->product->unit->name}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$value->quantity}}</td>
                                        </tr>
                                        @endforeach
                                        @endforeach
                                        @if($sl4 == 0)
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px; text-align:center" colspan="6">No data found.....</td>
                                        </tr>
                                        @endif
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
                <!-- Row end -->
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <!-- Row start -->
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Role List</div>
                            </div>
                            <div class="card-body">
                                <div class="customScroll250">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Role Title</th>
                                      </thead>
                                      <tbody>
                                        <?php $sl2=0;?>
                                        @foreach($userrole->role->permissions as $role)
                                        <?php $sl2++;?>
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl2}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$role->title}}</td>
                                        </tr>
                                        @endforeach
                                        @if($sl2 == 0)
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px; text-align:center" colspan="2">No data found.....</td>
                                        </tr>
                                        @endif
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Requisition History</div>
                            </div>
                            <div class="card-body">
                                <div class="customScroll250">
                                  <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Date</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Requisition Id</th>
                                        <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                                      </thead>
                                      <tbody>
                                        <?php $sl3=0;?>
                                        @foreach($userrequsition as $requisition) 
                                        <?php $sl3++;?>
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl3}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{date('d-m-Y',strtotime($requisition->date))}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">Requisition#{{$requisition->id}}</td>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px">{{$requisition->note}}</td>
                                        </tr>
                                        @endforeach
                                        @if($sl3 == 0)
                                        <tr>
                                          <td style="border: 1px solid #ddd; padding: 3px 3px; text-align:center" colspan="4">No data found.....</td>
                                        </tr>
                                        @endif
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
                <!-- Row end -->
            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>
<!-- Content wrapper scroll end -->
@endsection