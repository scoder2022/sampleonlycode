<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th> <i class="fa fa-angle-{{ request()->get('sortBy') == 'id'
            && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy" sortBy="id"></i> S.N</th>
            <th> <i class="fa fa-angle-{{ request()->get('sortBy') == 'first_name'
            && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                    sortBy="first_name"></i>Names</th>
            <th><i class="fa fa-angle-{{request()->get('sortBy') == 'email'
            && getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy" sortBy="email"></i>Categories
            </th>
            <th>Price</th>
            <th>Images</th>
            <th>Updated Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $product)
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $product->name  }}</td>
            <td>
                @forelse ($product->categories as $cats)
                {{ $cats->name }}
                @empty
                    -
                @endforelse
            </td>
            <td>
                @if($product->roles)
                @foreach ($product->roles as $role)
                <span style="color:red">{{$role->name}}</span>
                @endforeach
                @endif
            </td>
            <td>
                <a href="{{ show_image($product->image) }}" data-lightbox="mygallery" id="thumb_a">
                    <img src="{{ show_image($product->image) }}" class="profile-user-img img-responsive img-circle" alt="current_image" id="thumb" data-lightbox="mygallery">
                 </a>
            </td>
            <td>{{ $product->updated_at !='' ? $product->updated_at : $product->created_at }}</td>
            <td>
                <input type="checkbox" name="status" value="1" class="status" data-toggle="toggle" data-onstyle="success"
                data-id="{{ $product->id }}" {{ $product->status == 1 ? 'checked="checked"': '' }} data-size="mini">
            </td>
            @php
            $product_id = $product->id;
            @endphp
            <td>
                <a class="btn btn-xs btn-success" title="Show {{ $panel }} Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a class="btn btn-xs btn-info" href="{{ route($base_route.'.edit',$product->id) }}" title="Edit {{ $panel }}">
                    <i class="fa fa-edit"></i>
                </a>

                <a class="btn btn-xs btn-danger" id="delete" data_id="{{ $product->id }}" title="Delete">
                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">
                <p class="text-center">Sorry No record </p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="col-sm-12">
    <div>
        {{ $data->links() }}
    </div>
</div>
