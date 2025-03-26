<!-- Modal -->
<div wire:ignore.self class="modal fade" id="update_form_model" tabindex="-1" role="dialog" aria-labelledby="update_form_model_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="update_form_model_label">Edit Category Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form">
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

                    <div class="form-group" >
                        <label for="description" class="control-label col-sm-2">Description </label>
                        <div class="col-sm-12" >
                              <div wire:ignore>
                            <textarea class="form-control"  id="edit_description" wire:model.defer="description"  name="description"></textarea>
                        </div>
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
                            <select name="parent_id" id="parent_id" class="form-control" wire:model.lazy="parent_id">
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
                            <input type="file" name="image" id="image" wire:model="image">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                @php
                                $thumbnail = asset($images_path.'/defaults.png');

                                if(isset($current_image) && $current_image != null && file_exists('storage/Uploads/Category/'.$current_image)){
                                $thumbnail = asset('storage/Uploads/Category/'.$current_image);
                                }

                                if(isset($image)){
                                    $thumbnail = $image->temporaryUrl();
                                }


                                @endphp
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
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary">Save changes</button>
            </div>
       </div>
    </div>
</div>
