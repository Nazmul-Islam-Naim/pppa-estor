@extends('layouts.layout')
@section('title', 'Purchase Invoice')
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
                        <h4>Purchase Invoice</h4>
                        <!-- <a href="{{route('assign-asset.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a> -->
                        <a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:30px;" src='{{asset("custom/img/print.png")}}'></a>
                    </div>
                    <div class="card-body" id="printTable">
                        <div class="invoice-container">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >
                                    <div class="invoice-details" >
                                        <address class="m-0">
                                           Name: {{$single_data->supplier->name}},<br>
                                           Phone: {{$single_data->supplier->phone}},<br>
                                           E-mail: {{$single_data->supplier->email}},<br>
                                           Address: {{$single_data->supplier->address}}
                                        </address>
                                        <div class="invoice-num">
                                            <div>Invoice - #{{$single_data->id}}</div>
                                            <div>Purchase Type - #{{$single_data->tender_number}}</div>
                                            <div>{{date('d F Y',strtotime($single_data->purchase_date))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" cellspacing="0" cellpadding="0">
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Serial</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Product Name</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Product Type</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Product Category</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Product Unit</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>
                                                    <th style="border: 1px solid #ddd; padding: 3px 3px">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $sl = 0; $total = 0;?>
                                              @foreach( $alldata as $data)
                                              <?php $sl++;?>
                                                <tr>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$sl}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->name}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->type->name}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->category->name}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->unit->name}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->quantity}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->unit_price}}</td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->quantity * $data->unit_price}} <?php $total += ($data->quantity * $data->unit_price);?></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" style="border: 1px solid #ddd; padding: 3px 3px; text-align:center"><strong>Total</strong></td>
                                                    <td style="border: 1px solid #ddd; padding: 3px 3px"><strong>{{$total}}</strong></td>
                                                </tr>
                                            </tfoot>
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