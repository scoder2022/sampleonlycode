@extends('admin.all.layout')
@push('scripts')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admins/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

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
        <form action="{{ route($base_route.'.store') }}" enctype="multipart/form-data" class="form-horizontal"
            method="POST" id="form">
            @csrf
            @include($base_route.'.includes.form')
            <!-- /.card-body -->

        </form>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
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
                password: "required",
                password_confirmation: {
                    equalTo: "#password"
                },
                image: {
                    extension: "jpg,jpeg,png,gif,raw",
                },

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
