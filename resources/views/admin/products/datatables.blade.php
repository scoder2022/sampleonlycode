@extends('admin.all.layout')
@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">


@endpush
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header text-center">
                    <h3 class="box-title">All {{ $panel }}</h3>
                    <a href="{{ route($base_route.'.create') }}" class="btn btn-sm btn-danger pull-right">Add New</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="datatabletest" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Full Names</th>
                            <th>E-Mail</th>
                            <th>Roles</th>
                            <th>Images</th>
                            <th>Updated Date</th>
                            <th >Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Search " data-column="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Search " data-column="1">
                                </td>
                                <td>
                                    <input type="text" class="form-control filter-input" placeholder="Search " data-column="2">
                                </td>
                            </tr>
                        </tfoot>
                      </table>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
@endsection
@push('scripts')

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script>
jQuery('#datatabletest').on('draw.dt', function() {
    jQuery('.status').each(function() {
           on:$('.status').bootstrapToggle()
    });
});


var table = $('#datatabletest').DataTable({
            "processing":true,
            "serverSide":true,
            "ajax":"{{ route('admin.users.getUsers') }}",
            "order": [[ 0, 'desc' ]],

    // columnDefs: [{ targets: 'status',
    //                 data:   "status",
    //                 render: function ( data, type, row ) {
    //                     if(row.status == 1){
    //                         var checked = 'checked';
    //                     }else{
    //                         var checked = '';
    //                     }
    //                     console.log(row);
    //                     console.log(checked);
    //                 if ( type === 'display' ) {
    //                     return '<input type="checkbox" name="status" value="1" class="editor-active status" data-id="'+row.id+'" '+checked+'>';
    //                 }
    //                 return data;
    //               },
    //                 className: "dt-body-center"
    //             }],

    // rowCallback: function () {
    //     $('input.status').bootstrapToggle({size: 'mini', onstyle:"success"});
    // },
            "columns": [
            {data: 'DT_RowIndex', name: 'id'},
             {data: 'full_names','orderable' : false,'searchable' : false,title: 'Faq Category',
                        mRender:  function(data, type, full) {
                            return data != null ? data.substr(0,1).toUpperCase() + data.substr(1):'';
                        }
                    },
            { "data": "email" },
            { "data": "roles","name":'roles'},
            {
                "data": "image",
                defaultContent: "No image",
                title: "Image",
                'orderable' : false,
                'searchable' : false
            },
            {data: 'created_at', name: 'created_at',
            mRender:  function(data, type, full) {
             return moment(data).format('MMMM Do YYYY, h:mm:ss a');
            }
          },
          {data:'status',name:'status', mRender:  function(data, type, full) {
            $('.status').bootstrapToggle();
             return data;
            }},
            { "data": "action",'orderable' : false,'searchable' : false}
        ]
        });
        $('.filter-input').keyup(function(){
    console.log($(this).data('column'));
    table.column($(this).data('column')).search($(this).val()).draw()
});
$('.filter-select').keyup(function(){
    console.log($(this).data('column'));
    table.column($(this).data('column')).search($(this).val()).draw()
});
    $(document).ready(function(){

        $(document).on("change", ".status", function() {
        var id = $(this).attr('data-id');
        console.log(id);
        if($(this).prop("checked")){
          var status = "1";
        }else{
          var status = "0";
        }
        var stanus = 'yes';
        $.ajax({
          method:'Post',
          url:'{{ route($base_route.'.short_query') }}',
          data:{
            _token:'{{ csrf_token() }}',
            id:id,
            status:status,
          },
          success: function (response) {
            var data = $.parseJSON(response);
            console.log(data)
            if(data.error){
              alert("sorry refresh and try again");
            }else{
              swal("Updated",data.message, "success");
            }
          },
          error:function (a,b,c) {
            alert('sorry refresh and try again');
          }
        });
});

       $('body').on('click','#delete',function(e){
            var user_id = $(this).attr("data_id");
                    var url = '{{ route("admin.users.destroy", ":user_id") }}';
                    url = url.replace(':user_id', user_id);
                    $('#form').attr('action', url);
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false,
                        },
                        function(isConfirm) {
                        if (isConfirm) {
                        $('.cancel').attr('disabled',true);
                        $('.confirm').attr('disabled',true);
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                '_method':'DELETE',
                                "id": user_id,
                                "_token": '{{ csrf_token() }}',
                                },
                                success: function (data) {
                                    swal("Deleted!", data.success , "success");
                                var table = $('#datatabletest').DataTable();
                                table.row($(this).parents('tr')).remove().draw();
                                },
                                error: function (data) {
                                    swal("Error",data.responseJSON.error, "error");
                                }
                                });
                        }
                        });
       });
        });
</script>

@endpush
