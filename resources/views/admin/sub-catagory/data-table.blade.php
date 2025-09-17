@if(!@empty($sub_categories))
@foreach ($sub_categories as $sub_category)
    <tr>
        <td>{{ $sub_category->name }}</td>
        <td>{{ $sub_category->slug }}</td>
        <td>{{ $sub_category->user->name }}</td>
        <td>{{ $sub_category->category->name }}</td>
        <td><span class="label label-success">{{ $sub_category->is_active ? 'Active' : 'Inactive' }}</span></td>
        <td>
            <a class="btn btn-outline-success legitRipple" aria-expanded="false" id="js-edit-sub-category-button" data-id="{{ $sub_category->id }}">Edit</a>
            <a class="btn btn-outline-danger legitRipple" aria-expanded="false" id="js-delete-sub-category-button" data-id="{{ $sub_category->id }}">Delete</a>
        </td>
    </tr>
@endforeach
@else
    <tr>
        <td colspan="6" class="text-center text-muted">
            No sub categories found.
        </td>
    </tr>
@endif