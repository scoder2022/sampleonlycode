@extends('admin.all.layout')

@push('styles')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('admins/plugins/iCheck/all.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admins/bower_components/ckeditor/samples/css/samples.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('admins/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
@include('admin.products.includes.styles')
@endpush

@section('content')
<!-- MultiStep Form -->
<div class="container" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-sm-12">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 class="text-center"><strong>Edit {{ $panel }}</strong></h2>
                <p class="text-center">Fill all the required (*) form field to go to next step</p>
                @if ($errors->any())
                <div class="alert alert-danger error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form action="{{ route('admin.users.update',$data->id) }}" id="msform" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <input type="hidden" name="id" value="{{ $data->id }}">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif @include('admin.products.form')
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.products.includes.scripts')
@endpush
