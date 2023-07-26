@extends('layouts.layout')
@section('title', 'Date Wise Stock Product Report')
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
              <h3 class="card-title">Date Wise Stock Product Report</h3>
            </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td style="text-align: center;">
                          <form method="post" action="{{route('date-wise-stock-filter')}}">
                          @csrf
                            <label for="">Date: </label>
                            <input class="datepicker" type="text" name="start_date" value="<?php echo date('Y-m-d');?>" autocomplete="off" required="">
                            <input type="submit" value="Filter" >
                          </form>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="col-md-12">
                @if(!empty($start_date))
                  <center><h4 style="margin: 0px">Date : {{dateFormateForView($start_date)}} </h4></center>
                @else
                  <center><h4 style="margin: 0px">Date : {{date('d-m-Y')}}</h4></center>
                @endif
                <div class="table-responsive">
                  <table class="table table-bordered " id="copy-print-csv" width="100%"> 
                    <thead> 
                      <tr> 
                        <th style="text-align: left">Sl</th>
                        <th style="text-align: left">Product</th>
                        <th style="text-align: left">Product Unit</th>
                        <th style="text-align: left">Previous Stock</th>
                        <th style="text-align: left">Purchase Quantity</th>
                        <th style="text-align: left">Stock Out Quantity</th>
                        <th style="text-align: left">Current Stock</th>
                        <!--<th style="text-align: left">Unit Price</th>-->
                        <!--<th style="text-align: left">Total</th>-->
                      </tr>
                    </thead>
                    <tbody> 
                      <?php                           
                        $number = 1;
                        $numElementsPerPage = 15; // How many elements per page
                        $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                        $rowCount = 0;

                        $totalQnty = 0;
                        $totalPrice = 0;
                      ?>
                      @foreach($alldata as $data)
                        <?php $rowCount++; ?>
                      <tr> 
                        <td>{{$currentNumber++}}</td>
                        <td>
                          <?php 
                              $productName = DB::table('products')->join('product_units', 'product_units.id', '=', 'products.product_unit_id')->where('products.id', $data['product_id'])->select('product_units.name as unitName','products.name')->first();
                              echo $productName->name;
                          ?> (<?php print_r($data['product_id']);?>)
                        </td>
                        <td><?php echo $productName->unitName;?></td>
                        <td><?php print_r($data['previous_qnty']);?></td>
                        <td><?php print_r($data['purchase_qnty']);?></td>
                        <td><?php print_r($data['sell_qnty']);?></td>
                        <td><?php print_r($data['quantity']);?></td>
                        <?php
                          
                        //   $totalPrice += $data['quantity']*$data['unit_price'];
                          $totalQnty += $data['quantity'];
                        ?>
                      </tr>
                      @endforeach
                      @if($rowCount==0)
                        <tr>
                          <td colspan="9" align="center">
                            <h4 style="color: #ccc">No Data Found . . .</h4>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr> 
                        <td colspan="6" style="text-align: center"><b>Total</b></td>
                        <td ><b>{{number_format($totalQnty,2)}}</b></td>
                        <!--<td></td>-->
                        <!--<td><b>{{number_format($totalPrice,2)}}</b></td>-->
                      </tr>
                    </tfoot>
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