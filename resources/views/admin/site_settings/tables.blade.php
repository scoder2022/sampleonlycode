    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>S.N</th>
                <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'first_name'
                && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                    sortBy="first_name"></i>Title</th>
                <th>Value</th>
                <th><i class="fas fa-angle-{{ request()->get('sortBy') == 'id'
                    && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy"
                        sortBy="id"></i>Created Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($data !='')
            @foreach ($data as $key=>$user)
            <tr>
                <td>{{ $key+1}}</td>
                <td>{{ $user->title }}</td>
                <td>{{ $user->value }}</td>
                <td>{{ $user->updated_at }}</td>
                <td class=" center">
                    <div class="center">
                        <span class="alert alert-{{ ($user->status== 1
                    ? 'success' : 'danger' ) ? : 'info' }}">
                            @if($user->status == 1)
                            Active
                            @elseif($user->status == 2)
                            In-Activated
                            @elseif ($user->status == 0)
                            Pending
                            @endif
                        </span>
                    </div>
                </td>
                @php
                $user_id = $user->id;
                @endphp
                <td>
                    <a class="btn btn-success" title="Show {{ $panel }} Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a class="btn btn-info" title="Edit {{ $panel }}">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a class="btn btn-danger" id="delete" data_id="{{ $user->id }}" title="Delete">
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
