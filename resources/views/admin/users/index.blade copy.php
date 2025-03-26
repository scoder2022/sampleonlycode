@extends('admin.all.layout')

@push('styles')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

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
@livewire('admin.users.index')
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.js" defer></script>
<script>

    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $(document).ready(function () {

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
</script>

<script>

    $('.status').change(function () {
        console.log('d');
        var id = $(this).attr('data-id');
        var forClass = $(this).attr('data-model');
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
                forClass:forClass,
                status: status,
            },
            success: function (response, text) {
                var data = $.parseJSON(response);
                if (data.error) {
                     swal("Updated", 'ff', "success");
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
