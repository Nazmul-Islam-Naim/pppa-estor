@extends('layouts.layout')
@section('title', 'Books')
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
        @if(!empty($single_data))
          {!! Form::open(array('route' =>['asset.update', $single_data->id],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Update";?>
        @else
        {!! Form::open(array('route' =>['asset.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}} Books </div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="text" name="name" value="{{(!empty($single_data->name))?$single_data->name:''}}" required="" autocomplete="off">
                  </div>
                  <div class="field-placeholder">Name<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="number" name="quantity" value="{{(!empty($single_data->quantity))?$single_data->quantity:''}}" required="" autocomplete="off">
                  </div>
                  <div class="field-placeholder">Quantity<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                   <select name="asset_type_id" id="asset_type_id" class="form-control">
                    <option value="">Select</option>
                    @foreach( $alltype as $type )
                    <option value="{{$type->id}}" {{(!empty($single_data) && ($single_data->asset_type_id == $type->id)) ? 'selected' : ''}}>{{$type->name}}</option>
                    @endforeach
                   </select>
                  </div>
                  <div class="field-placeholder">Books Type<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                   <select name="asset_sub_type_id" id="asset_sub_type_id" class="form-control">
                    @if(!empty($single_data))
                    <option value="">Select</option>
                    @foreach( $allsubtype as $subtype )
                    <option value="{{$subtype->id}}" {{(!empty($single_data) && ($single_data->asset_sub_type_id == $subtype->id)) ? 'selected' : ''}}>{{$type->name}}</option>
                    @endforeach
                    @endif
                   </select>
                  </div>
                  <div class="field-placeholder">Books Sub Type<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="text" name="writter" value="{{(!empty($single_data->writter))?$single_data->writter:''}}" required="" autocomplete="off">
                  </div>
                  <div class="field-placeholder">Writter<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                 <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="file" name="image" value="{{(!empty($single_data->image))?$single_data->image:''}}" autocomplete="off">
                  </div>
                  <div class="field-placeholder">Image</div>
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
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
{!!Html::script('custom/yajraTableJs/jquery.js')!!}
<script>
// dependancy dropdown using ajax
$(document).ready(function() {
  $('#asset_type_id').on('change', function() {
    var typeId = $(this).val();
    if(typeId) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        //url: "{{URL::to('find-chequeno-with-chequebook-id')}}",
        url: "{{$baseUrl.'/'.config('app.asset').'/get-asset-sub-type'}}",
        data: {
          'id' : typeId
        },
        dataType: "json",

        success:function(data) {
          // console.log(data);
          if(data){
            $('#asset_sub_type_id').empty();
            $('#asset_sub_type_id').focus;
            $('#asset_sub_type_id').append('<option value="">Select</option>');
            $.each(data, function(key, value){
              //console.log(data);
              $('select[name="asset_sub_type_id"]').append('<option value="'+ value.id +'">' + value.name+ '</option>');
            });
          }else{
            $('#asset_sub_type_id').empty();
          }
        }
      });
    }else{
      $('#asset_sub_type_id').empty();
    }
  });
});
</script>
@endsection 