@extends('layouts.layout')
@section('title', 'Designation Wise Product')
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
                <!-- Card start -->
                <div class="card">
                    <div class="card-header-lg">
                        <h4>Designation Wise Product Details</h4>
                        <a href="{{route('designation-wise-product.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                    </div>
                    <div class="card-body">
                        <div class="invoice-container">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <address class="m-0">
                                           {{$single_data->designation->title}},<br>
                                        </address>
                                        <div class="invoice-num">
                                            <div>Product - #{{$single_data->id}}</div>
                                            <div>{{date('d F Y',strtotime($single_data->date))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Serial</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Product Category</th>
                                                    <th>Product Sub Category</th>
                                                    <th>Monthly Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $sl = 0;?>
                                              @foreach( $alldata as $data)
                                              <?php $sl++;?>
                                                <tr>
                                                    <td>{{$sl}}</td>
                                                    <td>{{$data->product->name}}</td>
                                                    <td>{{$data->product->type->name}}</td>
                                                    <td>{{$data->product->category->name}}</td>
                                                    <td>{{$data->product->subcategory->name}}</td>
                                                    <td>{{$data->quantity >= 99 ? 'Unlimited' : $data->quantity}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                    </div>
                </div>
                <!-- Card end -->
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- Content wrapper end -->

    @endsection