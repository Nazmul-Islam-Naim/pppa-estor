@extends('layouts.layout')
@section('title', 'Purchase Product')
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
                    <div class="card-header">
                        <div class="card-title">Purchase Product</div>
                    </div>
                    {!! Form::open(array('route' =>['product-purchase.store'],'method'=>'POST','files'=>true)) !!}
                    <div class="card-body">
                      <div class="col-md-12">
                          <div class="form-inline">
                            <div class="row">
                              <div class="col-md-3">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <select name="supplier_id" class="form-control" required="">
                                        <option value="">Select</option>
                                        @foreach($allsupplier as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="field-placeholder">Supplier <span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <select name="tender_number" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Open Purchase">Open Purchase</option>
                                        <option value="Tender">Tender</option>
                                    </select>
                                  </div>
                                  <div class="field-placeholder">Purchase Type<span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <input class="form-control" type="date" name="date" value="<?php echo date('Y-m-d');?>" autocomplete="off" required="">
                                  </div>
                                  <div class="field-placeholder">Date <span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <textarea name="note" class="form-control" style="height:40px"></textarea>
                                  </div>
                                  <div class="field-placeholder">Note </div>
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
                                        <th>Previous Stock</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                <?php $row_num = 1; ?>
                                    <tr id="row_{{$row_num}}">
                                        <td style="border: 1px solid #fff; width:30%">
                                            <select name="addmore[{{$row_num}}][product_id]" id="item" onchange="unitAndStock(this.value, <?php echo $row_num?>)" class="form-control select-single js-states select2 product_id" data-live-search="true" required="">
                                              <option value="">Select Product</option>
                                              @foreach($allproduct as $product)
                                              <option value="{{$product->id}}">{{$product->name}}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control previous_stock_{{$row_num}}"
                                                name="addmore[{{$row_num}}][previous_stock]" id="previous_stock" readonly="">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="text" step="any" class="form-control unit_{{$row_num}}"
                                                name="addmore[{{$row_num}}][unit]" id="unit" readonly="">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control"
                                                name="addmore[{{$row_num}}][quantity]" id="quantity"
                                                onkeyup="vlaueChanger(this.value,unit_price.value,1)">
                                        </td>
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control"
                                                name="addmore[{{$row_num}}][unit_price]" id="unit_price"
                                                onkeyup="vlaueChanger(quantity.value,this.value,1)">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control" name="rtotal[]"
                                                id="rtotal{{$row_num}}" readonly="">
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Sub Total</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="subtotal" id="subtotal" readonly="">
                                        </td>
                                        <td>
                                            <input type="button" class="form-control" value="+" id="addone">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Discount</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="discount" id="discount" autocomplete="off" onkeyup="discountAmount()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Vat</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="vat" id="vat" autocomplete="off" onkeyup="vatAmount()">
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Grand Total</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="grandTotal" id="grandTotal" readonly="">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Paid Amount</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="paid_amount" id="paid_amount" autocomplete="off" onkeyup="paidAmount()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            <b>Due Amount</b>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="due_amount" id="due_amount" readonly="">
                                        </td>
                                    </tr> -->
                                </tfoot>
                            </table>
                            <div style="text-align:right">
                              <button type="submit" class="form-control">submit</button>
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

{!!Html::script('custom/js/jquery.min.js')!!}
<script type="text/javascript">
$(document).ready(function() {
    var i = 1;
    $("#addone").on('click', function() {
        i++;
        var row = '<tr id="row_' + i + '">';
        row += '<td>';
        row += ' <select name="addmore['+i+'][product_id]" id="item" onchange="unitAndStock(this.value, '+i+')" class="form-control select2" data-live-search="true" required="">';
        row += ' <option value="">Select Product</option>';
        row += ' @foreach($allproduct as $product)';
        row += ' <option value="{{$product->id}}">{{$product->name}}</option>';
        row += ' @endforeach';
        row += ' </select>';
        row += '</td>';
        row += '<td>';
        row += ' <input type="number" step="any" class="form-control previous_stock_' + i +'" name="addmore[' + i +'][previous_stock]" id="previous_stock" readonly="">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="text" step="any" class="form-control unit_' + i +'" name="addmore[' + i +'][unit]" id="unit" readonly="">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="number" step="any" class="form-control" name="addmore[' + i +'][quantity]" id="quantity' + i + '" onkeyup="vlaueChanger(this.value, unit_price'+i+'.value,' + i + ')">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="number" step="any" class="form-control" name="addmore[' + i +'][unit_price]" id="unit_price' + i + '" onkeyup="vlaueChanger(quantity'+i+'.value, this.value,' + i + ')">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="number" step="any" class="form-control" name="rtotal[]" id="rtotal' + i +'" readonly="">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="button" class="form-control" value="x" id="remove" onclick="$(\'#row_' +i + '\').remove();subTotal()">';
        row += '</td>';
        row += '</tr>';
        $('#body').append(row);
        $('.select2').select2();
    });
});

//------------------- oproduct wise unit and stock -------------------//
function unitAndStock(productid,row) {
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('find-chequeno-with-chequebook-id')}}",
        url: "{{$baseUrl.'/'.config('app.product').'/get-product-unit'}}",
        data: {
        'id' : productid
        },
        dataType: "json",

        success:function(data) {
            $('.unit_'+row).empty();
            $('.previous_stock_'+row).empty();
            $('.unit_'+row).focus;
            $('.previous_stock_'+row).focus;
            $('.unit_'+row).val(data.unitname.name);
            $('.previous_stock_'+row).val(((data.previousstock) != null ) ? data.previousstock.quantity: 0);

        }
    });
}

function vlaueChanger(a,b,i) {
    var rowCount = parseInt(document.getElementById('myTableID').tBodies[0].rows.length);
    var x,y;
    x = parseFloat(a);
    y = parseFloat(b);
    if (isNaN(x) || isNaN(y)) {
        document.getElementById('rtotal' + i + '').value = 0;
        document.getElementById('subtotal').value = 0;
    } else {
        document.getElementById('rtotal' + i + '').value = x * y;
    }
    // when change the value of input field calculate new row total and make new sub total and grand total with vat and discount
    subTotal();
}
// for calculate subtotal if a row delete or create 
function subTotal() {
    var discount, vat, subtotal,paid, grandTotal;
    var arr = document.getElementsByName('rtotal[]');
    var tot = 0;
    for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value))
            tot += parseInt(arr[i].value);
    }
    document.getElementById('subtotal').value = tot;
    // discount and vat calculation
    // discount = parseFloat(document.getElementById('discount').value);
    // vat = parseFloat(document.getElementById('vat').value);
    // paid = parseFloat(document.getElementById('paid_amount').value);
    // if (isNaN(discount)) {
    //     discount = 0;
    // }
    // if (isNaN(vat)) {
    //     vat = 0;
    // }
    // if (isNaN(paid)) {
    //     paid = 0;
    // }
    // grandTotal = tot - discount + vat;
    grandTotal = tot;
    document.getElementById('grandTotal').value = grandTotal;
    // document.getElementById('due_amount').value = grandTotal - paid;
}
// for changing the discount it will calculate grandtotal agian
// function discountAmount() {
//     var subtotal, discount, vat,paid, grandTotal;
//     subtotal = parseFloat(document.getElementById('subtotal').value);
//     discount = parseFloat(document.getElementById('discount').value);
//     vat = parseFloat(document.getElementById('vat').value);
//     paid = parseFloat(document.getElementById('paid_amount').value);
//     if (isNaN(discount)) {
//         discount = 0;
//     }
//     if (isNaN(subtotal)) {
//         subtotal = 0;
//     }
//     if (isNaN(vat)) {
//         vat = 0;
//     }
//     if (isNaN(paid)) {
//       paid = 0;
//     }
//     grandTotal = subtotal - discount + vat;
//     document.getElementById('grandTotal').value = grandTotal;
//     document.getElementById('due_amount').value = grandTotal - paid;
// }
// for changing the vat it will calculate grandtotal again
// function vatAmount() {
//     var subtotal, discount, vat,paid, grandTotal;
//     subtotal = parseFloat(document.getElementById('subtotal').value);
//     discount = parseFloat(document.getElementById('discount').value);
//     vat = parseFloat(document.getElementById('vat').value);
//     paid = parseFloat(document.getElementById('paid_amount').value);
//     console.log(subtotal);
//     console.log(discount);
//     console.log(vat);
//     if (isNaN(discount)) {
//         discount = 0;
//     }
//     if (isNaN(subtotal)) {
//         subtotal = 0;
//     }
//     if (isNaN(vat)) {
//         vat = 0;
//     }
//     if (isNaN(paid)) {
//       paid = 0;
//     }
//     grandTotal = subtotal - discount + vat;
//     document.getElementById('grandTotal').value = grandTotal;
//     document.getElementById('due_amount').value = grandTotal - paid;
// }
// for changing the paid it will calculate due again
// function paidAmount() {
//     var subtotal, discount, vat,paid, grandTotal;
//     subtotal = parseFloat(document.getElementById('subtotal').value);
//     discount = parseFloat(document.getElementById('discount').value);
//     vat = parseFloat(document.getElementById('vat').value);
//     paid = parseFloat(document.getElementById('paid_amount').value);
//     console.log(subtotal);
//     console.log(discount);
//     console.log(vat);
//     if (isNaN(discount)) {
//         discount = 0;
//     }
//     if (isNaN(subtotal)) {
//         subtotal = 0;
//     }
//     if (isNaN(vat)) {
//         vat = 0;
//     }
//     if (isNaN(paid)) {
//       paid = 0;
//     }
//     grandTotal = subtotal - discount + vat;
//     document.getElementById('grandTotal').value = grandTotal;
//     document.getElementById('due_amount').value = grandTotal - paid;
// }
</script>
<!-- Content wrapper scroll end -->
@endsection