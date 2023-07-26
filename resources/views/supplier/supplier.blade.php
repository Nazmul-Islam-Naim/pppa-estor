@extends('layouts.layout')
@section('title', 'Supplier')
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
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
        @if(!empty($single_data))
          {!! Form::open(array('route' =>['product-supplier.update', $single_data->id],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Edit";?>
        @else
        {!! Form::open(array('route' =>['product-supplier.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}} {{ __('menu.Supplier') }} </div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <?php
                  $cusID = DB::table('suppliers')->orderBy('id', 'desc')->first();
                  if (!empty($cusID->supplier_id)) {
                    $id = $cusID->supplier_id+1;
                  }else{
                    $id = '1000';
                  }
                ?>
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    @if(!empty($single_data->supplier_id))
                    <input class="form-control" type="text" name="supplier_id" value="{{(!empty($single_data->supplier_id))?$single_data->supplier_id:''}}" required="" readonly=""  autocomplete="off">
                    @else
                    <input class="form-control" type="text" name="supplier_id" value="<?php echo $id;?>" required=""  readonly="" autocomplete="off">
                    @endif
                  </div>
                  <div class="field-placeholder">{{ __('home.Supplier_Id') }} </div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="text" name="name" value="{{(!empty($single_data->name))?$single_data->name:''}}" autocomplete="off" required>
                  </div>
                  <div class="field-placeholder">{{ __('home.name') }} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="text" name="phone" value="{{(!empty($single_data->phone))?$single_data->phone:''}}" autocomplete="off" required>
                  </div>
                  <div class="field-placeholder">{{ __('home.phone') }} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="email" name="email" value="{{(!empty($single_data->email))?$single_data->email:''}}" autocomplete="off">
                  </div>
                  <div class="field-placeholder">{{ __('home.email') }}</div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <textarea name="address">{{(!empty($single_data->address))?$single_data->address:''}}</textarea>
                  </div>
                  <div class="field-placeholder" class="form-control">{{ __('home.Address') }}</div>
                </div>
                <!-- Field wrapper end -->
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">{{$info}}</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{ __('menu.Supplier') }}</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!--<table id="dataTable" class="table v-middle">-->
              <table id="basicExample" class="table custom-table">
                <thead>
                  <tr>
                    <th>{{ __('home.SL') }}</th>
                    <th>{{ __('home.name') }}</th>
                    <th>{{ __('home.phone') }}</th>
                    <th>{{ __('home.email') }}</th>
                    <th>{{ __('home.Address') }}</th>
                    <th>{{ __('home.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $sl = 1;?>
                  @foreach($alldata as $data)
                  <tr>
                    <td>{{$sl++}}</td>
                    <td><a href="{{url::to('supplier/supplier-ledger/'.$data->id)}}">{{$data->name}}</a></td>
                    <td>{{$data->phone}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->address}}</td>
                    <td>
                      <div class="actions" style="height: 25px">
                        <a href="{{ route('product-supplier.edit', $data->id) }}" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit">
                          <i class="icon-edit1 text-info"></i>
                        </a>
                        <!-- <a href="#myModal_{{$data->id}}" data-bs-toggle="modal" title="Payment">
                          <i class="icon-picture_in_picture text-info"></i>
                        </a> -->
                        {{Form::open(array('route'=>['product-supplier.destroy',$data->id],'method'=>'DELETE'))}}
                          <button type="submit" class="btn btn-default btn-xs confirmdelete" confirm="You want to delete this informations ?" title="Delete" style="width: 100%"><i class="icon-x-circle text-danger"></i></button>
                        {!! Form::close() !!}
                      </div>
                      <!-- Modal -->
                      <div id="myModal_{{$data->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          {!! Form::open(array('route' =>['product-supplier.store'],'method'=>'POST')) !!}
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
                              <?php
                                    $billAmount = DB::table('supplier_ledgers')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'purchase' . '%')->sum('amount');

                                    $payAmount = DB::table('supplier_ledgers')->where('supplier_id', $data->id)->where('reason', 'like', '%' . 'payment' . '%')->sum('amount');
                                    $dueAmount = $billAmount - $payAmount;
                                  ?>
                              <div class="form-group">
                                <label>Due Amount</label>
                                <input type="text" class="form-control" value="{{$dueAmount}}" readonly="">
                              </div>
                              <div class="form-group">
                                <label>Amount</label>
                                <input type="text" name="pay_amount" class="form-control" autocomplete="off">
                              </div>
                              <div class="form-group">
                                <label>Date</label>
                                <input type="text" name="collect_date" class="form-control datepicker" value="<?php echo date('Y-m-d');?>">
                              </div>
                              <div class="form-group">
                                <label>Payment Method</label>
                                <select class="form-control" name="payment_method">
                                  @foreach(\App\Models\BankAccount::all() as $bank)
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
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 