@if (!@empty($categories))
    @foreach ($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }} </td>
            <td>{{ $category->user_id }}</td>
            <td><span class="label label-success">{{ $category->is_active }}</span></td>
            <td> <a href="" type="button" class="btn btn-outline-success legitRipple" aria-expanded="false">Update</a></td>
            <td> <a href="" type="button" class="btn btn-outline-danger legitRipple" aria-expanded="false">Delete</a></td>

        </tr>
    @endforeach
@else
  <tr>
        <td colspan="6" class="text-center text-muted">
            No categories found.
        </td>
    </tr>

@endif
