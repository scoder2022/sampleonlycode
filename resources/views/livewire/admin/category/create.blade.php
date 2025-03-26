<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_model" wire:click='resetInputFields()'>Add New</button>

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="form_model" tabindex="-1" role="dialog" aria-labelledby="form_model_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="form_model_label">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
           <div class="modal-body">
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
                <form id="store_form">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Enter Name" wire:model.debounce.1000ms="name">

                        @error('name')
                        <span class="error"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" placeholder="Enter slug" wire:model.debounce.1000ms="slug">
                        @error('slug')
                        <span class="error"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group" wire:ignore>
                        <label for="description" class="control-label col-sm-2">Description</label>
                        <div class="col-sm-12" >
                             <textarea id="description" cols="30" rows="10"></textarea>
                            @error('description')
                            <span class="error">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="parent_id">Select Main Categories</label>
                        <div class="select2-purple col-sm-6">
                            <select name="parent_id" id="parent_id" class="form-control" wire:model.defer="parent_id">
                                <option value="0">Select Main Category</option>
                                @foreach($all_categories as $category)
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
                    @error('parent_id')
                        <span class="error"><strong>{{ $message }}</strong></span>
                    @enderror

                    <div class="form-group">
                        <label for="image" class="control-label">Upload Image</label>
                        <div class="col-sm-6">
                            <input type="file" name="image" id="image" wire:model.defer="image">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                @php $thumbnail = $image ? $image->temporaryUrl() : $images_path.'/defaults.png'; @endphp
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <span class="error"><strong>{{ $message }}</strong></span>
                    @enderror
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <label for="images" class="control-label">Current Images</label>
                        <div class="col-sm-6">
                            <a href="{{ $thumbnail }}" data-lightbox="mygallery" id="thumb_a">
                                <img src="{{ $thumbnail }}" class="img-thumbnail rounded"
                                    style="width: 200px" alt="current_image" id="thumb"
                                    data-lightbox="mygallery">
                            </a>
                        </div>
                    </div>
                    <label for="status">Status</label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch" wire:model.lazy="status">
                        <label class="custom-control-label" for="customSwitch"></label>
                      </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                <button type="button" wire:loading.attr="disabled" @disabled($errors->isNotEmpty()) wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
