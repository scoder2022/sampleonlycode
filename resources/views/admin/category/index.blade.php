@extends('admin.all.layout')

@push('styles')
<link href="{{ asset('admins/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
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
    @livewire('admin.category.index',['all_categories'=>$all_categories])
@endsection

@push('scripts')
<script src="{{ asset('admins/js/bootstrap4-toggle.min.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script src="{{ asset('admins/js/loadingoverlay.min.js') }}"></script>
<script>
    $('.testf').click(function () {
        swal("Updated", "works", "success");
    })
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


@endpush
