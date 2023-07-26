@extends('layouts.layout')
@section('title', 'Supplier Payment Report')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<section class="content-header">
  <h1> {{ __('messages.supplier_payment_amendment') }} <small></small> </h1>
  <ol class="breadcrumb">
    <li><a href="{{URL::To('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Amendment</li>
  </ol>
</section>
<style type="text/css">
  .borderless td, .borderless th {
    border: none!important;
  }
</style>
<!-- Main content -->
<section class="content">
  @include('common.message')
  @include('common.commonFunction')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> <i class="fa fa-list-alt"></i> {{ __('messages.supplier_payment_amendment') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12"> 
              <div class="table-responsive">
                <table class="table borderless">
                  <tbody>
                    <tr>
                      <td style="text-align: center;">
                        <form method="post" action="{{ route('supplier-payment-amendment.filter') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-inline">
                          <div class="form-group">
                            <label>From : </label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                          </div>
                          <div class="form-group">
                            <label>To : </label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                          </div>
                          <div class="form-group">
                            <input type="submit" name="search" value="Search" class="btn btn-success btn-md">
                          </div>
                        </div>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-md-12">
              @if(!empty($start_date) && !empty($end_date))
                <center><h4>From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
              @else
                <center><h4>Today : {{date('d-m-Y')}}</h4></center>
              @endif
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive table-hover"> 
                  <thead> 
                    <tr> 
                      <th>{{ __('messages.SL') }}</th>
                      <th>{{ __('messages.date') }}</th>
                      <th>{{ __('messages.name') }}</th>
                      <th>{{ __('messages.email') }}</th>
                      <th>{{ __('messages.phone') }}</th>
                      <th>{{ __('messages.address') }}</th>
                      <th>{{ __('messages.amount') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;
                      $total = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++; 
                        $total += $data->amount;
                      ?>
                    <tr> 
                      <td>
                        {{$currentNumber++}}
                      </td>
                      <td>{{$data->date}}</td>
                      <td><a href="{{$baseUrl.'/'.config('app.supplier').'/supplier-ledger/'.$data->supplier_id}}" target="_blank">{{$data->ledger_supplier_object->name}}</a></td>
                      <td>{{$data->ledger_supplier_object->email}}</td>
                      <td>{{$data->ledger_supplier_object->phone}}</td>
                      <td>{{$data->ledger_supplier_object->address}}</td>
                      <td>{{$data->amount}}</td>
                      <td>
                        {{Form::open(array('route'=>['supplier-payment-amendment.destroy',$data->tok],'method'=>'DELETE'))}}
                          <button type="submit" confirm="Are you sure you want to delete ?" class="btn btn-danger btn-xs confirm" title="Delete" style="padding: 1px 9px;">Delete</button>
                        {!! Form::close() !!}
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="8" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="7" style="text-align: center;"><b>Total</b></td>
                      <td><b>{{round($total,2)}}</b></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                  {{$alldata->render()}}
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <div class="box-footer"></div>
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
@endsection 