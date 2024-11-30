@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Delegate</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<li class="breadcrumb-item active" aria-current="page">Delegate</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!-- Row -->
						<div class="row flex-lg-nowrap">
							<div class="col-12">
								<div class="row flex-lg-nowrap">
									<div class="col-12 mb-3">
										<div class="e-panel card">
											<div class="card-body pb-2">
												<div class="row">
													<div class="col mb-4">
														<a href="#" data-target="#delegation-modal" data-toggle="modal" class="btn btn-primary"><i class="fe fe-plus"></i> Add New Delegate</a>
													</div>													
													<div class="col mb-4">
														<h3 class="text-dark">My Delegations (From me)</h3>
													</div>
													<div class="col col-auto mb-4">
														<div class="form-group w-100">
																<div class="col mb-4 float-right">
																	<a href="{{ url('users/delegated') }}" class="btn btn-danger"><i class="fe fe-list"></i> Delegations To Me {{$pending_acceptance}}</a>
																</div>
														</div>
													</div>
												</div>
												@if(!count($delegations))
													<div><br><br/><br><br/><center>You have not made any delegations</center><br/><br/><br/></div>
												@endif
												
												{{ $delegations->links()}}
												<div class="row">

													@foreach($delegations as $del)
													<div class="col-xl-4 col-lg-6">
														<div class="card border p-0 shadow-none">
															<div class="d-flex align-items-center p-4">
																<?php 
																echo \App\Http\Controllers\Controller::letterAvatar2(@$del->id, $del->firstname.' '.$del->lastname, 50);
																?>
																<div class="wrapper ml-3">
																	<p class="mb-0 mt-1 text-dark font-weight-semibold">Delegatee: <br/><small>{{$del->firstname}} {{$del->lastname}}</small></p>
																</div>
																@if(@$others['open'][$del->id])
																<div class="float-right ml-auto">
																	<div class="btn-group ml-3 mb-0">
																		<a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
																		<div class="dropdown-menu">
																			<!-- <a class="dropdown-item" href="#"><i class="fe fe-edit mr-2"></i> Edit</a> -->
																			<a onclick="return confirm('Do you really want to cancel?')" class="dropdown-item" href="{{url('users/cancel-delegation/'.$del->id) }}"><i class="fe fe-undo mr-2"></i> Recall</a>
																		</div>
																	</div>
																</div>
																@endif
															</div>
															<div class="card-body pt-2">
																<div class="d-flex mb-3">
																	<i class="fa fa-fw fa-calendar"></i>
																	<div class="h6 mb-0 ml-3 mt-0">{{\App\Http\Controllers\Helper::date_fm($del->del_start_date)}}<br/>{{\App\Http\Controllers\Helper::date_fm($del->del_end_date)}}</div>
																</div>
																<div class="d-flex mb-3">
																<i class="fa fa-fw fa-calendar"></i>
																	<div class="h6 mb-0 ml-3 mt-0">Days : {{ @$others['days'][$del->id] }} </div>
																</div>
																<div class="d-flex mb-3">
																	<i class="fa fa-fw fa-question"></i>			
																	<div class="h6 mb-0 ml-3 mt-0">Status: {!! @$others['status'][$del->id] !!} </div>
																</div>
																
															</div>
														</div>
													</div>
													@endforeach													
												</div>
												{{ $delegations->links()}}
											</div>
										</div>
									</div>
								</div>

								<!-- User Form Modal -->
								<div class="modal fade" role="dialog" tabindex="-1" id="delegation-modal">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Add Delegatee</h5>
												<button type="button" class="close" data-dismiss="modal">
													<span aria-hidden="true">×</span>
												</button>
											</div>
											<div class="modal-body">
												<div class="py-1">
													<form class="form" novalidate="">
														<div class="row">
															<div class="col">
																<div class="row">
																	<div class="col">
																		<div class="form-group">
																			<label>Select Delegateee</label>
																			<select id="user" class="form-control">
																				<option value="" disabled selected>Select</option>
																				@foreach($users as $user)
																					<option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}} ({{$user->email}})</option>
																				@endforeach
																			</select>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col mb-3">
																		<div class="form-group">
																			<label>Reason for Delegation</label>
																			<textarea id="reason" class="form-control" rows="5" placeholder="Enter Reason for Delegation"></textarea>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-12 col-sm-6 mb-3">
																<div class="mb-2"><b>Start Date</b></div>
																<div class="row">
																	<div class="col">
																		<div class="form-group">
																		<input class="form-control fc-datepicker hasDatepicker" placeholder="MM/DD/YYYY" type="date" id="startDate">
																		</div>
																	</div>
																</div>
															</div>
															<div class="col-12 col-sm-5 offset-sm-1 mb-3">
																<div class="mb-2"><b>End Date</b></div>
																<div class="row">
																	<div class="col">
																	<input class="form-control fc-datepicker hasDatepicker" placeholder="MM/DD/YYYY" type="date" id="endDate">

																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col d-flex justify-content-end">
															<button id="saveChanges" type="button" class="btn btn-primary" type="submit">Save Changes</button>
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
						<!-- End Row -->

					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$(document).ready(function() {
		$('#toggleButton').click(function() {
			$('#toggleDiv').toggle();
		});
	});
	$(document).ready(function() {
		$('#saveChanges').click(function(){

			var user = $('#user').val();
			var reason = $('#reason').val();
			var startDate = $('#startDate').val();
			var endDate = $('#endDate').val();

			var error = new Array();

			if(!user) 
				error.push('Select Delegatee');

			//$('#saveChanges').append('<img class="loader" src="/assets/images/loading.gif" alt=""/>');
			$('#saveChanges').attr('disabled', true);

			var formData = new FormData();

			formData.append('user', user);
			formData.append('reason', reason);
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);

			$.ajax({
				type: "post",
				processData: false,
				contentType: false,
				cache: false,
				data: formData,
				url: '/users/save-delegate',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(data) { 
					if(data.status){   
						Swal.fire({
							title: 'Success',
							text: "Successfully Added.",
							icon: 'success',
						}).then(function() {
							location.reload();
						}); 
					}else{
						Swal.fire({
							title: 'Error',
							text: data.message,
							icon: 'error',
						});
						$('#saveChanges').attr('disabled', false);
					}               
				},
				error: function(data) {
					if (data.status === 422) {
						let errors = data.responseJSON.errors;
						let errorList = '';
						$.each(errors, function(key, value) {
							errorList += '<li>' + value[0] + '</li>';
						});
						Swal.fire({
							title: 'Error',
							html: errorList,
							icon: 'error',
						});
						$('#saveChanges').attr('disabled', false);
					}else{
						$('body').html(data.responseText);
					}
				}
			});

		});
	});
</script>

@endsection