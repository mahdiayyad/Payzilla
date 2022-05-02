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
    							<h3 class="mb-4">Add an Account</h3>
                                    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required">
    										</div>
    									</div>
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required">
    										</div>

                                            <div class="form-group">
                                                <select name="type" id="type" class="form-control">
                                                    <option value="user">User</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="active">Active</option>
                                                    <option value="in_active">In active</option>
                                                    <option value="suspended">Suspended</option>
                                                </select>
                                            </div>

    										<div class="form-group">
                                                <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
    											<input type="password" class="form-control" name="password" id="password" placeholder="Password" value=''>
    										</div>
    									</div>
         									<div class="col-md-12">
                                            </div>
    									<div class="col-md-12">
    										<div class="form-group">
    											<input type="hidden" class="form-control" name="id" id="id" value='1' required="required">
    											<input type="submit" value="Save Changes" class="btn btn-primary addAccount">
    										</div>
    									</div>
    								</div>
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