@extends('layouts.layout')
@section('title', 'Damage Request Details')
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
                <!-- Card start -->
                <div class="card">
                    <div class="card-header-lg">
                        <h4>User Damage Request Details</h4>
                        <div class="text-start">
                            {{-- @if($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Pending")
                            <a href="{{route('damagerequests.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @elseif($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                            <a href="{{route('damagerequests.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @endif

                            @if(! $single_data->isOwner() && ! $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                            <a href="{{route('damagerequests.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @endif --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="invoice-container">
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                        <address class="m-0">
                                           {{$single_data->user->name}},<br>
                                           {{$single_data->user->designation->title}},<br>
                                           {{$single_data->user->department->title}},<br>
                                           {{$single_data->user->email}}
                                        </address>
                                        <div class="invoice-num">
                                            <div>Damage request - #{{$single_data->id}}</div>
                                            <div>{{date('d F Y h:i A',strtotime($single_data->date))}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Serial</th>
                                                    <th>Product Name</th>
                                                    <th>Product Type</th>
                                                    <th>Product Category</th>
                                                    <th>Product Unit</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php $sl = 0;?>
                                              @foreach( $alldata as $data)
                                              <?php $sl++;?>
                                                <tr>
                                                    <td>{{$sl}}</td>
                                                    <td>{{$data->product->name}}</td>
                                                    <td>{{$data->product->type->name}}</td>
                                                    <td>{{$data->product->category->name}}</td>
                                                    <td>{{$data->product->unit->name}}</td>
                                                    <td>{{$data->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="6" style="text-align:center"> Requisition Review </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                             <!-- Row end -->
                            <!-- Row start -->
                                <!-- Row start -->
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-start">
                                        @if($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Pending")
                                            <button class="btn btn-primary" onclick="changeStatus('Published')">Publish</button>
                                        @elseif($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                                        <button class="btn btn-primary"  onclick="changeStatus('Pending')">Un Publish</button>  
                                        @endif

                                        @if(! $single_data->isOwner() && ! $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                                            <button onclick="changeStatus('Approver')" class="btn btn-primary">Accept</button>
                                            <button class="btn btn-light ms-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Decline</button>
                                            <!-- Modal start -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Decline Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">
                                                            @csrf
                                                            <!-- Row start -->
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <!-- Field wrapper start -->
                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <textarea name="message" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="field-placeholder">Message<span class="text-danger">*</span></div>
                                                                </div>
                                                                <!-- Field wrapper end -->
                                                                </div>
                                                            </div>
                                                            <!-- Row end -->
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" onclick="changeStatus('Pending')" class="btn btn-primary">Submit</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
										    <!-- Modal end -->
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                    </div>
                </div>
                <!-- Card end -->
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- Content wrapper end -->

    <form id="status_update_form"
        action="{{route('damagerequests.statusUpdate',$single_data->id)}}"
        method="POST"
        style="display: none;">
      @csrf()
      @method('put')
      <input id="status" type="hidden" name="status" >
  </form>

    @endsection

    @push('custom_script')
    <script>
        function changeStatus(status){
            form = document.getElementById('status_update_form')
            field = document.getElementById('status')
            field.value = status
            form.submit()
        }

    </script>
    @endpush