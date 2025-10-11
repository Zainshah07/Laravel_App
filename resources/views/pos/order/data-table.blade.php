 @forelse($orders as $order)
     <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{ $order->invoice_no }}</td>
         <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
         <td>{{ number_format($order->total_amount, 2) }}</td>
         <td>
             <button data-id="{{ $order->id }}" class="btn btn-sm btn-primary js-view-order">
                 View
             </button>
         </td>
     </tr>
 @empty
     <tr>
         <td colspan="5" class="text-center text-muted">
             No orders found.
         </td>
     </tr>
 @endforelse
