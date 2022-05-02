@extends('layouts.app')

@section('title', 'My Cart')

@section('styles')
@endsection


@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="show-cart table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price per one</th>
                    <th>Product Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($carts))
                @foreach ($carts as $key=>$cart)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td><img src="/{{ $cart->image }}" alt="" width=100></td>
                    <td>{{ $cart->name }}</td>
                    <td>${{ $cart->price }}</td>
                    <td>{{ $cart->quantity }}</td>
                    <td>${{ $cart->subtotal }}</td>
                    <td>
                        <button class="delete-item btn btn-danger btn-sm p-2 btn-inline shadow rounded m-2" rowId="{{ $cart->id }}"><i class="fa fa-trash" aria-hidden="true"></i> Remove</button>
                    </td>
                </tr>
                
            </tbody>
                @endforeach
                <tfoot>
                    @php
                        $subtotal = 0;
                        foreach ($carts as $cart) {
                            $subtotal += $cart->subtotal;
                        }
                    @endphp
                    <tr>
                        <td colspan="6" class="text-right text-danger">Subtotal: <span class="total-price">${{$subtotal}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right"><button class="checkout btn btn-warning">Checkout</button></td>
                    </tr>
                </tfoot>
                @else 
                <tr>
                    <td colspan="4">No Product in Cart</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/product.js') }}"></script>
@endsection