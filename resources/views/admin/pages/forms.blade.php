@extends('admin.all.layout')
@section('css')
<link rel="stylesheet" href="{{ asset('admins/plugins/select2/css/select2.min.css') }}">

@endsection
@section('content')
<div class="container-fluid">
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
            $route = route($base_route.'.update',$data['page']->id);
        @endphp
        <form action="{{ $route }}" enctype="multipart/form-data" class="form-horizontal"
            method="POST" id="form">
            @csrf

            @if(isset($data) && count($data) > 0)
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="{{$data['page']->id}}">
            @endif
            <div class="card-body">

                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="name" name="name" value="{{ isset($data) && !empty($data) ? $data['page']->name : old('name') }}"
                        class="form-control" id="name" placeholder="Enter Title">

                    @if ($errors->has('name'))
            <span class="help-block">
                          {{ $errors->first('name') }}
                      </span>
          @endif

                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="ckeditor form-control" name="contents">{!! isset($data) ? $data['page']->contents : old('contents') !!}</textarea>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <div class="custom-file">
                            @php
                            if (isset($data) && $data['page']->image !=null && Storage::exists($data['page']->image)){
                                $thumbnail = Storage::url($data['page']->image);
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
               <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>Status</label>
                    <div class="card-success">
                        <div class="card-body">
                            <input type="checkbox" name="status" class="status" checked data-bootstrap-switch
                                data-off-color="danger" data-on-color="success" value="1">
                        </div>
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

@isset($data)

<script>
    CKEDITOR.replace('description', {
     filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
     filebrowserUploadMethod: 'form'
 });

 $(document).ready(function () {
     $('#form').validate({
         rules: {
             name: {
                 required: true,
             },
             image:{
                 extension: "jpg|jpeg|png|ico|bmp"
             }
         },
         messages: {
             name: {
                 required: "Please provide a name",
             },
             description: {
                 required: "Please provide a description",
             },
             image: {
         extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
     }
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

 });

</script>

@else

@section('js')
  <script>
       CKEDITOR.replace('description', {
        filebrowserUploadUrl: "{{route('admin.ckeditor.image-upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
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
    $(document).ready(function () {



        $('#form').validate({
            rules: {
                name: {
                    required: true,
                },
                image:{
                    required:true,
                    extension: "jpg|jpeg|png|ico|bmp"
                }
            },
            messages: {
                name: {
                    required: "Please provide a name",
                },
                description: {
                    required: "Please provide a description",
                },
                image: {
            required: "Please upload file.",
            extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
        }
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

    });

</script>
@endsection

@endisset
