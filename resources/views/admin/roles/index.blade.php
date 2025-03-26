@extends('admin.all.layout')
@section('css')
<style type="text/css">
    .my-active span {
        background-color: #5cb85c !important;
        color: white !important;
        border-color: #5cb85c !important;
    }
    #filter_cats{
        float:left
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
            <div class="col-sm-2" id="filter_cats">
                <select class="form-control">
                    <option>Sort / Filter By </option>
                    <option>E-Mail</option>
                    <option>First Name</option>
                    <option>Last Name</option>
                    <option>Status</option>
                    <option>option 4</option>
                    <option>option 5</option>
                  </select>
              </div>
            <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" id="tables">
         @include('admin.roles.tables')
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection

@section('js')

<script>
    $(document).ready(function () {
        let sorting = 'desc';
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
                        $('#tables').html(data);
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

@endsection
