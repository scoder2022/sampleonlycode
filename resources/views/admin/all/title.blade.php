<div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <span style="color:black;font-weight:bold;font-size:19px">
              Welcome
          </span>
          <span style="color:seagreen;font-weight:bold;font-size:19px">Admin
          </span>

          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item {{ \Route::current()->action['as'] == '.create' ?  'active' : '' }}">{{$panel}}</li>
          </ol>
        </div>
        <div class="col-sm-3">
          <h1 class="text-dark">{{ $panel ?? null }}</h1>
        </div>
        <div class="col-sm-3">
            <a href="{{ route($base_route.'.create') }}" class="btn btn-info float-right">Add New</a>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
