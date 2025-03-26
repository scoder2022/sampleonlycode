<div>
    @include('admin.all.session_message')
    @include('livewire.admin.category.create')
    @include('livewire.admin.category.update')
    <div class="card">
        <div class="card-header">
            {{-- <div class="col-sm-2" id="filter_cats">
                <select name="" class="form-control">
                    <option class="form-control">
                    <option>Sort / Filter By </option>
                    <option>E-Mail</option>
                    <option>Full Names</option>
                    <option>Status</option>
                    <option>option 4</option>
                    <option>option 5</option>
                </select>
            </div> --}}
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="search" wire:model.debounce.750ms="search"
                        class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" id="tables">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><span class="text-sm" style="cursor: pointer">S.N
                            <i class="fa fa-arrow-up {{ $sortBy== 'id' && $sorting == 'asc'?'':'text-muted' }}"
                             wire:click="sortBy('id','{{ $sorting }}')"></i>
                            <i class="fa fa-arrow-down {{ $sortBy== 'id' && $sorting == 'desc'?'':'text-muted' }}"
                             wire:click="sortBy('id','{{ $sorting }}')"></i>
                            </span></th>
                            <th><span class="text-sm" style="cursor: pointer">Category Names
                                <i class="fa fa-arrow-up {{ $sortBy== 'name' && $sorting == 'asc'?'':'text-muted' }}"
                                 wire:click="sortBy('name','{{ $sorting }}')"></i>
                                <i class="fa fa-arrow-down {{ $sortBy== 'name' && $sorting == 'desc'?'':'text-muted' }}"
                                 wire:click="sortBy('name','{{ $sorting }}')"></i>
                                </span></th>
                            <th> Parent</th>
                        <th>Images</th>
                        <th>Updated Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ isset($category->parent) !=''?$category->parent->name :''}}</td>
                        <td>
                            <a href="{{ show_image('Category',$category->image) }}" data-lightbox="mygallery"
                                id="thumb_a">
                                <img src="{{ show_image('Category',$category->image) }}"
                                    class="profile-user-img img-responsive img-circle"
                                    alt="{{ $category->name }}" id="thumb" data-lightbox="mygallery">
                            </a>
                        </td>
                        <td>{{ $category->updated_at !='' ? $category->updated_at : $category->created_at }}</td>
                        <td>
                            {{-- <button class="testf" type="button" class="btn btn-info btn-sm">Testf</button> --}}
                            <div>

                                <input type="checkbox" name="status" value="1" data-size="mini" wire:change="$emitSelf('updateStatus')"
                                    data-forc="User" class="status" data-toggle="toggle" data-onstyle="success" data-id="{{ $category->id }}"
                                    {{ $category->status == 1 ? 'checked="checked"': '' }}>
                            </div>
                        </td>
                        @php
                        $category_id = $category->id;
                        @endphp
                        <td>

                            <a href="{{ route($this->base_route.'.show',$category->id) }}" class="btn btn-success btn-sm"
                                title="Show {{ $panel }} Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                           <a href="" data-toggle="modal" data-target="#update_form_model" wire:click="edit({{ $category->id }})" class="btn btn-primary btn-sm"
                            title="Show {{ $panel }} Detail">
                                <i class="fas fa-edit"></i>
                           </a>

                            <a class="btn btn-danger btn-sm" id="delete" data_id="{{ $category->id }}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <div wire:loading>
                        <tr>
                            <td colspan="9">
                                <p class="text-danger text-center">Sorry No {{ $panel }} Found </p>
                            </td>
                        </tr>
                    </div>
                    @endforelse

                </tbody>
            </table>
            <div class="col-sm-12">
                <div>
                    {{ $data->links() }}
                </div>
            </div>
    </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@push('scripts')
@include('admin.all.custom_scripts')
<script>

    function destroyck(){
        for(name in CKEDITOR.instances)
            {
                CKEDITOR.instances[name].destroy()
            }
    }
    function loadckeditor(){
        for(name in CKEDITOR.instances)
            {
                CKEDITOR.instances[name].destroy()
            }
        const editor = CKEDITOR.replace('description');
        editor.on('blur', function(e) {
            @this.set('description', e.editor.getData());
        });
        const edit_description = CKEDITOR.replace('edit_description');
        edit_description.on('blur', function(e) {
            @this.set('description', e.editor.getData());
        });
    }
    $(document).ready(function(){
        loadckeditor();
    });

    window.livewire.on('data_store', () => {
        $('#form_model').modal('hide');
        $('#update_form_model').modal('hide');
        $('#deleteCategoryModal').modal('hide');
    });

    Livewire.on('loadckeditor', () => {
        loadckeditor();
    })

    document.addEventListener('loading',function(){
        $.LoadingOverlay(event.detail.state, {
            image       : "",
            fontawesome : "fa fa-cog fa-spin"
        });
    })

    document.addEventListener('livewire:load', function () {
        loadStatus();
        Livewire.hook('element.updating', (fromEl, toEl, component) => {
            if (typeof cks === "undefined") {
                console.log('not');
        loadckeditor();
                cks = 'i am ';
            } else {
                console.log('yes');
            }

        })
        window.livewire.hook('message.processed', (message, component) => {
        Livewire.emit('loading');
        $(function(){ $("input[name=status]").bootstrapToggle() });
        loadStatus();
    })
    })
</script>
@endpush
