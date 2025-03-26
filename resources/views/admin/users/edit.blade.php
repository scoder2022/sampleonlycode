@extends('admin.all.layout')
@push('styles')
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('admins/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<link href="{{ asset('admins/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('admins/plugins/daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="text-center">Add {{ $panel }}</h3>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <h2 class="text-center">Errors List</h2>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route($base_route.'.update',$data->id) }}" enctype="multipart/form-data" class="form-horizontal"
            method="POST" id="form">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{$data->id}}">
            @include($base_route.'.includes.form')
            <!-- /.card-body -->

        </form>
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('admins/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admins/dist/js/moment-with-locales.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('admins/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('admins/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admins/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admins/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<script>
     CKEDITOR.replace('bio', {
        height: 300,
        filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    function showThumbnail(file_elem, target) {
        if (file_elem.files && file_elem.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + target).attr('src', e.target.result).css("width", "290px");
                $('#thumb_a').attr('href', e.target.result);
                // $('selecteddiv').attr('src',e.selecteddiv.result);
            }
            reader.readAsDataURL(file_elem.files[0]);
        }
    }
    jQuery.validator.addMethod("password_validation", function(value, element){
            if($('#password').val() !== ''){
                return true;
            }
            return false;
        }, "wrong nic number");
    $(document).ready(function () {

        $('#form').validate({

            rules: {
                email: {
                    required: true,
                    email: true,
                },
                username: {
                    required: true,
                    alphanumeric: true,
                },
                full_name: {
                    required: true,
                },
                image: {
                    extension: "jpg,jpeg,png,gif,raw",
                },
                password:{
                    password_validation:true
                }

            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a vaild email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
            },


            errorElement: 'span',
            errorPlacement: function (error, element) {
                element.closest('div').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('error');
            }
        });

        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

    });

</script>
@endpush
