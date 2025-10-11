@if(!empty($cart))
  @foreach($cart as $productId=> $item)
    <tr>
     <td>{{ $loop->iteration }}</td>
      <td>{{ $item['name'] }}</td>
      <td>{{ $item['quantity'] }}</td>
      <td>{{ $item['price'] }}</td>
      <td>{{ $item['total'] }}</td>
      <td>{{ $item['available_qty'] }}</td>
      <td>
        <button
            class="btn btn-danger btn-sm js-remove-cart"
            data-id="{{ $productId }}">
            Remove
        </button>
    </td>


    </tr>
  @endforeach

@if(!empty($cart))
<tr>
    <td colspan="4" class="text-right font-weight-bold">Grand Total:</td>
    <td colspan="2" class="font-weight-bold" id="js-grand-total">
        {{ number_format($grandTotal ?? 0, 2) }}
    </td>
</tr>
@endif
@else
  <tr><td colspan="5" class="text-center">No products added</td></tr>
@endif
