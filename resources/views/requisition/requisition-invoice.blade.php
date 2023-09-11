@extends('layouts.layout')
@section('title', 'Requisition Details')
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
                <!-- Card start -->
                <div class="card">
                    <div class="card-header-lg">
                        <h4>User Requisition Details</h4>
                        <div class="text-start">
                            @if($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Pending")
                            <a href="{{route('requisition.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @elseif($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                            <a href="{{route('requisition.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @endif

                            @if(! $single_data->isOwner() && ! $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                            <a href="{{route('requisition.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @elseif(! $single_data->isOwner() && $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Approver")
                            <a href="{{route('requisition.edit',$single_data->id)}}" class="btn btn-sm btn-warning pull-right"><i class="icon-plus-circle"></i> <b>Edit</b></a>
                            @endif
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
                                            <div>Requisition - #{{$single_data->id}}</div>
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
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <th>Available Stock</th>
                                                    @endif
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
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <td>{{$data->product->stockProduct->quantity ?? 0}}</td>
                                                    @endif
                                                    <td>{{$data->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    @if(auth()->user()->id != $single_data->user_id)
                                                    <td colspan="7" style="text-align:center"> Requisition Review </td>
                                                    @else
                                                    <td colspan="6" style="text-align:center"> Requisition Review </td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                             <!-- Row end -->
                            <!-- Row start -->
                                <!-- Row start -->
                                @foreach($single_data->requisitionComments as $comment)
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="invoice-details">
                                            <address class="m-0 {{ $comment->status?'':'text-danger' }}">
                                               {{$comment->comment}},<br>
                                               By - #{{$comment->user->name}},<br>
                                               Designation - #{{$comment->user->designation->title}},<br>
                                               Role - #{{$comment->user->role->title}}
                                            </address>
                                            <div class="invoice-num {{ $comment->status?'':'text-danger' }}">
                                                <div>Type - #{{$comment->type}}</div>
                                                <div>{{date('d F Y',strtotime($comment->created_at))}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            <!-- Row end -->
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-start">
                                        @if($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Pending")
                                            <button class="btn btn-primary" onclick="changeStatus('Published')">Publish</button>
                                        @elseif($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                                        <button class="btn btn-primary"  onclick="changeStatus('Pending')">Un Publish</button>  
                                        @elseif($single_data->isOwner() && App\Enum\Status::tryFrom($single_data->status)->toString() == "Storekeeper")
                                        <button class="btn btn-primary"  onclick="changeStatus('Confirmed')">Confirmed</button> 
                                        @endif

                                        @if(! $single_data->isOwner() && ! $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Published")
                                            <button onclick="changeStatus('Approver')" class="btn btn-primary">Accept</button>
                                            <button  class="btn btn-light ms-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Decline</button>
                                            <!-- Modal start -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Decline Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            @csrf
                                                            <!-- Row start -->
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <!-- Field wrapper start -->
                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <textarea id="modal-message" name="message" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="field-placeholder">Message<span class="text-danger">*</span></div>
                                                                </div>
                                                                <!-- Field wrapper end -->
                                                                </div>
                                                            </div>
                                                            <!-- Row end -->
                                                        </div>
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

                                        @if(!$single_data->isOwner() && $user->isStorekeeper() && $user->hasPermission('app.requisition.approve') && App\Enum\Status::tryFrom($single_data->status)->toString() == "Approver")
                                            <button onclick="changeStatus('Storekeeper')" class="btn btn-primary">Accept</button>
                                            <button  class="btn btn-light ms-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Decline</button>
                                            <!-- Modal start -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Decline Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            @csrf
                                                            <!-- Row start -->
                                                            <div class="row gutters">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <!-- Field wrapper start -->
                                                                <div class="field-wrapper">
                                                                    <div class="input-group">
                                                                        <textarea id="modal-message" name="message" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="field-placeholder">Message<span class="text-danger">*</span></div>
                                                                </div>
                                                                <!-- Field wrapper end -->
                                                                </div>
                                                            </div>
                                                            <!-- Row end -->
                                                        </div>
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
        action="{{route('requisition.statusUpdate',$single_data->id)}}"
        method="POST"
        style="display: none;">
      @csrf()
      @method('put')
      <input id="status" type="hidden" name="status" >
      <input id="message" type="hidden" name="message" >
  </form>

    @endsection

    @push('custom_script')
    <script>
        function changeStatus(status){
            let form = document.getElementById('status_update_form')
            let field = document.getElementById('status')
            let modal_message = document.getElementById('modal-message')
            let message= document.getElementById('message')
            field.value = status
            if(status == 'Pending' && modal_message.value){
                message.value=modal_message.value
            }
            form.submit()
        }

    </script>
    @endpush