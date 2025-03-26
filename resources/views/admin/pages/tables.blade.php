    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'id'
                && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }} sortBy" sortBy="id"></i> S.N</th>
                <th> <i class="fas fa-angle-{{ request()->get('sortBy') == 'id'
                && SiteHelper::getOrderByParam('sort') == 'desc' ? 'down' : 'up' }}  sortBy"
                        sortBy="user_id"></i>Name</th>
                        <th>Contents</th>
                        <th>Added By</th>
                        <th>Images</th>
                <th>Updated Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @forelse($data as $page)
            <div class="base_tr">
            <tr>
                <td>{{ $loop->iteration}}</td>
                <td>{{ $page->name  }}</td>
                <td>{!! str_limit($page->contents,26) !!}</td>
                <td>{{ $page->user->email }}</td>
                <td>
                    <div class="text-center">
                        @if ($page->image !=null && Storage::exists($page->image))
                        <a href="{{ Storage::url($page->image) }}" data-lightbox="mygallery">
                            <img src="{{ Storage::url($page->image) }}" alt="{{ $page->name }}" style="width: 100px"></a>
                            @else
                            <a href="{{ $images.'/defaults.png' }}" data-lightbox="mygallery">
                            <img src="{{ asset($images.'/defaults.png') }}" alt="{{ $page->name }}"
                            style="width: 100px"></a>
                        @endif
                    </div>

                </td>
                <td>{{ $page->updated_at }}</td>
                <td class=" center">
                    <div class="center">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                              <input type="checkbox" class="custom-control-input status" id="customSwitch3">
                              <label class="custom-control-label" for="customSwitch3"></label>
                            </div>
                    </div>
                </td>
                @php
                $page_id = $page->id;
                @endphp
                <td>
                    <div class="text-center">
                        <a class="btn btn-success" title="Show {{ $panel }} Detail">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a class="btn btn-info" href="{{ route('admin.pages.edit',$page->id) }}" title="Edit {{ $panel }}">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a class="btn btn-danger" id="delete" data_id="{{ $page->id }}" title="Delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>

                </td>
                </td>
            </tr>
            </div>
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
