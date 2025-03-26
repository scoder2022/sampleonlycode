    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th> <a href="javascript:void(0)" class="anchor_colors">
                    <i class="fas fa-angle-{{ request()->get('sortBy') == 'created_at'
                        && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy" sortBy="created_at"></i>
                         S.N</a></th>
                <th><a href="javascript:void(0)" class="anchor_colors"><i class="fas fa-angle-{{ request()->get('sortBy') == 'full_name'
                    && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy" sortBy="full_name">
                    </i>Full Names</a></th>
                <th> <a href="javascript:void(0)" class="anchor_colors">
                    <i class="fas fa-angle-{{request()->get('sortBy') == 'email'
                    && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy" sortBy="email">
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
            @if($data !='')
            @foreach ($data as $key=>$user)
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
                    @if ($user->image !='' && Storage::exists($folder_path.DIRECTORY_SEPARATOR.$user->image))
                    <img src="{{ asset($images_path.$user->image) }}" alt="">
                    @else
                    @endif
                </td>
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
                    <a href="{{ route($base_route.'.show',$user->id) }}" class="btn btn-success" title="Show {{ $panel }} Detail">
                        <i class="fas fa-eye"></i>
                    </a>

                    <a class="btn btn-info" href="{{ route($base_route.'.edit',$user->id) }}" title="Edit {{ $panel }}">
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
