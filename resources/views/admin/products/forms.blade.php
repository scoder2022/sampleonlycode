@extends('admin.all.layout')
@push('styles')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('admins/plugins/iCheck/all.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admins/bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admins/bower_components/ckeditor/samples/css/samples.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('admins/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">

<style>
    #grad1 {
        background-color: : #9C27B0;
        background-image: linear-gradient(120deg, #FF4081, #81D4FA)
    }

    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;
        position: relative
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;
        position: relative
    }

    #msform fieldset:not(:first-of-type) {
        display: none
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E
    }

    #msform input,
    #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px
    }

    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0
    }

    #msform .action-button {
        width: 100px;
        background: skyblue;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }

    #msform .action-button:hover,
    #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
    }

    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }

    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
    }

    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px
    }

    select.list-dt:focus {
        border-bottom: 2px solid skyblue
    }

    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative
    }

    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left
    }

    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }

    #progressbar .active {
        color: #000000
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 25%;
        float: left;
        position: relative
    }

    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f023"
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007"
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d"
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c"
    }

    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }

    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }

    #progressbar li.active:before,
    #progressbar li.active:after {
        background: skyblue
    }

    .radio-group {
        position: relative;
        margin-bottom: 25px
    }

    .radio {
        display: inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 2px
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
    }

    .fit-image {
        width: 100%;
        object-fit: cover
    }

</style>
@endpush

@section('content')
<!-- MultiStep Form -->
<div class="container" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-sm-12">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 class="text-center"><strong>Add {{ $panel }}</strong></h2>
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
                        <form id="msform" action="{{ route('admin.products.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>General Info</strong></li>
                                <li id="personal"><strong>Category</strong></li>
                                <li id="payment"><strong>Seo</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul> <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Account Information</h2>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="Product title"
                                                    value="{{ isset($data) ? $data->name : old('name') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="approved">Select Approval</label>
                                                <select name="approved" class="form-control">
                                                    <option selected disabled>Product Approved</option>

                                                    <option
                                                        {{ isset($data) ? checked_values('select',1,$data->approved) : null }}
                                                        value="1">Approved</option>
                                                    <option
                                                        {{ isset($data) ? checked_values('select',0,$data->approved) : null }}
                                                        value="0">Pending</option>
                                                    <option
                                                        {{ isset($data) ? checked_values('select',2,$data->approved) : null }}
                                                        value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="status">Select Status</label>
                                                <select name="status" class="form-control">
                                                    <option selected disabled>Product Status</option>
                                                    <option value="1"
                                                        {{ isset($data) ? checked_values('select',1,$data->status) : '' }}>
                                                        Show</option>
                                                    <option value="0"
                                                        {{ isset($data) ? checked_values('select',1,$data->status) : '' }}>
                                                        Hide</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="name"> Price </label>
                                                <input type="text" class="form-control" name="price" id="price"
                                                    placeholder="Product Sale Price"
                                                    value="{{ isset($data) ? $data->price : old('price') }}">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="name">Sale Price </label>
                                                <input type="text" class="form-control" name="sale_price"
                                                    placeholder="Product Sale Price"
                                                    value="{{ isset($data) ? $data->price : old('price') }}">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="quantity" class="control-label">Quantity</label>
                                                <br>
                                                <input type="text" name="quantity"
                                                    value="{{ isset($data) ? $data->quantity : old('quantity') }}"
                                                    class="form-control" placeholder="Enter Quantity">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="negotiable" class="control-label">Negotiable</label>
                                                <br>
                                                <div class="">
                                                    <input type="radio" name="negotiable" class="flat-red" value="1"
                                                        {{ checked_values('check',1,isset($data)?$data->negotiable:'') }}>Yes
                                                    <input type="radio" name="negotiable" class="minimal-red" value="0"
                                                        {{ checked_values('check',0,isset($data)?$data->negotiable:'') }}
                                                        checked>No
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="tax" class="control-label">Tax</label>
                                                <br>
                                                <div class="">
                                                    <input type="radio" name="tax" class="flat-red" value="1"
                                                        {{ checked_values('check',1,isset($data)?$data->tax:'') }}>Yes
                                                    <input type="radio" name="tax" class="minimal-red" value="0"
                                                        {{ checked_values('check',0,isset($data)?$data->tax:'') }}
                                                        checked>No
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="name" class="control-label">Quality</label>
                                                <br>
                                                <div class="">
                                                    <input type="radio" name="quality" class="flat-red"
                                                        value="brand_new" checked
                                                        {{ checked_values('check','brand_new',isset($data)?$data->negotiable:'') }}>Brand
                                                    New
                                                    <input type="radio" name="quality" class="flat-red" value="used"
                                                        {{ checked_values('check','used',isset($data)?$data->negotiable:'') }}>Used
                                                    <input type="radio" name="quality" class="flat-red" value="old"
                                                        {{ checked_values('check','old',isset($data)?$data->negotiable:'') }}>Old
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>All Categories</label>
                                                <div class="select2-purple">
                                                    <select name="parent_id" id="theSelect" class="form-control">
                                                        <option value="0">Select Main Category</option>
                                                        @foreach($all_categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                        </option>
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
                    </div> --}}
                    <div class="clearfix"></div>
                    <br>
                    <br>
                    <div class="col-sm-12" style="height: 110px">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        @php
                                        if(isset($data) && $data->image !='' &&
                                        \Storage::exists($folder_path.DIRECTORY_SEPARATOR
                                        .$data->image)){
                                        $thumbnail = $images_path.'/'.$folder_name.'/'.$user->image;
                                        }else{
                                        $thumbnail = $images.'/defaults.png';
                                        }
                                        @endphp
                                        <input type="file" id="file-input" name="images[]" onchange="loadPreview(this)"
                                            class="custom-file-input" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product-image-list">
                        @if(isset($data) && count($data->images()->get()) > 0)
                        @foreach($data->images()->get() as $key=>$image)
                        <?php $class = ( $image->is_main_image == 1 ) ? "active" : ""; ?>
                        <div class="image-preview">
                            <div class="actual-image-thumbnail">
                                <img class="img-thumbnail img-tag img-responsive"
                                    src="{{ asset(getProductImage($data->id,'small')) }}"
                                    data-path="{{  getProductImage('small')  }}" />
                                <input type="hidden" name="image" value="" />
                                @if($image->is_main_image)
                                <input type="hidden" class="is_main_image_hidden_field"
                                    name="image[{{ $image->id }}][is_main_image]" value="1" />
                                @else
                                <input type="hidden" class="is_main_image_hidden_field"
                                    name="image[{{ $image->id }}][is_main_image]" value="0" />
                                @endif
                            </div>
                            <div class="image-info">
                                <div class="image-title">
                                    <a href="javascript:void(0);"
                                        title="{{  asset(getProductImage($data->id,'small'))  }}">
                                        <img src="{{ asset(getProductImage($data->id,'small')) }}" alt="">
                                        {{ str_limit( getProductImage('small') , 20) }}
                                    </a>
                                </div>
                                <div class="actions">
                                    <div class="action-buttons">
                                        <button type="button"
                                            class="btn btn-xs btn-info is_main_image_button {{ $class }} selected-icon"
                                            title="Select as main image">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button type="button" class="destroy-image btn btn-xs btn-danger"
                                            title="Remove file">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <div id="thumb-output">

                        </div>
                    </div>


                    <div class="form-group">
                        <label for="password">Short Description</label>
                        <textarea class="form-control" id="short_description"
                            name="short_description">{{ isset($data)?$data->short_description:old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="password">Long Description</label>
                        <textarea class="form-control ckeditor"
                            name="long_description">{{ isset($data)?$data->long_description:old('long_description') }}</textarea>
                    </div>
                </div>
            </div> <input type="button" name="next" class="next action-button" value="Next Step" />
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <h2 class="fs-title">Selection Category</h2>
                    <section>
                        <style>
                            .content__box--shadow {
                                background: #ffffff;
                                border-top: 3px solid #d2d6de;
                                margin-bottom: 20px;
                                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
                                -webkit-box-shadow: 0 0 8px -4px black;
                                box-shadow: 0 0 8px -4px black;
                            }

                            ul.parent-list li:hover>ul {
                                display: block !important;
                            }

                            input.product--hidden-category {
                                border: none;
                                /* display: inline-block; */
                                font-size: 24px;
                                font-weight: 500;
                                color: #d8011f !important;
                            }

                            .all-menus ul li.parent {
                                position: relative;
                                border-bottom: 1px solid #ccc;
                                font-size: 15px;
                                padding: 5px 20px;
                            }

                            .all-menus ul>li>ul {
                                width: 200px;
                                position: absolute;
                                left: 100%;
                                top: 0;
                                display: none;
                                z-index: 999;
                                padding: 0;
                                margin: 0;
                            }

                            .all-menus {
                                padding: 0 !important;
                            }

                            .all-menus ul.parent-list {
                                list-style: none;
                                margin: 0;
                                padding: 0;
                            }

                            .all-menus ul>li>ul>li {
                                font-size: 13px;
                                padding: 5px 20px;
                                border-bottom: 1px solid #ccc;
                            }

                        </style>
                        <div class="row">
                            <div class="col-xs-3">
                                <h3>All Menus</h3>
                                <hr>
                                <div class="content__box content__box--shadow all-menus">
                                    <ul class="parent-list">
                                        @foreach($all_categories as $category)
                                        <li class="parent">
                                            <a href="javasacript::void(0)" class="category-product"
                                                data-category="{{$category->id}}"
                                                data-name="{{$category->name}}">{{$category->name}}</a>
                                            @if($category->children)
                                            <ul style="list-style: none;" class="content__box--shadow">
                                                @foreach($category->children as $cat)
                                                <li style="position: relative;">
                                                    <a href="javasacript::void(0)" class="category-product"
                                                        data-category="{{$cat->id}}"
                                                        data-name="{{$cat->name}}">{{$cat->name}}</a>
                                                    @if($cat->children )
                                                    <ul style="list-style: none;" class="content__box--shadow">
                                                        @foreach($cat->children as $child )
                                                        <li style="position: relative;">
                                                            <a href="javasacript::void(0)" class="category-product"
                                                                data-category="{{$child->id}}"
                                                                data-name="{{$child->name}}">{{$child->name}}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @if(isset($existing))
                            <div class="col-xs-9">
                                <h3>Your Selected Category: <span style="color: red"> <input type="text"
                                            value="{{ $existing->categories ? $existing->categories->first()->name : '' }}"
                                            id="category_name" class="product--hidden-category" readonly /></span></h3>

                                <hr>
                                <input type="hidden"
                                    value="{{ $existing->categories ? $existing->categories->first()->id : '' }}"
                                    id="category_id" name="category_id" />
                            </div>
                            @else
                            <div class="col-xs-9 form-group">
                                <h3 style="display:inline-block;">Your Selected Category is:</h3>
                                <input type="text" value="" id="category_name" name="category"
                                    class="product--hidden-category" readonly />
                                <hr>
                                <input type="hidden" value="" id="category_id" name="category_id" />
                            </div>
                            @endif
                        </div>

                    </section>
                </div>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                <input type="button" name="next" class="next action-button" value="Next Step" />
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <h2 class="fs-title">Seo Information</h2>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">Seo Title</label>
                            <input type="text" name="seo_title" class="form-control" placeholder="Product Seo Title"
                                value="{{ isset($data) ? $data->seo_title : old('seo_title') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="name">Seo Keyword</label>
                            <input type="text" class="form-control" name="seo_keyword" placeholder="Product Seo Keyword"
                                value="{{ isset($data) ? $data->seo_keyword : old('seo_keyword') }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="quantity" class="control-label">Seo Description</label>
                            <br>
                            <input type="text" name="seo_description"
                                value="{{ isset($data) ? $data->quantity : old('quantity') }}" class="form-control"
                                placeholder="Product Seo Description">
                        </div>
                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                <input type="button" name="next" class="next action-button" value="Next Step" />
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <h2 class="fs-title">Attributes Information</h2>
                    <div class="row">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="control-group">
                                    <div class="widget-box">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <div class="table-responsive">
                                                    <table id="sample-table-1"
                                                        class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th style="color:red">S.N</th>
                                                                <th>SKU</th>
                                                                <th>Size</th>
                                                                <th>Color</th>
                                                                <th>Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="attribute_loader_wrapper">
                                                            @if (isset($data['product']) &&
                                                            isset($data['product_attribute_spec']) &&
                                                            $data['product_attribute_spec']->count() > 0)
                                                            @foreach($data['product_attribute_spec'] as $spec)
                                                            <tr>
                                                                <td>
                                                                    {!! Form::select('attribute_groups[]',
                                                                    $data['attribute_groups'],
                                                                    $spec->product_attribute_group_id, ['class' =>
                                                                    'form-control']) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::select('attributes[]',
                                                                    $data['attributes'], $spec->product_attribute_id,
                                                                    ['class' => 'form-control']) !!}
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="value[]"
                                                                        value="{{ $spec->value }}" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                        <button type="button"
                                                                            class="btn btn-xs btn-danger"
                                                                            onclick="$(this).closest('tr').remove();">
                                                                            <i class="icon-trash bigger-120"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-actions center">
                                                <button type="button" id="attributes_add"
                                                    class="btn btn-sm btn-success">
                                                    Add More Attribute
                                                    <i class="icon-arrow-right icon-on-right bigger-110"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                <input type="submit" name="submit" class="next action-button btn btn-success btn-sm" />
            </fieldset>
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
