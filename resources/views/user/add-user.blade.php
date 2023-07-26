@extends('layouts.layout')
@section('title', 'Add/Edit User')
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
    </div>
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          @if(!empty($single_data))
          {!! Form::open(array('route' =>['user-list.update',$single_data->id],'method'=>'PUT','files'=>true)) !!}
          <?php $btn='Update';?>
          @else
          {!! Form::open(array('route' =>['user-list.store'],'method'=>'POST','files'=>true)) !!}
          <?php $btn='Add';?>
          @endif
          <div class="card-header">
            <div class="card-title">{{$btn}} User</div>
            <a href="{{URL::to('/user/user-list')}}" class="btn btn-sm btn-warning pull-right"><i class="icon-corner-down-right"></i> <b>Back</b></a>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- name --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <input type="text" name="name" value="{{!empty($single_data->name)?$single_data->name:''}}">
                  <div class="field-placeholder">Name <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- role --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <select class="select-single js-states" name="role_id"   data-live-search="true" required="">
                    <option value="">Select</option>
                    @foreach($roles as $role)
                    <option value="{{$role->id}}" {{(!empty($single_data) && $single_data->role_id==$role->id)?'selected':''}}>{{$role->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Role<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- department --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <select class="select-single js-states" name="department_id"   data-live-search="true" required="">
                    <option value="">Select</option>
                    @foreach($departments as $department)
                    <option value="{{$department->id}}" {{(!empty($single_data) && $single_data->department_id==$department->id)?'selected':''}}>{{$department->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Department<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- designation --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <select class="select-single js-states" name="designation_id"   data-live-search="true" required="">
                    <option value="">Select</option>
                    @foreach($designations as $designation)
                    <option value="{{$designation->id}}" {{(!empty($single_data) && $single_data->designation_id==$designation->id)?'selected':''}}>{{$designation->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Designation<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- email --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <input type="email" name="email" value="{{!empty($single_data->email)?$single_data->email:''}}">
                  <div class="field-placeholder">Email <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- password --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <input type="text" name="password" class="form-controller">
                  <div class="field-placeholder">Password <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- confirm password --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <input type="text" name="password_confirmation" class="form-controller">
                  <div class="field-placeholder">Confirm Password <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- status --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <select name="status" class="form-control">
                    <option value="">Select</option>
                    <option value="1" {{!empty($single_data->status) && ($single_data->status == 1)? 'selected':''}}>Active</option>
                    <option value="0" {{!empty($single_data->status) && ($single_data->status == 0)? 'selected':''}}>In-Active</option>
                  </select>
                  <div class="field-placeholder">Status<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- Image --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                <div class="field-wrapper">
                  <input type="file" name="image" value="">
                  <div class="field-placeholder">Image</div>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">{{$btn}}</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection