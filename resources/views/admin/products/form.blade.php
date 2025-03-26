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
            @foreach (config('app.available_locale') as $locale)
            <div class="form-group col-md-6">
                <label for="name_{{$locale}}">Name <a href="http://localhost/secret/public/admin/products/1/edit">ed</a> In {{__('custom.current_locale',[],$locale)}}</label>
                <input type="text" class="form-control" name="name_{{$locale}}" placeholder="Product title"
                    value="{{ isset($data) ? $data->name."_".$locale : old("name_$locale") }}" {{ $locale == app()->currentLocale() ? 'required' : '' }}>
                @error("name_{{$locale}}") <span class="error"><strong> {{ $message }} </strong></span> @enderror
            </div>
            @endforeach

             {{-- @php
                $sku = isset($data) ? $data->sku : old('sku');
                $sizes = isset($data) ? $data->attributes : old('sizes');
                $colors = isset($data) ? $data->colors : old('colors');
                $prices = isset($data) ? $data->prices : old('prices');
             @endphp --}}

            @if(old('sku'))
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="table-responsive">
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
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
                                                    @if(old('sku'))
                                                    @foreach (old('sku') as $key=>$sku)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><input type="text" name="sku[{{$key}}]" value="{{ $sku }}"></td>
                                                        <td>
                                                            <select class="form-control valid" name="sizes[{{ $key }}]" aria-invalid="false">
                                                            @foreach (config('custom.sizes') as $size)
                                                            <option value="{{ $size }}" {{ checked_values('select',$size,old('sizes')[$key]) }}>{{ strtoupper($size) }}</option>
                                                            @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group"><input type="text" name="colors[{{ $key }}]" value="{{ old('colors')[$key] }}"
                                                                        class="form-control my-colorpicker2 colorpicker-element" data-colorpicker-id="1" data-original-title="">
                                                                    <div class="input-group-addon"><i></i></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="prices[{{ $key }}]" value="{{ old('prices')[$key] }}"></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                <button type="button" class="btn btn-xs btn-danger remove_attr">
                                                                    <i class="fa fa-times"></i></button>
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
                                        <button type="button" id="attributes_add" class="btn btn-sm btn-success">
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
            @elseif(isset($data))
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="table-responsive">
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
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
                                                    @if ($data->attributes->isNotEmpty())
                                                    @foreach($data->attributes->toArray() as $key=>$spec)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><input type="text" name="sku[{{$key}}]" value="{{ $spec['sku'] }}"></td>
                                                        <td>
                                                            <select class="form-control valid" name="sizes[{{ $key }}]" aria-invalid="false">
                                                            @foreach (config('custom.sizes') as $size)
                                                            <option value="{{ $size }}" {{ checked_values('select',$size,$spec['sizes']) }}>{{ strtoupper($size) }}</option>
                                                            @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group"><input type="text" name="colors[{{ $key }}]" value="{{ $spec['colors'] }}"
                                                                        class="form-control my-colorpicker2 colorpicker-element" data-colorpicker-id="1" data-original-title="">
                                                                    <div class="input-group-addon"><i></i></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="prices[{{ $key }}]" value="{{ $spec['real_prices'] }}"></td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                <button type="button" class="btn btn-xs btn-danger remove_attr">
                                                                    <i class="fa fa-times"></i></button>
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
                                        <button type="button" id="attributes_add" class="btn btn-sm btn-success">
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
            @endif
                <div class="form-group col-md-3">
                    <label for="approvals">Select Approvals</label>
                    <select name="approvals" class="form-control">
                        <option selected disabled>Product Approvals</option>
                        <option {{ checked_values('select','Approved',$data->approvals ?? old('approvals')) }} value="Approved">
                            Approved </option>
                        <option {{ checked_values('select','Pending',$data->approvals ?? old('approvals')) }} value="Pending">
                            Pending </option>
                        <option {{ checked_values('select','Rejected',$data->approvals ?? old('approvals')) }} value="Rejected">
                            Rejected </option>
                    </select>
                @error("approvals") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="status">Select Status</label>
                    <select name="status" class="form-control">
                        <option selected disabled>Product Status</option>
                        <option value="1" {{ checked_values('select',1,$data->status ?? old('status')) }}>Show</option>
                        <option value="0" {{ checked_values('select',0,$data->status ?? old('status')) }}>Hide</option>
                    </select>
                    @error("status") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name"> Real Price </label>
                    <input type="text" class="form-control" name="real_price" id="real_price" placeholder="Product Real Price"
                        value="{{  $data->real_price ?? old('real_price') }}">
                    @error("real_price") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="name">Sale Price </label>
                    <input type="text" class="form-control" name="sale_price" placeholder="Product Sale Price"
                        value="{{  $data->price ?? old('sale_price') }}">
                    @error("sale_price") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="quantity" class="control-label">Quantity</label>
                    <br>
                    <input type="text" name="quantity" value="{{  $data->quantity ?? old('quantity') }}"
                        class="form-control" placeholder="Enter Quantity">
                    @error("quantity") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="negotiable">Negotiable</label>
                    <br>
                    <div class="icheck-success d-inline">
                        <input type="radio" name="negotiable" id="negotiable_yes" value="Yes"
                        {{ checked_values('check','yes',$data ?? old('negotiable')) }} >
                        <label for="negotiable_yes">Yes</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="negotiable" id="negotiable_no" value="No"
                        {{ checked_values('check','no',$data ?? old('negotiable')) }} >
                        <label for="negotiable_no">No</label>
                    </div>
                    <br>
                    @error("negotiable") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>
                <div class="form-group col-sm-3">
                    <label for="tax">Tax Applied</label>
                    <br>
                    <div class="icheck-success d-inline">
                        <input type="radio" name="tax" id="tax_yes" value="Yes"
                        {{ checked_values('check','yes',$data ?? old('tax')) }}>
                        <label for="tax_yes">Yes</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="tax" id="tax_no" value="No"
                        {{ checked_values('check','no',$data ?? old('tax')) }}>
                        <label for="tax_no">No</label>
                    </div>
                    <br>
                    @error("tax") <span class="error"><strong> {{ $message }} </strong></span> @enderror
                </div>

                <div class="form-group col-sm-6">

                    <label for="quality">Quality</label>
                    <br>
                    <div class="icheck-success d-inline">
                        <input type="radio" name="quality" id="brand_new" value="Brand New"
                        {{ checked_values('check','Brand New',$data ?? old('brand_new')) }}>
                        <label for="brand_new">Brand New</label>
                    </div>
                    <div class="icheck-primary d-inline">
                        <input type="radio" name="quality" id="used" value="Used"
                        {{ checked_values('check','Used',$data ?? old('quality')) }}>
                        <label for="used">Used</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        <input type="radio" name="quality" id="old" value="Old"
                        {{ checked_values('check','old',$data ?? old('Old')) }}>
                        <label for="old">Old</label>
                    </div>
                    <br>
                    @error("quality") <span class="error"><strong> {{ $message }} </strong></span> @enderror
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
    <div class="form-group col-md-6">
        <label for="name">Upload Images</label>
        <input type="file" id="file-input" name="images[]" onchange="loadPreview(this)" multiple>
        @error("images") <span class="error"><strong> {{ $message }} </strong></span> @enderror
    </div>

    <br>
    <div class="product-image-list">
        @if(isset($data) && count($data->images()->get()) > 0)
        @foreach($data->images()->get() as $key=>$image)
        <?php $class = ( $image->is_main_image == 1 ) ? "active" : ""; ?>
        <div class="image-preview">
            <div class="actual-image-thumbnail">
                <img class="img-thumbnail img-tag img-responsive" src="{{ asset(getProductImage($data->id,'small')) }}"
                    data-path="{{  getProductImage('small')  }}" />
                <input type="hidden" name="image" value="" />
                @if($image->is_main_image)
                <input type="hidden" class="is_main_image_hidden_field" name="image[{{ $image->id }}][is_main_image]"
                    value="1" />
                @else
                <input type="hidden" class="is_main_image_hidden_field" name="image[{{ $image->id }}][is_main_image]"
                    value="0" />
                @endif
            </div>
            <div class="image-info">
                <div class="image-title">
                    <a href="javascript:void(0);" title="{{  asset(getProductImage($data->id,'small'))  }}">
                        <img src="{{ asset(getProductImage($data->id,'small')) }}" alt="">
                        {{ str_limit( getProductImage('small') , 20) }}
                    </a>
                </div>
                <div class="actions">
                    <div class="action-buttons">
                        <span class="selected_images">
                            <button type="button" title="Select as main image"
                                class="btn btn-xs btn-info is_main_image_button {{ $class }} selected-icon">
                            <i class="fas fa-check"></i>
                        </button>
                        </span>
                        <span>
                            <button type="button" class="destroy-image btn btn-xs btn-danger" title="Remove file">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>

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
            @error("short_description") <span class="error"><strong> {{ $message }} </strong></span> @enderror
    </div>
    <div class="form-group">
        <label for="password">Long Description</label>
        <textarea class="form-control ckeditor"
            name="long_description">{{ isset($data)?$data->long_description:old('long_description') }}</textarea>
            @error("long_description") <span class="error"><strong> {{ $message }} </strong></span> @enderror
    </div>
    </div>
    </div> <input type="button" name="next" class="next action-button" value="Next Step" />
</fieldset>
<fieldset>
    <div class="form-card">
        <h2 class="fs-title">Selection Category</h2>
        <section>
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
                                @if($category->children->count() > 0)
                                <ul style="list-style: none;" class="content__box--shadow">
                                    @foreach($category->children as $cat)
                                    <li style="position: relative;">
                                        <a href="javasacript::void(0)" class="category-product"
                                            data-category="{{$cat->id}}" data-name="{{$cat->name}}">{{$cat->name}}</a>
                                        @if($cat->children->count() > 0)
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
                    <input type="hidden" value="{{ $existing->categories ? $existing->categories->first()->id : '' }}"
                        id="category_id" name="category_id" />
                </div>
                @else
                <div class="col-xs-9 form-group">
                    <h3 style="display:inline-block;">Your Selected Category is:</h3>
                    <input type="text" value="" id="category_name" name="category" class="product--hidden-category"
                        readonly />
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
                    value="{{  $data->seo_title ?? old('seo_title') }}">
            @error("seo_title") <span class="error"><strong> {{ $message }} </strong></span> @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="name">Seo Keyword</label>
                <input type="text" class="form-control" name="seo_keyword" placeholder="Product Seo Keyword"
                    value="{{  $data->seo_keyword ?? old('seo_keyword') }}">
            @error("seo_keyword") <span class="error"><strong> {{ $message }} </strong></span> @enderror
            </div>

            <div class="form-group col-md-4">
                <label for="quantity" class="control-label">Seo Description</label>
                <br>
                <input type="text" name="seo_description" value="{{  $data->seo_description ?? old('seo_description') }}"
                    class="form-control" placeholder="Product Seo Description">
            @error("seo_description") <span class="error"><strong> {{ $message }} </strong></span> @enderror
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
                                                @php
                                                    if(isset($data)){
                                                        $product_attribute_spec = $data->product_attribute_spec;
                                                    }elseif (old('product_attribute_spec') !='') {
                                                        $product_attribute_spec = old('product_attribute_spec');
                                                    }
                                                @endphp
                                                @if(isset($product_attribute_spec))
                                                @foreach(array_chunk(unserialize($product_attribute_spec),4) as $spec)
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
                                                        <input type="text" name="value[]" value="{{ $spec->value }}"  title="Select A Color"
                                                         class="form-control my-colorpicker1 colorpicker-element" data-colorpicker-id="1" data-original-title="">
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                            <button type="button" class="btn btn-xs btn-danger"
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
                                    <button type="button" id="attributes_add" class="btn btn-sm btn-success">
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
