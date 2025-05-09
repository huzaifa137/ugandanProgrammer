@extends('layouts.master2')
@section('css')
@endsection
@section('content')
		<div class="page relative">
			<div class="page-content">
			<div class="container">
				<div class="row">
					<div class="col-md-7 mx-auto d-block">
						<div class="card p-7 mb-0">
							<div class="text-center">
								<div class="fs-100  mb-5 text-primary font-weight-normal h1"><i class="fa fa-frown-o"></i>ops!</div>
								<h1 class="h3  mb-3 font-weight-bold">Error 501: Internal Server Error</h1>
								<p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
								<a class="btn btn-primary" href="{{ url('/' . $page='index') }}"><i class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
@endsection
@section('js')
@endsection