<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm-2" id="filter_cats">
                        <select name="" class="form-control">
                            <option class="form-control">
                            <option>Sort / Filter By </option>
                            <option>E-Mail</option>
                            <option>Full Names</option>
                            <option>Status</option>
                            <option>option 4</option>
                            <option>option 5</option>
                        </select>
                    </div>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" wire:model.debounce.900ms="search"
                                class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" id="tables">
                    <div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> <a href="javascript:void(0)" class="anchor_colors">
                                            <i class="fas fa-angle-{{ request()->get('sortBy') == 'created_at'
                                    && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy"
                                                wire:click="sortBy('id','{{ $sorting }}')" sortBy="created_at"></i>
                                            S.N</a></th>
                                    <th><a href="javascript:void(0)" class="anchor_colors"><i class="fas fa-angle-{{ request()->get('sortBy') == 'full_name'
                                && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                                                wire:click="sortBy('full_name','{{ $sorting }}')" sortBy="full_name">
                                            </i>Full Names</a></th>
                                    <th> <a href="javascript:void(0)" class="anchor_colors">
                                            <i class="fas fa-angle-{{request()->get('sortBy') == 'email'
                                && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                                                wire:click="sortBy('email','{{ $sorting }}')" sortBy="email">
                                            </i>E-Mail</a>
                                    </th>
                                    <th>Roles {{ getOrderByParam('sort') }}</th>
                                    <th>Images</th>
                                    <th>Updated Date</th>
                                    <th><a href="javascript:void(0)" class="anchor_colors"><i class="fas fa-angle-{{ request()->get('sortBy') == 'status'
                                && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy" sortBy="status">
                                            </i>Status</a></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key=>$user)
                                <tr>
                                    <td>{{ $key+1}}</td>
                                    <td>{{ $user->full_name  }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->roles)
                                        @foreach ($user->roles as $role)
                                        <span style="color:red">{{$role->name}}</span>
                                        <br>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ show_image($folder_name,$user->image) }}" data-lightbox="mygallery"
                                            id="thumb_a">
                                            <img src="{{ show_image($folder_name,$user->image) }}"
                                                class="profile-user-img img-responsive img-circle"
                                                alt="{{ $user->name }}" id="thumb" data-lightbox="mygallery">
                                        </a>
                                    </td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <div>
                                            <input type="checkbox" name="status" wire:click="'statusChange(3)'" value="1" data-size="mini"
                                                class="status" data-toggle="toggle" data-onstyle="success" data-id="{{ $user->id }}"
                                                {{ $user->status == 1 ? 'checked="checked"': '' }}>
                                        </div>
                                    </td>
                                    @php
                                    $user_id = $user->id;
                                    @endphp
                                    <td>
                                        <a href="{{ route($base_route.'.show',$user->id) }}" class="btn btn-success"
                                            title="Show {{ $panel }} Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a class="btn btn-info" href="{{ route($base_route.'.edit',$user->id) }}"
                                            title="Edit {{ $panel }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a class="btn btn-danger" id="delete" data_id="{{ $user->id }}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
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

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>

@push('scripts')
<script>

    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('element.updated', (el, component) => {
            $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
        })

    })


</script>
@endpush
