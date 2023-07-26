@extends('layouts.layout')
@section('title', 'Bank Account')
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
            <div class="card-title">{{ __('menu.bank_account') }}</div>
            <a href="javascript:void(0)" class="btn btn-sm btn-warning pull-right" data-bs-toggle="modal" data-bs-target="#myModal"><i class="icon-plus-circle"></i> <b>{{ __('menu.add_bank') }}</b></a>
          </div>
          <div class="card-body">
            <!-- <div class="table-responsive"> -->
              <table id="dataTable" class="table v-middle">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>{{ __('menu.bank_name') }}</th>
                    <th>{{ __('menu.account_name') }}</th>
                    <th>{{ __('menu.account_no') }}</th>
                    <th>{{ __('menu.account_type') }}</th>
                    <th>{{ __('menu.branch') }}</th>
                    <th>{{ __('home.status') }}</th>
                    <th>{{ __('home.amount') }}</th>
                    <th width="40px">{{ __('home.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php                           
                    $number = 1;
                    $numElementsPerPage = 15; // How many elements per page
                    $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                    $rowCount = 0;
                    $sum = 0;
                  ?>
                  @foreach($alldata as $data)
                  <?php $rowCount++; $sum += $data->balance;?>
                  <tr>
                    <td>{{$currentNumber++}}</td>
                    <td><a href="{{$baseUrl.'/'.config('app.account').'/bank-report/'.encrypt($data->id)}}">{{$data->bank_name}}</a></td>
                    <td>{{$data->account_name}}</td>
                    <td>{{$data->account_no}}</td>
                    <td><span class="label label-success">{{$data->bankaccount_accounttype_object->name ?? ''}}</span></td>
                    <td>{{$data->bank_branch}}</td>
                    <td>
                      @if ($data->status == 1)
                      <span class="badge bg-primary">Active</span>
                      @elseif ($data->status == 0)
                      <span class="badge bg-warning">Inactive</span>
                      @endif
                    </td>
                    <td>{{$data->balance}}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="margin: 3px 15px;">Action</button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{$baseUrl.'/'.config('app.account').'/bank-deposit/'.encrypt($data->id)}}">Deposit</a></li>
                          <li><a class="dropdown-item" href="{{$baseUrl.'/'.config('app.account').'/amount-withdraw/'.encrypt($data->id)}}">Withdraw</a></li>
                          <li><a class="dropdown-item" href="{{$baseUrl.'/'.config('app.account').'/amount-transfer/'.encrypt($data->id)}}">Transfer</a></li>
                          <li><a class="dropdown-item" href="{{$baseUrl.'/'.config('app.account').'/bank-report/'.encrypt($data->id)}}">Report</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="#editModal{{$data->id}}" data-bs-toggle="modal">Edit</a></li>
                          <li>
                          {{Form::open(array('route'=>['bank-account.destroy',encrypt($data->id)],'method'=>'DELETE'))}}
                          <button type="submit" class="btn btn-default btn-xs confirmdelete" confirm="You want to delete this informations ?" title="Delete" style="width: 100%">Delete</button>
                          {!! Form::close() !!}
                          </li>
                        </ul>
                      </div>

                      <!-- Start Modal for edit bank -->
                      <div class="modal fade" id="editModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><i class="fa fa-edit"></i> {{ __('menu.update_bank') }}</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            {!! Form::open(array('route' =>['bank-account.update', encrypt($data->id)],'method'=>'PUT')) !!}
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <input type="text" name="bank_name" autocomplete="off" class="form-control" value="{{$data->bank_name}}" required="">
                                    <div class="field-placeholder">{{ __('menu.bank_name') }}</div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <input type="text" name="account_name" autocomplete="off" class="form-control" value="{{$data->account_name}}" required="">
                                    <div class="field-placeholder">{{ __('menu.account_name') }}</div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <input type="text" name="account_no" autocomplete="off" class="form-control" value="{{$data->account_no}}" required="">
                                    <div class="field-placeholder">{{ __('menu.account_no') }}</div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <select class="form-select" id="formSelect" name="account_type" required="">
                                      <option value="">Select</option>
                                      @foreach($allaccounttype as $type)
                                      <option value="{{encrypt($type->id)}}" {{($type->id==$data->account_type)? 'selected':''}}>{{$type->name}}</option>
                                      @endforeach
                                    </select>
                                    <div class="field-placeholder">{{ __('menu.account_type') }}</div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <input type="text" name="bank_branch" autocomplete="off" class="form-control" value="{{$data->bank_branch}}" required="">
                                    <div class="field-placeholder">{{ __('menu.branch') }}</div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="field-wrapper">
                                    <?php
                                      // getting bank opening balance
                                      $openingBalance = DB::table('transaction_reports')->where('bank_id', $data->id)->where('reason', 'LIKE', '%' . 'Opening Balance' . '%')->first();
                                    ?>
                                    <input type="text" name="new_opening_balance" autocomplete="off" class="form-control decimal" value="{{$openingBalance->amount}}" required="">
                                    <div class="field-placeholder">{{ __('menu.opening_amount') }}</div>
                                    <input type="hidden" name="bank_balance" value="{{$data->balance}}">
                                    <input type="hidden" name="old_opening_balance" value="{{$openingBalance->amount}}">
                                  </div>
                                </div>
                                <div class="col-md-6">  
                                  <div class="field-wrapper">
                                    <input type="text" name="opening_date" autocomplete="off" class="form-control datepicker" value="{{$data->opening_date}}" required="">
                                    <div class="field-placeholder">{{ __('home.date') }}</div>
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
                      <!-- End Modal for edit bank -->
                    </td>
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
                    <td colspan="7"><center><b>{{ __('home.total') }}</b></center></td>
                    <td><b>{{number_format($sum, 2)}}</b></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->

<!-- Modal start -->
<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-plus-circle"></i> {{ __('menu.add_bank') }}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      {!! Form::open(array('route' =>['bank-account.store'],'method'=>'POST')) !!}
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="text" name="bank_name" autocomplete="off" class="form-control" placeholder="Bank Name" required="">
              <div class="field-placeholder">{{ __('menu.bank_name') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="text" name="account_name" autocomplete="off" class="form-control" placeholder="Account Name" required="">
              <div class="field-placeholder">{{ __('menu.account_name') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="text" name="account_no" autocomplete="off" class="form-control" placeholder="Account Number" required="">
              <div class="field-placeholder">{{ __('menu.account_no') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <select class="form-select" id="formSelect" name="account_type" required="">
                <option value="">Select</option>
                @foreach($allaccounttype as $type)
                <option value="{{encrypt($type->id)}}">{{$type->name}}</option>
                @endforeach
              </select>
              <div class="field-placeholder">{{ __('menu.account_type') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="text" name="bank_branch" autocomplete="off" class="form-control" placeholder="Branch" required="">
              <div class="field-placeholder">{{ __('menu.branch') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="text" name="opening_balance" autocomplete="off" class="form-control decimal" placeholder="Opening Balance" required="">
              <div class="field-placeholder">{{ __('menu.opening_amount') }}</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="field-wrapper">
              <input type="date" name="opening_date" autocomplete="off" class="form-control" value="{{date('Y-m-d')}}" required="">
              <div class="field-placeholder">{{ __('home.date') }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        {{Form::submit('Save',array('class'=>'btn btn-primary btn-sm', 'style'=>'width:15%'))}}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- Modal end -->                    
@endsection 