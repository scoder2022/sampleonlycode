@extends('admin.all.layout')

@section('content')
<div class="col-sm-12">
    <form action="{{ route('admin.settings.update') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
            <li  class="nav-item"><a href="#general" class="nav-link active" data-toggle="tab">General</a></li>
            <li  class="nav-item"><a href="#about" class="nav-link" data-toggle="tab">About</a></li>
            <li  class="nav-item"><a href="#policy" class="nav-link" data-toggle="tab">Policies</a></li>
            <li  class="nav-item"><a href="#social" class="nav-link" data-toggle="tab">Social</a></li>
            <li  class="nav-item"><a href="#footer" class="nav-link" data-toggle="tab">Footer</a></li>
            <li  class="nav-item"><a href="#seo" class="nav-link" data-toggle="tab">SEO</a></li>
            <li  class="nav-item"><a href="#referal" class="nav-link" data-toggle="tab">Referal</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
            @include('admin.site_settings.settings.general')
            @include('admin.site_settings.settings.about')
            @include('admin.site_settings.settings.policy')
            @include('admin.site_settings.settings.social')
            @include('admin.site_settings.settings.tax')
            @include('admin.site_settings.settings.footer')
            @include('admin.site_settings.settings.seo')
            @include('admin.site_settings.settings.referal')
          <!-- /.tab-pane -->
        </div>
        <div class="form-group">
            <label class="col-sm-3"></label>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-danger pull-right">Update</button>
            </div>
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->

    </div>

    <!-- /.nav-tabs-custom -->
    </form>
  </div>
@endsection
