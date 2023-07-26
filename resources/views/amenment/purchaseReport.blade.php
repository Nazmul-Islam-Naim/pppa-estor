@extends('layouts.layout')
@section('title', 'Purchase')
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
    </div>
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">{{ __('home.Search_Area') }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="post" action="{{ route('purchase-product-amendment.filter') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-inline">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="field-wrapper">
                        <div class="input-group">
                          <input class="form-control datepicker" type="text" name="start_date" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                        </div>
                        <div class="field-placeholder">From </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="field-wrapper">
                        <div class="input-group">
                          <input class="form-control datepicker" type="text" name="end_date" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                        </div>
                        <div class="field-placeholder">To </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="field-wrapper">
                        <div class="input-group">
                          <input type="submit" value="Search" class="btn btn-info btn-md">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Pruchse List</h3>
                
            <a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:30px;" src='{{asset("custom/img/print.png")}}'></a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12" id="printTable">
              <center><h5 style="margin: 0px">Pruchse List</h5></center>
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                <center><h6 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h6></center>
                @else
                <center><h6 style="margin: 0px">Date : {{date('d-m-Y')}}</h6></center>
                @endif
                <table class="" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">  
                  <thead> 
                    <tr style="background: #ccc;"> 
                    <tr> 
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Date</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Price</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Action</th>
                    </tr>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 250; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $totalPrice = 0;
                      $totalQuantity = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                        $price = 0;
                        $quantity = 0;
                      ?>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        {{$currentNumber++}}
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->purchase_date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->productpurchase_supplier_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->productpurchase_product_object->name}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          echo $quantity = $data->ttlQnty;
                          $totalQuantity += $quantity;
                        ?>
                      </td>
                     <!-- <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->ttlPrice}}</td>-->
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                        <?php
                          echo $price = $data->ttlPrice;
                          $totalPrice += $price;
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                          <a href="{{URL::To('amendment/delete-purchase-products', $data->tok)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure?')">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                    @if($rowCount==0)
                      <tr>
                        <td colspan="6" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tfoot> 
                    <tr> 
                      <td colspan="4" style="border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($totalQuantity, 2)}}</b></td>
                      
                      <td style="border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($totalPrice, 2)}}</b></td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"></td>
                    </tr>
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                  {{$alldata->render()}}
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 