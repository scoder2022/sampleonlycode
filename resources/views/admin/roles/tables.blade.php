    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'id'
                && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy" sortBy="id"></i> S.N</th>
                <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'first_name'
                && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                        sortBy="first_name"></i>Full Names</th>
                <th>Updated Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($data !='')
            @foreach ($data as $key=>$role)
            <tr>
                <td>{{ $key+1}}</td>
               <td>{{ $role->name }}</td>
                <td>{{ $role->updated_at }}</td>
                @php
                $role_id = $role->id;
                @endphp
                <td>
                    <a class="btn btn-success" title="Show {{ $panel }} Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a class="btn btn-info" href="{{ route('admin.users.edit',$role->id) }}" title="Edit {{ $panel }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a class="btn btn-danger" id="delete" data_id="{{ $role->id }}" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="col-sm-12">
        <div>
            {{ $data->links() }}
        </div>
    </div>
