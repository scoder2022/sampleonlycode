<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'id'
            && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy" sortBy="id"></i> S.N</th>
            <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'first_name'
            && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                    sortBy="first_name"></i>Names</th>
            <th>Parent Category</th>
            <th>Child Category</th>
            <th>Images</th>
            <th>Updated Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if($data->count() > 0)
        @foreach ($data as $key=>$category)
        <tr>
            <td>{{ $key+1}}</td>
            <td>{{ $category->name }}</td>
            <td>{{ isset($category->parent) && $category->parent->name != ''
                ? $category->parent->name : 'IS Main Category' }}</td>
            <td>{{ isset($category->parent) && $category->parent->name != ''
                ? $category->parent->name : 'IS Child Category' }}</td>
            <td>
                @if ($category->image !='' && Storage::exists($folder_path.DIRECTORY_SEPARATOR.$category->image))
                <img src="{{ asset($images_path.$category->image) }}" alt="">
                @else
                @endif
            </td>
            <td>{{ $category->updated_at }}</td>
            <td class=" center">
                <div class="center">
                    <span class="alert alert-{{ ($category->status== 1
                ? 'success' : 'danger' ) ? : 'info' }}">
                        @if($category->status == 1)
                        Active
                        @elseif($category->status == 2)
                        In-Activated
                        @elseif ($category->status == 0)
                        Pending
                        @endif
                    </span>
                </div>
            </td>
            @php
            $category_id = $category->id;
            @endphp
            <td>
                <a class="btn btn-success" title="Show {{ $panel }} Detail">
                    <i class="fas fa-eye"></i>
                </a>

                <a class="btn btn-info" href="{{ route($base_route.'.edit',$category->id) }}" title="Edit {{ $panel }}">
                    <i class="fas fa-edit"></i>
                </a>

                <a class="btn btn-danger" id="delete" data_id="{{ $category->id }}" title="Delete">
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
