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
                    <label for="email">Email address</label>
                    <input type="email" name="email" value="{{ isset($data) && !empty($data) ? $data['user']->email : old('email') }}"
                        class="form-control" id="email" placeholder="Enter Email address">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username"
                        value="{{ isset($data) && !empty($data) ? $data['user']->username : old('username') }}" class="form-control"
                        placeholder="Enter User Name">
                </div>

                <div class="form-group">
                    <label for="first_name">First Name </label>
                    <input type="text" name="first_name"
                        value="{{ isset($data) && !empty($data) ? $data['user']->first_name : old('first_name') }}"
                        class="form-control" placeholder="Enter First Name address">
                </div>

                <div class="form-group">
                    <label for="middle_name">Middle Name </label>
                    <input type="text" name="middle_name"
                        value="{{ isset($data) && !empty($data) ? $data['user']->middle_name : old('middle_name') }}"
                        class="form-control" placeholder="Enter Middle Name address">
                </div>


                <div class="form-group">
                    <label for="last_name">Last Name </label>
                    <input type="text" name="last_name"
                        value="{{ isset($data) && !empty($data) ? $data['user']->last_name : old('last_name') }}" class="form-control"
                        placeholder="Enter Last Name address">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="password">Password Confirmation</label>
                    <input value="{{ old('password_confirmation') }}" type="password" placeholder="Confirm Password"
                        class="form-control" id="password_confirmation" name="password_confirmation">
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

                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <div class="custom-file">
                            @php
                            if(isset($data) && $data['user']->image !='' && \Storage::exists($folder_name.DIRECTORY_SEPARATOR.$data['user']->image)){
                                $thumbnail = $images_path.'/'.$folder_name.'/'.$user->image;
                            }else{
                                $thumbnail = $images.'/defaults.png';
                            }
                            @endphp
                            <input type="file" name="image" onchange="showThumbnail(this, 'thumb')" class="custom-file-input">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="image">Upload</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                   <label for="images" class="col-sm-3 control-label">Current Images</label>

                   <div class="col-sm-6">
                    <a href="{{ $thumbnail }}" data-lightbox="mygallery" id="thumb_a">
                       <img src="{{ $thumbnail }}" class="img-thumbnail rounded" style="width: 290px"
                       alt="current_image" id="thumb" data-lightbox="mygallery">
                    </a>
                   </div>
                   @error('images')
                   <span class="invalid-feedback" role="alert" style="color:red">
                           <strong>{{ $message }}</strong>
                        </span>
                   @enderror
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
