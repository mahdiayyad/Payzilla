@extends('layouts.app')

@section('title', 'Items')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded p-5">
        <div class="row">
            <div class="col-md-6">
                <img src="/{{ $product[0]->image }}" alt="">
                <div class="clearfix">
                    <div class="hint-text">Showing <b>1</b> out of <b>4</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#">Previous</a></li>
                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">Next</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                  <div class="float-right">
                    <a href="{{ route('product.purchase', $product[0]->id) }}" class="btn btn-warning btn-inline p-2 shadow rounded m-2"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy now</a>
                  </div>
                    <h4 class="card-title font-weight-bold">{{ $product[0]->name }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">${{ $product[0]->price }} USD</h6>
                    <h6 class="card-subtitle mb-2 text-muted py-2">{{ $product[0]->availability }}</h6>
                    <p class="card-text py-4">
                        {{-- {{ $product[0]->description }} --}}
                        Featuring soft foam cushioning and lightweight, 
                        woven fabric in the upper, the Jordan Proto-Lyte is made for all-day, 
                        bouncy comfort. Lightweight Breathability: Lightweight woven fabric 
                        with real or synthetic leather provides breathable support. Cushioned Comfort: 
                        A full-length foam midsole delivers lightweight, plush cushioning. Secure 
                        Traction: Exaggerated herringbone-pattern outsole offers 
                        traction on a variety of surfaces.
                    </p>
                    <form method='post' action='{{ route('product.addToCart', $product[0]->id) }}'>
                        @csrf
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="9" value="1" style="width:50%">
                            <input type='hidden' class='item-price' name='price' value='{{ $product[0]->price }}'>
                            <input type='hidden' class='item-price' name='name' value='{{ $product[0]->name }}'>
                            {{-- <input type='hidden' name='subtotal' value='{{ $product[0]->price }}'> --}}
                        </div>
                    <button class="add-to-cart btn btn-warning p-2 btn-inline shadow rounded m-2" btnId="{{ $product[0]->id }}" data-name="{{ $product[0]->name }}" data-price="{{ $product[0]->price }}"><i class="fa fa-cart-plus"></i> Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

 <!-- Modal -->
 {{-- <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
        <form method='post' action='{{ route('product.addToCart', $product[0]->id) }}'>
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @csrf
            <button class="clear-cart btn btn-danger mb-3">Clear Cart</button>
              
            <table class="show-cart table">

            </table>
            <div>Total price: $<span class="total-cart"></span></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Order now</button>
        </div>
      </form>
      </div>
    </div>
  </div>  --}}

@section('scripts')
<script src="{{ asset('js/product.js') }}"></script>
@endsection