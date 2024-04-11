@extends('front.layouts.app')

@section('content')
    <section class=" section-9 pt-4">
        <div class="container">
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    @if ($cartItems->isEmpty())
                        <div class="alert alert-primary">
                            Your cart is empty.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table" id="cart">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>

                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('storage/' . $cartItem->product->image) }}"width=""
                                                        height="">
                                                    <h2>{{ $cartItem->product->title }}</h2>
                                                </div>
                                            </td>
                                            <td>{{ $cartItem->product->price }}</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1"
                                                            onclick="updateQuantity({{ $cartItem->id }},'decrement')">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm border-0 text-center quantity-input"
                                                        value="{{ $cartItem->quantity }}"
                                                        data-cart-item-id="{{ $cartItem->id }}">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1"
                                                            onclick="updateQuantity({{ $cartItem->id }},'increment')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="total-price">
                                                {{ $cartItem->itemTotal }}
                                            </td>

                                            <td>
                                                <button onclick="DeleteCartItem({{ $cartItem->id }})"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div> $<span id="total">{{ $total }}</span></div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$20</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{ $total + 20 }}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{ route('account.checkout') }}" class="btn-dark btn btn-block w-100">Proceed to
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
@endsection
@section('customJs')
    <script>
        var total = 0;

        function DeleteCartItem(id) {
            var url = "{{ route('delete.single.cartItem', 'ID') }}"
            var newUrl = url.replace("ID", id)
            $.ajax({
                url: newUrl, // Update with your actual route
                type: "delete",
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response if needed
                    window.location.href = "{{ route('get.cart') }}";
                },
                error: function(error) {
                    // Handle error response if needed
                    console.error(error);
                }
            });
        }

        function updateQuantity(cartItemId, action) {
            var quantityInput = $('.quantity-input[data-cart-item-id="' + cartItemId + '"]');
            var currentQuantity = parseInt(quantityInput.val());
            if (action === 'increment') {
                quantityInput.val(currentQuantity + 1);
            } else if (action === 'decrement' && currentQuantity > 1) {
                quantityInput.val(currentQuantity - 1);
            }
            updateCartQuantity(cartItemId, quantityInput.val());
        }


        function updateCartQuantity(cartItemId, newQuantity) {
            $.ajax({
                url: "{{ route('edit.cart.quantity') }}", // Update with your actual route
                method: 'PATCH',
                data: {
                    cartItemId: cartItemId,
                    newQuantity: newQuantity
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle success response if needed
                    window.location.reload();

                },
                error: function(error) {
                    // Handle error response if needed
                    console.error(error);
                }
            });
        }
    </script>
@endsection
