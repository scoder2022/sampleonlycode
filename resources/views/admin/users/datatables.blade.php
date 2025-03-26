@extends('admin.all.layout')
@push('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('admins/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admins/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link href="{{ asset('admins/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<style>
    #datatabletest{
        width: 100% !important;
    }
    a.btn:hover {
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -o-transform: scale(1.1);
    }

    a.btn {
        -webkit-transform: scale(0.8);
        -moz-transform: scale(0.8);
        -o-transform: scale(0.8);
        -webkit-transition-duration: 0.5s;
        -moz-transition-duration: 0.5s;
        -o-transition-duration: 0.5s;
    }

</style>
@endpush

@section('title')
@include('admin.all.title')
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatabletest" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>S.N</th>
                    <th>Full Names</th>
                    <th>E-Mail</th>
                    <th>Images</th>
                    <th>Updated Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                    <th>S.N</th>
                    <th>Full Names</th>
                    <th>E-Mail</th>
                    <th>Images</th>
                    <th>Updated Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
@endsection

@push('scripts')

@include('admin.all.custom_scripts')
<script src="{{ asset('admins/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admins/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admins/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admins/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admins/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admins/dist/js/moment-with-locales.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admins/js/bootstrap4-toggle.min.js') }}"></script>
<script>
    $('#datatabletest').DataTable({
        "processing":true,
        "serverSide":true,
        "ajax":"{{ route('admin.users.getUsers') }}",
        "order": [[ 0, 'desc' ]],
        "columns": [
        {data: 'DT_RowIndex', name: 'id'},
        { "data": "full_names",'orderable' : false,'searchable' : false},
        { "data": "email" },
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
        {data: 'status', name: 'status',
            mRender:  function(data, type, full) {

            return data;
        }
        },
        { "data": "action",'orderable' : false,'searchable' : false},
        ]
        }).ajax.reload( function() {
            $("input[name=status]").bootstrapToggle();
            loadStatus();
    });

    $(document).ready(function(){
        console.log('ready');
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
