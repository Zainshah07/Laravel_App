@extends('admin.layout.index')
@section('css')
@endsection
@section('page')
    POS product entery
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Select Products</h5>
    </div>
    <div class="card-body">
        <form id="js-add-to-cart">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-5">
                        <label>Choose Product</label>
                        <select class="form-control" id="js-product-dropdown" name="product_id" required>
                            <option value="" selected disabled>Select Product</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label>Quantity</label>
                        <input type="number" placeholder="Enter product quantity"
                               name="quantity" id="js-product-quantity"
                               value="1" min="1" class="form-control" required>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary my-2">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <table class="table datatable-basic" id="PosTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Cost</th>
                <th>Available Stock</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="js-pos-table-body">
            @include('pos.data-table')
        </tbody>
    </table>



</div>
 <div class="text-right mr-4">
        <button class="btn btn-danger m-2 " id="js-check-out">Check Out</button>
    </div>
@endsection

@section('js')
<script>
$(document).ready(function () {

    getDynamicDropdownData("{{ route('get.products') }}", "#js-product-dropdown");
    $("#js-product-dropdown").trigger('change');
    $(".form-control").removeClass("is-valid is-invalid");

    $('#js-add-to-cart').validate({
        rules: {
            product_id: { required: true },
            quantity: { required: true, min: 1 }
        },
        messages: {
            product_id: { required: "Choose a product" },
            quantity: { required: "Enter the quantity" }
        },
        errorElement: 'small',
        errorClass: 'text-danger',
        errorPlacement: (error, element) => error.insertAfter(element),
        highlight: (element) => $(element).addClass('is-invalid'),
        unhighlight: (element) => $(element).removeClass('is-invalid'),

        submitHandler: function (form, event) {
            event.preventDefault();
            console.log($(form).serialize());

            $.ajax({
                url: "{{ route('pos.addToCart') }}",
                type: "POST",
                data: $(form).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',

                success: function (res) {
                    if (res.success) {
                        $('#js-pos-table-body').html(res.html);
                        form.reset()
                    } else {
                        toastr.error(res.message);
                    }
                },
               error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON?.message) {
                        toastr.error(xhr.responseJSON.message); // 🔥 show backend error
                    } else {
                        toastr.error("Something went wrong. Please try again.");
                    }
                }
            });
        }
    });

    // 🗑 Remove from Cart
    $(document).on('click', '.js-remove-cart', function (e) {
        e.preventDefault();

        let productId = $(this).data('id');

        $.ajax({
            url: "{{ route('pos.destroy') }}",
            type: "DELETE",
            data: { product_id: productId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (res) {
                if (res.success) {

                    $('#js-pos-table-body').html(res.html);


                    $('#js-grand-total').text(res.grandTotal ?? 0);
                } else {
                    toastr.error(res.message || 'Unable to remove product.');
                }
            },
            error: function () {
                toastr.error("Something went wrong. Please try again.");
            }
        });
    });



    //store after checkout starts here

     $('#js-check-out').on('click', function (e) {
        e.preventDefault();

        var $btn = $(this);
        $btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: "{{ route('pos.store') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            dataType: 'json',
            success: function (res) {
                if (res.success) {

                    $('#js-pos-table-body').html(res.html);
                    toastr.success(res.message || 'Order placed');
                } else {
                    toastr.error(res.message || 'Could not place order');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.message) {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Server error. Try again.');
                }
            },
            complete: function () {
                $btn.prop('disabled', false).text('Checkout');
            }
        });
    });

});
</script>
@endsection

