@extends('admin.all.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
<div class="container">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="text-center">Add {{ $panel }}</h3>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- /.card-header -->
        <!-- form start -->
        @php
            $route = route($base_route.'.store');
        if(isset($data) && count($data) > 0)
            $route = route($base_route.'.update',$data['user']->id)
        @endphp
        <form action="{{ $route }}" enctype="multipart/form-data" class="form-horizontal"
            method="POST" id="form">
            @csrf

            @if(isset($data) && count($data) > 0)
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{$data['user']->id}}">
            @endif
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title"
                        value="{{ isset($data) && !empty($data) ? $data['user']->title : old('title') }}"
                        class="form-control" placeholder="Enter Title address">
                </div>

                <div class="form-group">
                    <label for="title">Value</label>
                    <input type="text" name="title"
                        value="{{ isset($data) && !empty($data) ? $data['user']->title : old('title') }}"
                        class="form-control" placeholder="Enter Value address">
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Select User Status</label>
                        <div class="select2-purple">
                            <select name="status" class="form-control">
                                <option disabled selected>Select User Status</option>
                                <option value="1" {{ isset($data) && !empty($data) && $data['user']->status == 1 ? 'selected="selected"'  : '' }}>Active</option>
                                <option value="0" {{ isset($data) && !empty($data) && $data['user']->status == 0 ? 'selected="selected"'  : '' }}>In-active</option>
                                <option value="2" {{ isset($data) && !empty($data) && $data['user']->status == 2 ? 'selected="selected"'  : '' }}>suspense</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>
            <!-- /.card-body -->

        </form>
    </div>
</div>
@endsection


@section('js')
<script src="{{ asset('admins/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('admins/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
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
                first_name: {
                    required: true,
                },
                last_name: {
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
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
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

    function showThumbnail(file_elem, target){
            console.log('called');
            if(file_elem.files && file_elem.files[0]){
                var reader = new FileReader();
                reader.onload = function (e){
                    $('#'+target).attr('src', e.target.result).css("width", "290px");
                    $('#thumb_a').attr('href', e.target.result);
                // $('selecteddiv').attr('src',e.selecteddiv.result);
                }
                reader.readAsDataURL(file_elem.files[0]);
            }
        }

</script>
@endsection
