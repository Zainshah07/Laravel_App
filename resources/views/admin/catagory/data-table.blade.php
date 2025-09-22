@if (!@empty($categories))
    @foreach ($categories as $category)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }} </td>
            <td>{{ $category->user_id }}</td>
            <td>
                <span class="badge badge-{{ $category->is_active ? 'success' : 'danger' }}">
                    {{ $category->is_active ? 'Active' : 'In-Active' }}
                </span>
            </td>
            <td>
                <a class="btn btn-outline-success legitRipple mx-2" aria-expanded="false" id="js-edit-category-button"
                    data-id="{{ $category->id }}">Edit</a>
                <a class="btn btn-outline-danger legitRipple" aria-expanded="false" id="js-delete-category-button"
                    data-id="{{ $category->id }}">Delete</a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center text-muted">
            No categories found.
        </td>
    </tr>

@endif
