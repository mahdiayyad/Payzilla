@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                @if (session('status'))
				<script>
                    Swal.fire({
                        title: 'Success',
                        text: '{{ session('status') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
				</script>
				@endif 
				@if(session('success'))
					<script>
						Swal.fire({
                        title: 'Success',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
					</script>
				@endif
            </div>
        </div>
    </div>
</div>
@endsection
