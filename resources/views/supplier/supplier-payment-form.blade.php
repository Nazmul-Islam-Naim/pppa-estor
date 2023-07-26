@extends('layouts.layout')
@section('title', 'Supplier Payment Edit')
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
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
          {!! Form::open(array('route' =>['supplier-payment-update', $single_data->id],'method'=>'POST','files'=>true)) !!}
        <div class="card">
          <div class="card-header">
            <div class="card-title">Update Payment</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" value="{{$single_data->supplier->name}}" readonly="">
                    <input type="hidden" value="{{$single_data->supplier_id}}" name="supplier_id">
                    <input type="hidden" value="{{$single_data->tok}}" name="tok">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" value="{{$single_data->supplier->phone}}" readonly="">
                </div>
                <div class="form-group">
                  <label>Due Amount</label>
                  <input type="text" class="form-control" value="{{$single_data->supplier->total_due}}" readonly="">
                </div>
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" name="pay_amount" value="{{$single_data->amount}}" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                  <label>Date</label>
                  <input type="text" name="date" class="form-control datepicker" value="{{!empty($single_data)? $single_data->date :date('Y-m-d')}}"
                </div>
                <div class="form-group">
                  <label>Payment Method</label>
                  <select class="form-control" name="payment_method">
                    @foreach($allbank as $bank)
                    <option value="{{$bank->id}}" {{($single_data->bank_id == $bank->id) ? 'selected':''}}>{{$bank->bank_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 