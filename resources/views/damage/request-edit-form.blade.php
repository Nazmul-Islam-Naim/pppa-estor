@extends('layouts.layout')
@section('title', 'Requisition Edit Form')
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
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="">
                        <div class="card-header card-title">Edit & Update Damage Request</div>
                        <p class="card-header card-title">Request From: {{$single_data->user->name}} || Designation: {{$single_data->user->designation->title}} || Department: {{$single_data->user->department->title}}</p>
                    </div>
                    {!! Form::open(array('route' =>['damagerequests.update',$single_data->id],'method'=>'PUT','files'=>true)) !!}
                    <div class="card-body">
                      <div class="col-md-12">
                          <div class="form-inline">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <input class="form-control datepicker" type="text" name="date" value="{{(!empty($single_data)) ? $single_data->date :date('Y-m-d')}}" autocomplete="off" required="">
                                  </div>
                                  <div class="field-placeholder">Date <span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <textarea name="note" class="form-control" style="height:40px">{{(!empty($single_data)) ? $single_data->note : ''}}</textarea>
                                  </div>
                                  <div class="field-placeholder">Note <span class="text-danger">*</span></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="table-responsive">
                            <!--<table id="dataTable" class="table v-middle">-->
                            <table id="myTableID" class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                <?php $row_num = 0; ?>
                                @foreach($alldata as $data)
                                <?php $row_num++; ?>
                                    <tr id="row_{{$row_num}}">
                                        <td style="border: 1px solid #fff; width:30%">
                                            <input type="text" class="form-control" value="{{$data->product->name}}" readonly="">
                                            <input type="hidden" class="form-control" name="addmore[{{$row_num}}][product_id]" value="{{$data->product_id}}" readonly="">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control"
                                                name="addmore[{{$row_num}}][quantity]" id="quantity"  value="{{$data->quantity }}"
                                                required="">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align:right">
                              <button type="submit" class="form-control">Update</button>
                            </div>
                          {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

<!-- Content wrapper scroll end -->
@endsection