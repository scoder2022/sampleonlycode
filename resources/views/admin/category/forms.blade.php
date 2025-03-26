@extends('admin.all.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">
<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
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
        if(isset($data) && count($data) > 0 && Route::is($base_route.'.update')){
        $route = route($base_route.'.update',$data[$panel]->id);
        }
        @endphp
        <form action="{{ $route }}" enctype="multipart/form-data" class="form-horizontal" method="POST" id="form">
            @csrf
            @if(isset($data) && count($data) > 0 && Route::is($base_route.'.update'))
            @method('PUT')
            @csrf
            <input type="hidden" name="id" value="{{$data[$panel]->id}}">
            @endif
            <div class="card-body">

                <div class="form-group">
                    <label for="name">{{ $panel }} Name </label>
                    <input type="text" name="name"
                        value="{{ isset($data) && !empty($data[$panel]) ? $data[$panel]->name : old('name') }}"
                        class="form-control" placeholder="Enter Last Name address">
                </div>

                <div class="form-group">
                    <label for="password">Description</label>
                    <textarea name="description"></textarea>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>All Categories</label>
                        <div class="select2-purple">
                            <select name="parent_id" id="theSelect" class="form-control">
                                <option value="0">Select Main Category</option>
                                @foreach($data['all_categories'] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @if($category->children !='')
                                @foreach($category->children as $child)
                                <option value="{{ $child->id }}">
                                    &nbsp;&nbsp;--&nbsp;&nbsp;{{ $child->name }}</option>
                                @endforeach
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            @php
                            if(isset($data[$panel]) && $data[$panel]->image !='' &&
                            \Storage::exists($folder_path.DIRECTORY_SEPARATOR
                            .$data[$panel]->image)){
                            $thumbnail = $images_path.'/'.$folder_name.'/'.$user->image;
                            }else{
                            $thumbnail = $images.'/defaults.png';
                            }
                            @endphp
                            <input type="file" name="image" onchange="showThumbnail(this, 'thumb')"
                                class="custom-file-input">
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

    function showThumbnail(file_elem, target) {
        console.log('called');
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

</script>
@endsection
