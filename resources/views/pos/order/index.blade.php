@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
Orders
@endsection()
@section('content')
<div class="card">
    <table class="table datatable-basic" id="orderTable">
        <thead>
            <tr>
              <th>#</th>
                <th>Invoice</th>
                <th>Date</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="js-order-table-body">
            @include('pos.order.data-table')
        </tbody>
    </table>

        <!-- Order Details Modal -->

<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="js-order-details-body">

                <div class="text-center py-3 text-muted">
                    Select an order to view details.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('js')
<script>
$(document).ready(function () {
    // Handle View button click
    $(document).on('click', '.js-view-order', function () {
        let orderId = $(this).data('id');

        $.ajax({
            url: "{{ route('order.show', ':id') }}".replace(':id', orderId),
            type: "GET",
            dataType: "json",
            beforeSend: function () {
                $('#js-order-details-body').html('<p class="text-center py-3">Loading...</p>');
                $('#orderDetailsModal').modal('show');
            },
            success: function (res) {
                if (res.success) {
                    $('#js-order-details-body').html(res.html);
                } else {
                    $('#js-order-details-body').html('<p class="text-danger text-center py-3">' + res.message + '</p>');
                }
            },
            error: function (xhr) {
                $('#js-order-details-body').html('<p class="text-danger text-center py-3">Something went wrong.</p>');
            }
        });
    });
});
</script>

@endsection
