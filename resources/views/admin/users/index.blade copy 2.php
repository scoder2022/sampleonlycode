@extends('admin.all.layout')

@push('styles')

<style type="text/css">
    .my-active span {
        background-color: #5cb85c !important;
        color: white !important;
        border-color: #5cb85c !important;
    }
    #filter_cats{
        float:left
    }
    .anchor_colors{
        color: black !important;
    }
</style>
@endpush

@section('title')
@include('admin.all.title')
@endsection

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
                    @include('admin.users.includes.tables')
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script>

    $(document).ready(function () {
        $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
    $('.status').change(function () {
        var id = $(this).attr('data-id');
        var status_for = $(this).attr('data-model');
        if ($(this).prop("checked")) {
            var status = "1";
        } else {
            var status = "0";
        }
        $.ajax({
            method: 'POST',
            url: '{{ route('admin.status_change') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status,
            },
            success: function (response, text) {
                var data = $.parseJSON(response);
                if (data.error) {
                    alert("sorry refresh and try again");
                } else {
                    swal("Updated", data.message, "success");
                }
            },
            error: function (request, status, error) {
                var ee = JSON.parse(request.responseText);
                swal("Error", "Error:- Invalid Request Detected", "error");
            }
        });
    });
        $('body').on('click','#delete',function(e){
            var tr =  $(this).parents('tr');
            var id = $(this).attr("data_id");
            var url = '{{ route($base_route.".destroy", ":id") }}';
            url = url.replace(':id', id);
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
                        "id": id,
                        "_token": '{{ csrf_token() }}',
                        },
                        success: function (data) {
                            tr.remove();
                            swal("Deleted", data.success, "success");
                        },
                        error: function (data) {
                            swal("Error",data.responseJSON.error, "error");
                        }
                    });
                }
            });
        });
    });

    $('.status').change(function () {
        var id = $(this).attr('data-id');
        var status_for = $(this).attr('data-model');
        if ($(this).prop("checked")) {
            var status = "1";
        } else {
            var status = "0";
        }
        $.ajax({
            method: 'POST',
            url: '{{ route('admin.status_change') }}',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status,
            },
            success: function (response, text) {
                var data = $.parseJSON(response);
                if (data.error) {
                    alert("sorry refresh and try again");
                } else {
                    swal("Updated", data.message, "success");
                }
            },
            error: function (request, status, error) {
                var ee = JSON.parse(request.responseText);
                swal("Error", "Error:- Invalid Request Detected", "error");
            }
        });
    });
</script>


@endpush
