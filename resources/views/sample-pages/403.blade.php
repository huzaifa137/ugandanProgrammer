@extends('layouts.master2')
@section('css')
@endsection
@section('content')
		<div class="page">
			<div class="page-content">
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<img src="{{URL::asset('assets/images/svgs/notfund.svg')}}" alt="img" class="w-90">
						</div>
						<div class="col-md-7 mt-6">
							<div class="display-2 text-primary  mb-2 font-weight-bold"> 403</div>
							<h1 class="h3  mb-3 font-weight-bold">Sorry, Forbidden Error, Requested Page not found!</h1>
							<p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
							<a class="btn btn-primary" href="{{ url('/' . $page='index') }}"><i class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection