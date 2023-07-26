@extends('layouts.layout')
@section('title', 'Product')
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
          {!! Form::open(array('route' =>['product.update', encrypt($single_data->id)],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Edit";?>
        @else
        {!! Form::open(array('route' =>['product.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}}  {{ __('menu.Product') }}</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input class="form-control" type="text" name="name" value="{{(!empty($single_data->name))?$single_data->name:''}}" required="" autocomplete="off">
                  </div>
                  <div class="field-placeholder">{{ __('home.name') }} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select name="product_type_id" class="form-control select2" required> 
                      <option value="">Select</option>
                      @foreach($alltype as $type)
                      <option value="{{encrypt($type->id)}}" {{!empty($single_data) && ($type->id==$single_data->product_type_id) ? 'selected':''}}>{{$type->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">{{__('menu.Product_Type')}} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select name="product_category_id" class="form-control select2" required> 
                      <option value="">Select</option>
                      @foreach($allcategory as $category)
                      <option value="{{encrypt($category->id)}}" {{!empty($single_data) && ($category->id==$single_data->product_category_id) ? 'selected':''}}>{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">Product Category <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select name="product_sub_category_id" class="form-control select2" required> 
                      <option value="">Select</option>
                      @foreach($allsubcategory as $subcategory)
                      <option value="{{($subcategory->id)}}" {{!empty($single_data) && ($subcategory->id==$single_data->product_sub_category_id) ? 'selected':''}}>{{$subcategory->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">Product Sub Category<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select name="product_unit_id" class="form-control select2" required> 
                      <option value="">Select</option>
                      @foreach($allunit as $unit)
                      <option value="{{encrypt($unit->id)}}" {{!empty($single_data) && ($unit->id==$single_data->product_unit_id)? 'selected':''}}>{{$unit->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">{{__('menu.Product_Unit')}} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select name="product_brand_id" class="form-control select2" required> 
                      <option value="">Select</option>
                      @foreach($allbrand as $brand)
                      <option value="{{encrypt($brand->id)}}" {{!empty($single_data) && ($brand->id==$single_data->product_brand_id)? 'selected':''}}>{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">{{__('menu.Product_Brand')}} <span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input type="number" name="stock_notify" value="{{(!empty($single_data)) ? $single_data->stock_notify : ''}}" class="form-controll" required="" autocomplete="off">
                  </div>
                  <div class="field-placeholder">Stock Notify<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <textarea name="note" style="height:40px">{{(!empty($single_data)) ? $single_data->note : ''}}</textarea>
                  </div>
                  <div class="field-placeholder">Note</div>
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
@endsection 