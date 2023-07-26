@extends('layouts.layout')
@section('title', 'Damage List')
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
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">User Damage Request List</h3>
            </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered" id="example" style="width:100%"> 
                    <thead> 
                      <tr> 
                        <th>Sl</th>
                        <th>Requisition Date</th>
                        <th>User Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Damage Invoice</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer"></div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
{!!Html::script('custom/yajraTableJs/jquery.js')!!}
<script>
   // ==================== date format ===========
   function dateFormat(data) { 
    let date, month, year;
    date = data.getDate();
    month = data.getMonth() + 1;
    year = data.getFullYear();

    date = date
        .toString()
        .padStart(2, '0');

    month = month
        .toString()
        .padStart(2, '0');

    return `${date}-${month}-${year}`;
  }
	$(document).ready(function() {
		'use strict';
      var table = $('#example').DataTable({
			serverSide: true,
			processing: true,
      deferRender : true,
			ajax: "{{route('damagerequests.index',['status'=>request()->status])}}",
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8]
                },
                messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
            },
            {
                extend: 'print',
                title:"",
                messageTop: function () {
                  var top = '<center><p class ="text-center"><img src="{{asset("upload/logo")}}/header_pppo.jpg" width="100%"/></p></center>';
                //   top += '<center><h3>PPPO</h3></center>';
                  
                  return top;
                },
                customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
 
                $(win.document.body).find('table').css('font-size', 'inherit');
 
                $(win.document.body).find('table thead th').css('border','1px solid #ddd');  
                $(win.document.body).find('table tbody td').css('border','1px solid #ddd');  
                $(win.document.body).css("height", "auto").css("min-height", "0");
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8]
                },
                messageBottom: null
            }
        ],
			aaSorting: [[0, "asc"]],

			columns: [
        {
          data: 'DT_RowIndex',
        },
				{
          data: 'date',
          render:function(data, display, row){
            // return dateFormat(new Date(data)).toString();
            return data;
          }
        },
				{
          data: 'user.name',
        },
				{
          data: 'user.designation.title',
        },
				{
          data: 'user.department.title',
        },
				{
          data: 'user.role.title',
        },
				{
          data: 'id',
          render: function(data, type, row) {
            var url = '{{route("damagerequests.show",":id")}}'; 
            var url = url.replace(':id', row.id);
            return '<a href=' + url +' class="badge bg-primary badge-sm"> request#'+ data +'</a>';
          }
        },
				{
          data: 'note',
        },
				{
          data: 'status',
          render: function(data, display, row){
            if (data == 0) {
							return "<a class='badge badge-sm bg-warning btn-status-active' data-id='" + row.id + "'>Pending</a>";
						} else if( data == 1) {
							return "<a class='badge badge-sm bg-primary btn-status-deactive' data-id='" + row.id + "'>Published</a>";
						} else if( data == 2) {
							return "<a class='badge badge-sm bg-success btn-status-deactive' data-id='" + row.id + "'>Approved</a>";
						}
          }
        },
        {
          data: 'action',
        },
			]
    });
     //-------- Delete single data with Ajax --------------//
     $("#example").on("click", ".button-delete", function(e) {
			e.preventDefault();

			var confirm = window.confirm('Are you sure want to delete data?');
			if (confirm != true) {
				return false;
			}
			var id = $(this).data('id');
			var url = '{{route("damagerequests.destroy",":id")}}';
			var url = url.replace(':id', id);
			var token = '{{csrf_token()}}';
			$.ajax({
				url: url,
				type: 'POST',
				data: {
					'_method': 'DELETE',
					'_token': token
				},
				success: function(data) {
					table.ajax.reload();
					console.log('success');
					successNotification(data.message);
				},

			});
    });
});
</script>
@endsection 