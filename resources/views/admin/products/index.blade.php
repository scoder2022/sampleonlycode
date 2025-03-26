@extends('admin.all.layout')
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
                    @include('admin.products.includes.tables')
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

<script>
    $(document).ready(function () {
        let sorting = 'desc';

        $('.status').change(function(){
        var id = $(this).attr('data-id');
        if($(this).prop("checked")){
          var status = "1";
        }else{
          var status = "0";
        }
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

        $('body').on('click','.sortBy', function () {
                var sortBy = $(this).attr('sortBy');
                var url = '{{ route("admin.users.index") }}';
                //url = url.replace(':user_id', 'sorting='+sorting+'&sortBy='+sortBy);
                    if(sorting == 'desc'){
                        sorting = 'asc';
                    }else{
                        sorting = 'desc';
                    }
                var url = url+'?sortBy='+sortBy+'&sorting='+sorting ;
                window.history.pushState(null,null,url);
                $.ajax({
                        url: '{{ url("admin/users") }}',
                        method: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                            sortBy:sortBy,
                            sorting:sorting
                        },
                    }).done(function (data) {
                        $('.box-body').html(data);
                    }).fail(function () {
                        console.log('here');
                    });;
            });

            $('body').on('click','#delete',function(e){
            var tr =  $(this).parents('tr');
            var id = $(this).attr("data_id");
                    var url = '{{ route("admin.users.destroy", ":id") }}';
                    url = url.replace(':id', id);
                    $('#form').attr('action', url);
                    swal({
                        title: "Are you sure?",
                        text: "You Want to Delete this Data?",
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
       $('.card').on('keyup', '#search', function (e) {
            var query = $('#search').val();
            setInterval(function () {
                if (query != '') {
                    $.ajax({
                        url: '{{ url("admin/users") }}',
                        method: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                            query: query,
                        },
                    }).done(function (data) {
                        console.log('gere');
                        $('#tables').html(data)
                    }).fail(function () {
                        console.log('here');
                    });;
                }
            }, 4000);
        });

    });



</script>

@endpush
