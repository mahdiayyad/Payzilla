@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="container d-flex justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600">{{ $user->name }}</h6>
                                <p>Web Developer</p> <a href="{{ route('profile.edit', ['id' => $id]) }}" style="color:#fff; font-size: 20px;"><i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i></a>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">{{ $user->email }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Phone</p>
                                        <h6 class="text-muted f-w-400">+962 795570175</h6>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Credit Card</p>
                                        <h6 class="text-muted f-w-400">**** **** **** {{ $user->pm_last_four }}</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Created in</p>
                                        <h6 class="text-muted f-w-400">{{ $user_created }}</h6>
                                    </div>
                                </div>
                                <ul class="social-link list-unstyled m-t-40 m-b-10">
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook" data-abc="true"><i class="mdi mdi-facebook feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter" data-abc="true"><i class="mdi mdi-twitter feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram" data-abc="true"><i class="mdi mdi-instagram feather icon-instagram instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="row justify-content-center text-center">
            <div class="col-md-6 alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif
</div>

@endsection