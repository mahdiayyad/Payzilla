@extends('layouts.app')

@section('title', 'Products')

@section('content')
 <!-- ***** Preloader Start ***** -->
 <div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>  
@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success',
            text: '{{ session('status') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif 
<!-- ***** Preloader End ***** -->

<!-- ***** Main Banner Area Start ***** -->
<div class="page-heading" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner-content">
                    <h2>Check Our Products</h2>
                    <span>Awesome &amp; Creative HTML CSS layout by Lorem</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->


<!-- ***** Products Area Starts ***** -->
<section class="section" id="products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h2>Our Latest Products</h2>
                    <span>Check out all of our products.</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-lg-4">
                <div class="item">
                    <div class="thumb">
                        <div class="hover-content">
                            <ul>
                                <li><a href="{{ route('product.show', $product->id) }}"><i class="fa fa-eye"></i></a></li>
                                <li><a href="single-product.html"><i class="fa fa-star"></i></a></li>
                                <li><a href="{{ route('product.purchase', $product->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        {{-- storage/images/men-01.jpg --}}
                        <img src="{{ $product->image }}" alt="">
                    </div>
                    <div class="down-content">
                        {{-- Classic Spring --}}
                        <h4>{{ $product->name }}</h4>
                        {{-- $120.00 --}}
                        <span>${{ $product->price }}</span>
                        <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

            
            <div class="col-lg-12">
                <div class="hint-text">Showing {{($products->currentpage()-1)*$products->perpage()+1}} to {{ $products->currentpage()*(($products->perpage() < $products->total()) ? $products->perpage(): $products->total())}} of {{ $products->total()}} entries</div>
                <div class="pagination">
                    <ul>
                        <li>
                            {!! $products->links() !!}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Products Area Ends ***** -->

<!-- ***** Footer Start ***** -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="first-item">
                    <div class="logo">
                        <h1 style="color:#fff;">Payzilla</h1>
                    </div>
                    <ul>
                        <li><a href="#">10235 Amman, Amman, Jordan</a></li>
                        <li><a href="#">mahdiayyad97@gmail.com</a></li>
                        <li><a href="#">+962 79 557 0175</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <h4>Shopping &amp; Categories</h4>
                <ul>
                    <li><a href="#">Shopping</a></li>
                    <li><a href="#">Shopping</a></li>
                    <li><a href="#">Shopping</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Links</a></li>
                    <li><a href="#">Links</a></li>
                    <li><a href="#">Links</a></li>
                    <li><a href="#">Links</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h4>Help &amp; Information</h4>
                <ul>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Information</a></li>
                </ul>
            </div>
            <div class="col-lg-12">
                <div class="under-footer">
                    <p>Copyright © {{ date('Y') }} Mahdi Ayd. All Rights Reserved.
                    
                    <br>Design: <a href="#" target="_parent" title="free css templates">Mahdi Ayyad</a></p>
                    <ul>
                        <li><a href="https://web.facebook.com/MahdiCSdev/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://twitter.com/MahdiAyyad4" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.linkedin.com/in/mahdi-ayyad-943143201/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://github.com/mahdiayyad" target="_blank" ><i class="fa fa-github"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection