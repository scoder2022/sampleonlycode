<div>
    <div class="row">
        <div class="col-12">
          <div class="card">
              @include('admin.all.session_message')
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
                        <input type="text" name="search" wire:model.debounce.900ms="search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>

                    </div>
              </div>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                  Add New
              </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" id="tables">
             <div>

                <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><a href="javascript:void(0)" class="anchor_colors">
                            <i class="fas fa-angle-{{ request()->get('sortBy') == 'created_at'
                                && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy"
                                wire:click="sortBy('id','{{ $sorting }}')" sortBy="created_at"></i>
                                 S.N</a></th>
                        <th><a href="javascript:void(0)" class="anchor_colors"><i class="fas fa-angle-{{ request()->get('sortBy') == 'full_name'
                            && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                            wire:click="sortBy('full_name','{{ $sorting }}')"  sortBy="full_name">
                            </i>Full Names</a></th>
                            <th>Updated At</th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $permission)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name  }}</td>
                        <td>{{ $permission->updated_at }}</td>
                        <td class=" center">
                            <div class="center">
                                <span class="alert alert-{{ ($permission->status== 1
                            ? 'success' : 'danger' ) ? : 'info' }}">
                                    @if($permission->status == 1)
                                    Active
                                    @elseif($permission->status == 2)
                                    In-Activated
                                    @elseif ($permission->status == 0)
                                    Pending
                                    @endif
                                </span>
                            </div>
                        </td>
                        @php
                        $permission_id = $permission->id;
                        @endphp
                        <td>
                            <a href="{{ route($base_route.'.show',$permission->id) }}" class="btn btn-success" title="Show {{ $panel }} Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $permission->id }})" class="btn btn-primary btn-sm">Edit</button>

                            <a class="btn btn-info" href="{{ route($base_route.'.edit',$permission->id) }}" title="Edit {{ $panel }}">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a class="btn btn-danger" id="delete" data_id="{{ $permission->id }}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        </td>
                    </tr>
                    @empty
                    <div wire:loading>
                        <tr><td colspan="9"><p class="text-danger text-center">Sorry No {{ $panel }} Found </p></td></tr>
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

      <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Save Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @livewire('admin.permissions.form')
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

</div>

@push('scripts')
<script type="text/javascript">
    window.livewire.on('response', (type,message) => {
        $('#addModal').modal('hide');
        $('#updateModal').modal('hide');
        $.notify(message,type);
    });
</script>
@endpush
