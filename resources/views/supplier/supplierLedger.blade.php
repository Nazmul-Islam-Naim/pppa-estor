@extends('layouts.layout')
@section('title', 'Ledger')
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
              <form method="post" action="{{ route('supplier-ledger.filter', $singledata->id) }}" autocomplete="off">
              @csrf
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

                          <input type="hidden" name="bank_id" value="{{$singledata->id}}">
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
            <h3 class="card-title">{{ __('home.ledger') }}</h3>
                
            <a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:30px;" src='{{asset("custom/img/print.png")}}'></a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12" id="printTable">
              <center><h5 style="margin: 0px">Supplier Info</h5></center>
              <div class="table-responsive">
              <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->name}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Supplier ID</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->supplier_id}}</td>
                    </tr>
                    <tr> 
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Email</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->email}}</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Phone</td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">{{$singledata->phone}}</td>
                    </tr>
                  </thead>
                </table>
              </div>
              <br>
              <center><h5 style="margin: 0px">{{ __('menu.Transaction_Info') }}</h5></center>
              <div class="table-responsive">
              @if(!empty($start_date) && !empty($end_date))
                  <center><h4 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h4></center>
                @else
                  <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
                @endif
                <table style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0"> 
                  <thead> 
                    <tr style="background: #ccc;">
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Date</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Reason</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Bill</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Paid</th>
                      <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Balance</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php                           
                      $number = 1;
                      $numElementsPerPage = 15; // How many elements per page
                      $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                      $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                      $rowCount = 0;

                      $credit = 0;
                      $debit = 0;
                      $sum = 0;
                    ?>
                    @foreach($alldata as $data)
                      <?php 
                        $rowCount++;
                      ?>
                    <tr>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{dateFormateForView($data->date)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/purchase/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum+$data->amount;
                            $credit = $credit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">
                        <?php
                          $reasons = $data->reason;

                          if(preg_match("/payment/", $reasons)) {
                            echo $data->amount;
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                        ?>
                      </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($sum, 2)}}</td>
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
                    
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">
                {{ $alldata->appends(Request::except('page'))->links('pagination::bootstrap-4') }}
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

<script type="text/javascript">
  <?php
    $siteInfo = DB::table('site_settings')->where('id', 1)->first();
    $header = '';
    $logo = '';
    if (!empty($siteInfo)) {
      $logo = '../public/storage/app/public/uploads/logo/'.$siteInfo->image;

      $header = '<td width="20%"><img src="'.$logo.'" width="70px" height="70px"></td><td width="80%"><center><h3 style="margin:0; padding:0; margin-bottom: 0px">'.$siteInfo->company_name.'</h3>'.$siteInfo->address.'<br> Mobile : '.$siteInfo->phone.', Email : '.$siteInfo->email.'</center></td>';
    }
  ?>

  function PrintElem(elem)
  {
    Popup($(elem).html());
  }

  function Popup(data) 
  {   
    var mywindow = window.open('', 'my div', 'height=1000,width=1000');
    var is_chrome = Boolean(mywindow.chrome);
    mywindow.document.write('<html><head><title>Binary IT</title><style>a {text-decoration:none;}</style>');

    var Header = '<?php echo $header;?>';

    mywindow.document.write('<table width="80%" style="margin-left: auto; margin-right: auto"><tr>'+Header+'</tr></table><br>');
    
    mywindow.document.write('</head><body>');
    mywindow.document.write('<center><u><span style="font-weight: bold; font-size: 15px">Customer Ledger</span></u><center>');    
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
      
    if (is_chrome) {
      setTimeout(function() { // wait until all resources loaded 
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10
      mywindow.print(); // change window to winPrint
      mywindow.close(); // change window to winPrint
      }, 500);
    } else {
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10

      mywindow.print();
      mywindow.close();
    }
    return true;
  }
</script>
@endsection 