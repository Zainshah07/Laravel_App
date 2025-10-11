@if (!@empty($products))


    @foreach ($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->sku }}</td>
            <td>{{ optional($product->category)->name ?? 'No Category Found' }}</td>
            <td>{{ optional($product->sub_category)->name ?? 'No sub category Found' }}</td>
            <td><img src="{{ $product->images }}" alt="{{ $product->name }}" width="50" height="50"></td>
            <td>${{ $product->unit_price }}</td>
            <td>${{ $product->cost_price_per_unit }}</td>
            <td>
                <span class="badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                    {{ $product->is_active ? 'Active' : 'In-Active' }}
                </span>
            </td>
            @role('admin')
                <td style="display: flex; ">
                    <a class="btn btn-outline-success legitRipple mx-2" aria-expanded="false" id="js-edit-product-button"
                        data-id="{{ $product->id }}">Edit</a>
                    <a class="btn btn-outline-danger legitRipple" aria-expanded="false" id="js-delete-product-button"
                        data-id="{{ $product->id }}">Delete</a>
                </td>
            @endrole

        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center text-muted">
            No sub categories found.
        </td>
    </tr>
@endif
