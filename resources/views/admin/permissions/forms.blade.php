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
        @php
            $route = route($base_route.'.store');
        if(isset($data))
            $route = route($base_route.'.update',$data->id);
        @endphp
        <form action="{{ $route }}" enctype="multipart/form-data" class="form-horizontal"
            method="POST" id="form">
            @csrf
            @if(isset($data))
                @method('PUT')
                <input type="hidden" name="id" value="{{$data->id}}">
            @endif
            <div class="card-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" value="{{ isset($data) && !empty($data) ? $data->email : old('email') }}"
                            class="form-control" id="email" placeholder="Enter Email address">
                        @error('email')
                        <span class="error">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username"
                            value="{{ isset($data) && !empty($data) ? $data->username : old('username') }}" class="form-control"
                            placeholder="Enter User Name">
                        @error('username')
                        <span class="error">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name </label>
                        <input type="text" name="full_name"
                            value="{{ isset($data) && !empty($data) ? $data->full_name : old('full_name') }}"
                            class="form-control" placeholder="Enter First Name address">
                            @error('full_name')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        @error('password')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>


                    <div class="form-group">
                        <label for="password">Password Confirmation</label>
                        <input value="{{ old('password_confirmation') }}" type="password" placeholder="Confirm Password"
                         class="form-control"  name="password_confirmation">
                        @error('password_confirmation')
                        <span class="error">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Select Rolefa-stack</label>
                        <select name="roles[]" class="select2" multiple="multiple" data-placeholder="Select Roles" style="width: 100%;">
                         @foreach ($roles as $role)
                         <option value="{{ $role->id }}"
                            @if(isset($data))
                            {{ in_array($role->id,SiteHelper::usersRoleIds($data)) ? 'selected':'' }}
                            @elseif(!empty(old('roles')))
                            {{ in_array($role->id,old('roles')) ? 'selected' : '' }}
                            @endif
                            >{{ $role->name }}</option>
                         @endforeach
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="last_name">Select Roles</label>
                        @if(isset($roles) && $roles->count() > 0)
                        @foreach($roles as $role)
                        <div class="icheck-success d-inline">
                            <input type="checkbox" id="checkboxSuccess{{ $loop->iteration }}" name="roles[]" value="{{ $role->id }}"
                            @if(isset($data))
                            {{ in_array($role->id,SiteHelper::usersRoleIds($data)) ? 'checked':'' }}
                            @elseif(!empty(old('roles')))
                            {{ in_array($role->id,old('roles')) ? 'checked' : '' }}
                            @endif>
                            <label for="checkboxSuccess{{ $loop->iteration }}">{{ $role->name }}</label>
                          </div>
                        @endforeach
                        @endif
                        @error('role')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>

                        <div class="form-group clearfix"><label for="gender">Select Gender</label>
                          <div class="icheck-success d-inline">
                            <input type="radio"  name="gender" id="radioPrimary1" value="male"
                            {{ checked_values('check','male',isset($data)?$data->gender:old('gender')) }}>
                            <label for="radioPrimary1">Male</label>
                          </div>
                          <div class="icheck-success d-inline">
                            <input type="radio" name="gender" id="radioPrimary2" value="female"
                            {{ checked_values('check','female',isset($data)?$data->gender:old('gender')) }}>

                            <label for="radioPrimary2">Female</label>
                          </div>
                          <div class="icheck-success d-inline">
                            <input type="radio" name="gender" id="radioPrimary3" value="others"
                            {{ checked_values('check','others',isset($data)?$data->gender:old('gender')) }}>
                            <label for="radioPrimary3">Other</label>
                          </div>
                        </div>

                    <div class="form-group">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                @php
                                if(isset($data) && $data->image !='' && \Storage::exists($folder_path.DIRECTORY_SEPARATOR.$data->image)){
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
                            @error('first_name')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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

                   <div class="form-group">
                        <label for="bio" class="control-label col-sm-2">Description Bio</label>
                        <div class="col-sm-12">
                            <textarea name="bio" id="bio" cols="30"
                                rows="10">{{ isset($data)?$data->bio:old('bio') }}</textarea>
                            @error('bio')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                   <div class="form-group">
                    <label for="username" class="control-label col-sm-2">Status</label>
                        <div class="col-sm-6">
                            <input type="checkbox" name="status" value="1" data-toggle="toggle" data-on="Active"
                                data-size="small" data-off="Off" data-onstyle="success" data-offstyle="danger"
                                data-width="84" data-height="20" {{ old('status') == 1 ? 'checked':'' }} @isset($data)
                                {{ $data->status == 1 ? 'checked' : '' }} @endisset>
                            @error('status')
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
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
