@extends('layouts.layout')
@section('title', 'Supplier Payment List')
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
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Supplier Payment List</h3>
            </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered" id="basicExample" style="width:100%"> 
                    <thead> 
                      <tr> 
                        <th>Sl</th>
                        <th>Supplier Name</th>
                        <th>Supplier Mobile</th>
                        <th>Total Bill</th>
                        <th>Total Due</th>
                        <th>Total Payment</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $sl =0; ?>
                        @foreach($alldata as $data)
                        <?php $sl++; ?>
                        <tr>
                          <td>{{$sl}}</td>
                          <td>{{$data->name}}</td>
                          <td>{{$data->phone}}</td>
                          <td>{{$data->total_due + $data->total_payment}}</td>
                          <td>{{$data->total_due}}</td>
                          <td>{{$data->total_payment}}</td>
                          <td>
                          <a href="#myModal_{{$data->id}}" data-bs-toggle="modal" class="badge bg-primary badge-sm" >Payment</a>
                            <!-- Modal -->
                            <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                {!! Form::open(array('route' =>['supplier-payment-store'],'method'=>'POST')) !!}
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Supplier Payment</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="form-group">
                                      <label>Name</label>
                                      <input type="text" class="form-control" value="{{$data->name}}" readonly="">
                                        <input type="hidden" value="{{$data->id}}" name="supplier_id">
                                    </div>
                                    <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" class="form-control" value="{{$data->phone}}" readonly="">
                                    </div>
                                    <div class="form-group">
                                      <label>Due Amount</label>
                                      <input type="text" class="form-control" value="{{$data->total_due}}" readonly="">
                                    </div>
                                    <div class="form-group">
                                      <label>Amount</label>
                                      <input type="number" name="pay_amount" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                      <label>Date</label>
                                      <input type="text" name="date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <div class="form-group">
                                      <label>Payment Method</label>
                                      <select class="form-control" name="payment_method">
                                        @foreach($allbank as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal">Close</button>
                                    <input type="submit" name="supplier_payment" class="btn btn-success btn-sm" value="Payment">
                                  </div>
                                </div>
                                {!! Form::close() !!}
                              </div>
                            </div>
                            <!-- ./Modal -->
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer"></div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection 