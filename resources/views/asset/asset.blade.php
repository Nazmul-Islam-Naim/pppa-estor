@extends('layouts.layout')
@section('title', 'Books')
@section('content')
<!-- Content Header (Page header) -->
<style>
    .img-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    max-width: none;
    height: auto;
    width:100px;
    height:90px;
}
</style>
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
            <div class="card-title">Books List</div>
            <a href="{{route('asset.create')}}" class="btn btn-primary"><i class="icon-plus-circle"></i>Add Books</a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!--<table id="dataTable" class="table v-middle">-->
              <table id="example" class="table custom-table">
                <thead>
                  <tr>
                    <th>{{ __('home.SL') }}</th>
                    <th>Books Image</th>
                    <th>Books Name</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Sub Type</th>
                    <th>Quantity</th>
                    <th>{{ __('home.action') }}</th>
                  </tr>
                </thead>
              </table>
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
			ajax: "{{route('asset.index')}}",
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 2, 3,4,5,6]
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
                    columns: [ 0, 2, 3,4,5,6]
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
          data: 'image',
          render: function(data, type, row) {
            if (data != null) {
            return "<img src={{ URL::to('/') }}/upload/books/" + data + " width='100px' class='img-thumbnail' />";
			} else {
				return '<img src="{{asset("upload/logo/no-image.jpg")}}" width="100px" class="img-thumbnail" />'
			}
          }
        },
				{
          data: 'name',
        },
				{
          data: 'writter',
        },
				{
          data: 'assettype.name',
        },
				{
          data: 'assetsubtype.name',
        },
				{
          data: 'quantity',
        },
        {
          data: 'action',
        }
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
			var url = '{{route("asset.destroy",":id")}}';
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