@extends('admin.all.layout')

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('admins/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('admins/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
@include('admin.products.includes.styles')
@endpush

@section('content')
<!-- MultiStep Form -->
<div class="container" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-sm-12">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 class="text-center"><strong>Add {{ $panel }}</strong></h2>
                <p class="text-center"> {{ app()->currentLocale() }} {{ __('custom.welcome',['name'=>'test','age'=>26])}} Fill all the required (*) form field to go to next step</p>
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
                        <form id="msform" action="{{ route('admin.products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @include('admin.products.form')
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
