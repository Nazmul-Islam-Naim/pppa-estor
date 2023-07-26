@extends('layouts.layout')
@section('title', 'Designation Wise Asset Edit Form')
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
                        <div class="card-title">Designation Wise Asset Permission Update</div>
                    </div>
                    {!! Form::open(array('route' =>['assign-asset.update',$single_data->id],'method'=>'PUT','files'=>true)) !!}
                    <div class="card-body">
                      <div class="col-md-12">
                          <div class="form-inline">
                            <div class="row">
                              <div class="col-md-4">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <select name="designation_id" class="form-control select2" required="" autocomplete="off">
                                      <option value="">Select</option>
                                      @foreach($alldesignation as $designation)
                                      <option value="{{$designation->id}}" {{($single_data->designation_id == $designation->id) ? 'selected' : ''}}>{{$designation->title}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="field-placeholder">Designation <span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <input class="form-control" type="date" name="date" value="{{(!empty($single_data->date)) ? $single_data->date : date('Y-m-d')}}" autocomplete="off" required="">
                                  </div>
                                  <div class="field-placeholder">Date <span class="text-danger">*</span></div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="field-wrapper">
                                  <div class="input-group">
                                    <textarea name="note" class="form-control" style="height:40px">{{(!empty($single_data)) ? $single_data->note : ''}}</textarea>
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
                                        <th>Asset</th>
                                        <th>Quantity</th>
                                        <th>Max Limit</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                <?php $row_num = 0; ?>
                                @foreach( $alldata as $data)
                                <?php $row_num++; ?>
                                    <tr id="row_{{$row_num}}">
                                        <td style="border: 1px solid #fff; width:50%">
                                            <select name="addmore[{{$row_num}}][asset_id]" id="item" onchange="typeAndSubType(this.value, <?php echo $row_num?>)" class="form-control select-single js-states select2 product_id"  data-live-search="true" required="">
                                              <option value="">Select Asset</option>
                                              @foreach($allasset as $asset)
                                              <option value="{{$asset->id}}" {{($data->asset_id == $asset->id) ? 'selected' : ''}}>{{$asset->name}}</option>
                                              @endforeach
                                            </select>
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control quantity_{{$row_num}}" value="{{$data->quantity}}"
                                                name="addmore[{{$row_num}}][quantity]" id="quantity" autocomplete="off">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <input type="number" step="any" class="form-control max_limit_{{$row_num}}" value="{{$data->quantity}}"
                                                name="addmore[{{$row_num}}][max_limit]" id="max_limit" autocomplete="off">
                                        </td>
                                        <td style="border: 1px solid #fff">
                                            <textarea name="addmore[{{$row_num}}][des]"  class="form-control des_{{$row_num}}" id="des" style="height:40px" autocomplete="off">{{$data->des}}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align:right">
                              <button type="submit" class="btn btn-primary">Update</button>
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
        row += ' <select name="addmore['+i+'][asset_id]" id="item" onchange="unitAndStock(this.value, '+i+')" class="form-control select2" required="">';
        row += ' <option value="">Select Asset</option>';
        row += ' @foreach($allasset as $asset)';
        row += ' <option value="{{$asset->id}}">{{$asset->name}}</option>';
        row += ' @endforeach';
        row += ' </select>';
        row += '</td>';
        row += '<td>';
        row += ' <input type="text" step="any" class="form-control asset_type_id_' + i +'" name="addmore[' + i +'][asset_type_id]" id="asset_type_id" readonly="">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="text" step="any" class="form-control asset_sub_type_id_' + i +'" name="addmore[' + i +'][asset_sub_type_id]" id="asset_sub_type_id" readonly="">';
        row += '</td>';
        row += '<td>';
        row += ' <input type="number" step="any" class="form-control quantity_' + i +'" name="addmore[' + i +'][quantity]" id="quantity" autocomplete="off">';
        row += '</td>';
        row += '<td>';
        row += ' <textarea name="addmore[' + i +'][des]" class="form-control des_' + i +'" id="des" style="height:40px" autocomplete="off"></textarea>';
        row += '</td>';
        row += '<td>';
        row += ' <input type="button" class="form-control" value="x" id="remove" onclick="$(\'#row_' +i + '\').remove();">';
        row += '</td>';
        row += '</tr>';
        $('#body').append(row);
        $('.select2').select2();
    });
});

//------------------- asset type and sub type -------------------//
function typeAndSubType(assetid,row) {
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('find-chequeno-with-chequebook-id')}}",
        url: "{{$baseUrl.'/'.config('app.asset').'/get-asset-type'}}",
        data: {
        'id' : assetid
        },
        dataType: "json",

        success:function(data) {
            $('.asset_type_id_'+row).empty();
            $('.asset_sub_type_id_'+row).empty();
            $('.asset_type_id_'+row).focus;
            $('.asset_sub_type_id_'+row).focus;
            $('.asset_type_id_'+row).val(data.type.name);
            $('.asset_sub_type_id_'+row).val(data.subtype.name);

        }
    });
}

</script>
<!-- Content wrapper scroll end -->
@endsection