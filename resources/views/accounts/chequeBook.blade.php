@extends('layouts.layout')
@section('title', 'Cheque Book')
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
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">{{ __('menu.add_cheque_book') }}</h3>
          </div>
          <!-- /.card-header -->
          {!! Form::open(array('route' =>['cheque-book.store'],'method'=>'POST')) !!}
          <div class="card-body">
            <div class="field-wrapper">
              <div class="input-group">
                <input class="form-control" type="text" name="name" value="" required="" autocomplete="off">
              </div>
              <div class="field-placeholder">{{ __('menu.cheque_name') }} <span class="text-danger">*</span></div>
            </div>
            <div class="field-wrapper">
              <div class="input-group">
                <select name="bank" class="form-control select2" required> 
                  <option value="">--Select--</option>
                  @foreach($allbank as $bank)
                  <option value="{{encrypt($bank->id)}}">{{$bank->bank_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="field-placeholder">{{ __('menu.bank_name') }} <span class="text-danger">*</span></div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">{{ __('menu.cheque_book_list') }}</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="basicExample" class="table custom-table">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>{{ __('menu.cheque_name') }}</th>
                    <th>{{ __('menu.bank_name') }}</th>
                    <th>{{ __('home.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php                           
                    $number = 1;
                    $numElementsPerPage = 10; // How many elements per page
                    $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                    $rowCount = 0;
                  ?>
                  @foreach($alldata as $data)
                  <?php $rowCount++; ?>
                  <tr>
                    <td>{{$currentNumber++}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->chequebook_bank_object->bank_name??''}}</td>
                    <td>
                      <div class="actions" style="height: 25px">
                        <a href="#editModal{{$data->id}}" data-bs-toggle="modal" style="padding: 1px 15px"><i class="icon-edit1 text-info"></i></a>
                        {{Form::open(array('route'=>['cheque-book.destroy',encrypt($data->id)],'method'=>'DELETE'))}}
                          <button type="submit" class="btn btn-default btn-xs confirmdelete" confirm="You want to delete this informations ?" title="Delete" style="width: 100%"><i class="icon-x-circle text-danger"></i></button>
                        {!! Form::close() !!}
                      </div>

                      <!-- Start Modal for edit cheque book -->
                      <div class="modal fade" id="editModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Cheque Book</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            {!! Form::open(array('route' =>['cheque-book.update', encrypt($data->id)],'method'=>'PUT')) !!}
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="field-wrapper">
                                    <div class="input-group">
                                      <input class="form-control" type="text" name="name" value="{{$data->name}}" required="" autocomplete="off">
                                    </div>
                                    <div class="field-placeholder">Name <span class="text-danger">*</span></div>
                                  </div>
                                  <div class="field-wrapper">
                                    <div class="input-group">
                                      <select name="bank" class="form-control select2" required> 
                                        <option value="">Select</option>
                                        @foreach($allbank as $bank)
                                        <option value="{{encrypt($bank->id)}}" {{(($bank->id)==($data->bank))? 'selected':''}}>{{$bank->bank_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="field-placeholder">Bank <span class="text-danger">*</span></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                              {{Form::submit('Update',array('class'=>'btn btn-success btn-sm', 'style'=>'width:15%'))}}
                            </div>
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                      <!-- End Modal for edit cheque book -->
                    </td>
                  </tr>
                  @endforeach
                  @if($rowCount==0)
                  <tr>
                    <td colspan="4" align="center">
                      <h4 style="color: #ccc">No Data Found . . .</h4>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
          </div>
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