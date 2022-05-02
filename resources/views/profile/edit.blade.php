@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="section bg-light">
 <div class="container">
    <div class="card-block">
    	<div class="row justify-content-center">
    		<div class="col-md-6">
    			<div class="wrapper">
    				<div class="row no-gutters">
    					<div class="col-md-12 d-flex">
    						<div class="contact-wrap w-100 p-md-5 p-4">
    							<h3 class="mb-4">Edit {{ $user->name }} Account</h3>
    							<form method="POST" action="{{ route('profile.update', ['id' => $id]) }}" id="editForm" class="editForm">
    								@csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">    								
                                    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="text" class="form-control" name="name" id="name" placeholder="Name" value='{{ $user->name }}' required="required">
    										</div>
    									</div>
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="email" class="form-control" name="email" id="email" placeholder="Email" value='{{ $user->email }}' required="required">
    										</div>
                                            
                                            {{-- <div class="input-group">
                                                <input type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19"  name="cardNumber" placeholder="Your card number" class="form-control" required>
                                                <div class="input-group-append">
                                                  <span class="input-group-text text-muted">
                                                    <i class="mdi mdi-credit-card"></i>
                                                  </span>
                                                </div>
                                            </div> 
                                             <br> --}}

    										<div class="form-group">
    											<input type="password" class="form-control" name="Password" id="Password" placeholder="Password" value=''>
    										</div>
    									</div>
         									<div class="col-md-12">
                                            </div>
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="hidden" class="form-control" name="id" id="id" value='1' required="required">
    											<input type="submit" value="Save Changes" class="btn btn-primary">
    											<div class="submitting"></div>
    										</div>
    									</div>
    								</div>
    							</form>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
 </div>
</section>
</div>
@endsection