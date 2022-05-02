@extends('layouts.app')

@section('title', 'Subscription')

@section('content')
<section>
    <div class="container py-5">
        <h1 class="text-center pricing mt-3">Subscriptions</h1> <br>
        <div class="row text-center align-items-end">
            @foreach ($plans as $plan)
                    <div class="col-lg-4 mb-5 mb-lg-0">
                        <div class="bg-white p-5 rounded-lg shadow">
                            <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ $plan->name }}</h1>
                            <h2 class="h1 font-weight-bold">{{ $plan->price }}<span class="text-small font-weight-normal ml-2">/ {{ $plan->description }}</span></h2>
                            <div class="custom-separator my-4 mx-auto bg-warning"></div>
                            <ul class="list-unstyled my-5 text-small text-left">
                                <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 5GB Disk Space</li>
                                <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 10 Email Accounts</li>
                                <li class="mb-3"> <i class="fa fa-check mr-2 text-primary"></i> 5 GB Monthly Bandwidth</li>
                                <li class="mb-3 text-muted"> <i class="fa fa-times mr-2"></i> <del>Unlimited Subdomain</del> </li>
                                <li class="mb-3 text-muted"> <i class="fa fa-times mr-2"></i> <del>Automatic Cloud Backup</del> </li>
                            </ul> <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-warning btn-block p-2 shadow rounded-pill redirectPurchase">Subscribe</a>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
</section>
@endsection