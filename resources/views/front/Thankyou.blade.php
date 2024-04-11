@extends('front.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-4">Thank You for Shopping with Us!</h2>
                        <p class="lead">Your order has been successfully placed. We appreciate your business.</p>
                        <p>Order ID: <strong>{{ $orderId }}</strong></p>

                        <div class="mt-4">
                            <p class="text-muted">For any inquiries, please contact our customer support.</p>
                            <p class="text-muted">You will receive an email confirmation shortly.</p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('front.home') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
