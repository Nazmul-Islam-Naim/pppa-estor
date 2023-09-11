@extends('layouts.layout')
@section('title', 'Requisition Details')
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
                @include('common.message')
                @include('common.commonFunction')
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Card start -->
                <div class="card">
                    <div class="card-header-lg">
                        <h4>User Requisition Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="invoice-container">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <address class="m-0">
                                           {{$single_data->user->name}},<br>
                                           {{$single_data->user->designation->title}},<br>
                                           {{$single_data->user->department->title}},<br>
                                           {{$single_data->user->email}}
                                        </address>
                                        <div class="invoice-num">
                                            <div>Requisition - #{{$single_data->id}}</div>
                                            <div>{{date('d F Y h:i A',strtotime($single_data->date))}}</div>
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
                                                    <th>Product Unit</th>
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <th>Available Stock</th>
                                                    @endif
                                                    <th>Quantity</th>
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
                                                    <td>{{$data->product->unit->name}}</td>
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <td>{{$data->product->stockProduct->quantity ?? 0}}</td>
                                                    @endif
                                                    <td>{{$data->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <td colspan="7" style="text-align:center"> Requisition Review </td>
                                                    @else
                                                    <td colspan="6" style="text-align:center"> Requisition Review </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                             <!-- Row end -->
                            <!-- Row start -->
                                <!-- Row start -->
                                @foreach($single_data->requisitionComments as $comment)
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                            <address class="m-0 {{ $comment->status?'':'text-danger' }}">
                                               {{$comment->comment}},<br>
                                               By - #{{$comment->user->name}},<br>
                                               Designation - #{{$comment->user->designation->title}},<br>
                                               Role - #{{$comment->user->role->title}}
                                            </address>
                                            <div class="invoice-num {{ $comment->status?'':'text-danger' }}">
                                                <div>Type - #{{$comment->type}}</div>
                                                <div>{{date('d F Y',strtotime($comment->created_at))}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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