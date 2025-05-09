@extends('layouts.master')
@section('css')
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Project Management</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<div class="ml-5 mb-0">
									<a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
										<svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
											<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
										</svg> <span>Select Date
										<i class="fa fa-caret-down"></i></span>
									</a>
								</div>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!--Row-->
						<div class="row">
							<div class="col-xl-4 col-md-12 col-lg-3">
								<div class="card expenses-card overflow-hidden">
									<div class="card-body">
										<div class="feature">
											<i class="fa fa-university feature-icon"></i>
											<h1 class="font-weight-bold mb-0 mt-4 fs-50">$12,345.00</h1>
											<p class="text-muted fs-18 mb-0">Expenses This Month</p>
										</div>
									</div>
									<div class="chart-wrapper">
										<canvas id="Chart" class="overflow-hidden"></canvas>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-md-12 col-lg-9">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-12 col-sm d-flex mb-4 mb-sm-0">
												<i class="mdi mdi-basket-fill fs-60 text-success icon-dropshadow-success mr-3"></i>
												<div class="mt-5">
													<h6>Total Orders</h6>
													<h3 class="mb-0 font-weight-bold">2245</h3>
												</div>
											</div>
											<div class="col-12 col-sm d-flex mb-4 mb-sm-0">
												<i class="mdi mdi-basket-fill fs-60 text-primary icon-dropshadow-primary mr-3"></i>
												<div class="mt-5">
													<h6>Recent Order</h6>
													<h3 class="mb-0 font-weight-bold">45%</h3>
												</div>
											</div>
											<div class="col-12 col-sm d-flex">
												<i class="mdi mdi-basket-fill fs-60 text-danger icon-dropshadow-danger mr-3"></i>
												<div class="mt-5">
													<h6>Cancel Orders</h6>
													<h3 class="mb-0 font-weight-bold">56%</h3>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-6">
										<div class="card">
											<div class="card-body">
												<p class="mb-1">Total Invoices</p>
												<h2 class="mb-1 font-weight-bold">245</h2>
												<span class="mb-1 text-muted"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 43.2</span> last month</span>
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-6">
										<div class="card">
											<div class="card-body">
												<p class="mb-1">Credited Amount</p>
												<h2 class="mb-1 font-weight-bold">$53k</h2>
												<span class="mb-1 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i> 19.8</span> last month</span>
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												<p class="mb-1">Pending Amount</p>
												<h2 class="mb-1 font-weight-bold">$2345</h2>
												<span class="mb-1 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i> 0.8%</span> last month</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-deck">
							<div class="col-xl-4 col-md-6 col-lg-5">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Status</h3>
										<div class="d-flex ml-auto">
											<div class="btn-group mb-0">
												<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This week</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">Next Week</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"> Last Month</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="latest-timeline latest-timeline1">
											<ul class="timeline mb-0">
												<li class="mt-0 media media-lg">
													<span class="latest-timeline1-icon bg-primary shadow3">10</span>
													<div class="media mt-0">
														<div class="media-body">
															<h6 class="mb-1"><a href="#" class="font-weight-semibold fs-17">Angular Project</a><span class="badge badge-success ml-2">Completed</span></h6>
															<p class="mt-1 fs-13 mb-1"><b>Client:</b> Hoyt Righter</p>
															<span class="text-muted fs-12 d-block">12.00 am</span>
															<a class="text-primary fs-12 font-weight-bold" href="#">View Details</a>
														</div>
													</div>
												</li>
												<li class="mt-0 media media-lg">
													<div class="media mt-0">
														<span class="latest-timeline1-icon bg-secondary shadow3">11</span>
														<div class="media-body">
															<h6 class="mb-1"><a href="#" class="font-weight-semibold fs-17">Html Project</a><span class="badge badge-secondary ml-2">Hold</span></h6>
															<p class="mt-1 fs-13 mb-1"><b>Client:</b> Riva Digangi</p>
															<span class="text-muted fs-12 d-block">11.00 am</span>
															<a class="text-primary fs-12 font-weight-bold" href="#">View Details</a>
														</div>
													</div>
												</li>
												<li class="mt-0 media media-lg">
													<div class="media mt-0">
														<span class="latest-timeline1-icon bg-success shadow3">12</span>
														<div class="media-body">
															<h6 class="mb-1"><a href="#" class="font-weight-semibold fs-17">Php Project</a><span class="badge badge-primary ml-2">Running</span></h6>
															<p class="mt-1 fs-13 mb-1"><b>Client:</b> Craig Dollard </p>
															<span class="text-muted fs-12 d-block">10.00am</span>
															<a class="text-primary fs-12 font-weight-bold" href="#">View Details</a>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-lg-7 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Investment</h3>
										<div class="d-flex ml-auto">
											<div class="btn-group mb-0">
												<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Year</button>
												<div class="dropdown-menu p-0">
													<a class="dropdown-item" href="#">last Year</a>
													<a class="dropdown-item" href="#">2018</a>
													<a class="dropdown-item" href="#">2017</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div id="echart1" class="h-330"></div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-5 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Statistics</h3>
									</div>
									<div class="card-body mx-auto text-center pb-0">
										<div class="">
											<canvas class="canvasDoughnut donutShadow" height="240" width="240"></canvas>
										</div>
									</div>
									<div class="card-body pt-0 border-top-0">
										<div class="row mt-4 no-gutters">
											<div class="col">
												<div class="text-muted mb-1 fs-13 d-flex"><div class="w-3 h-3 bg-primary mr-2 mt-1 brround"></div> Running</div>
											</div>
											<div class="col">
												<div class="text-muted mb-1 fs-13 d-flex"><div class="w-3 h-3 bg-secondary mr-2 mt-1 brround"></div> Pending</div>
											</div>
											<div class="col">
												<div class="text-muted mb-1 fs-13 d-flex"><div class="w-3 h-3 bg-success mr-2 mt-1 brround"></div> Completed</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-lg-7 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Complete Invoices</h3>
										<div class="card-options ">
											<div class="btn-group ml-5 mb-0">
												<a class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#"> Download Print</a>
													<a class="dropdown-item" href="#">Last Week</a>
													<a class="dropdown-item" href="#">Last Month</a>
													<a class="dropdown-item" href="#">Yearly</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div class="">
											<div class="table-responsive invoice-table-responsive">
												<table class="table card-table table-vcenter text-nowrap mb-0 border">
													<thead>
														<tr>
															<th class="wd-lg-10p">Client</th>
															<th class="wd-lg-20p">Date</th>
															<th class="wd-lg-20p">Invoice</th>
															<th class="wd-lg-20p">Amount</th>
															<th class="wd-lg-20p">Status</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="font-weight-semibold">Hoyt Righter</td>
															<td class="text-nowrap">Jan 13, 2020</td>
															<td>INV-1432</td>
															<td>$34,980</td>
															<td><span class="badge badge-success badge-pill">Paid<span></td>
															<td>
																<div class="btn-group mb-0 relative">
																	<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
																	<div class="dropdown-menu p-0">
																		<a class="dropdown-item" href="#">Copy</a>
																		<a class="dropdown-item" href="#">Send Email</a>
																		<a class="dropdown-item" href="#">Before Due</a>
																		<a class="dropdown-item" href="#">Print Invoice</a>
																		<a class="dropdown-item" href="#">Download Print</a>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="font-weight-semibold">Melvina Harn</td>
															<td class="text-nowrap">Feb 12, 2020</td>
															<td>INV-5467</td>
															<td>$35,768</td>
															<td><span class="badge badge-success badge-pill">Paid<span></td>
															<td>
																<div class="btn-group mb-0 relative">
																	<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
																	<div class="dropdown-menu p-0">
																		<a class="dropdown-item" href="#">Copy</a>
																		<a class="dropdown-item" href="#">Send Email</a>
																		<a class="dropdown-item" href="#">Before Due</a>
																		<a class="dropdown-item" href="#">Print Invoice</a>
																		<a class="dropdown-item" href="#">Download Print</a>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="font-weight-semibold">Riva Digangi</td>
															<td class="text-nowrap">Mar 23, 2020</td>
															<td>INV-6543</td>
															<td>$13,456</td>
															<td><span class="badge badge-success badge-pill">Paid<span></td>
															<td>
																<div class="btn-group mb-0">
																	<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
																	<div class="dropdown-menu p-0">
																		<a class="dropdown-item" href="#">Copy</a>
																		<a class="dropdown-item" href="#">Send Email</a>
																		<a class="dropdown-item" href="#">Before Due</a>
																		<a class="dropdown-item" href="#">Print Invoice</a>
																		<a class="dropdown-item" href="#">Download Print</a>
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="font-weight-semibold">Craig Dollard</td>
															<td class="text-nowrap">Apr 11, 2020</td>
															<td>INV-3245</td>
															<td>$25,678</td>
															<td><span class="badge badge-danger badge-pill">Due<span></td>
															<td>
																<div class="btn-group mb-0">
																	<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
																	<div class="dropdown-menu p-0">
																		<a class="dropdown-item" href="#">Copy</a>
																		<a class="dropdown-item" href="#">Send Email</a>
																		<a class="dropdown-item" href="#">Before Due</a>
																		<a class="dropdown-item" href="#">Print Invoice</a>
																		<a class="dropdown-item" href="#">Download Print</a>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Payment Status</h3>
									</div>
									<div class="card-body p-5">
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Angular Project</h6>
											<h6 class="font-weight-bold mb-1">50%</h6>
										</div>
										<div class="progress progress-sm mb-5">
											<div class="progress-bar bg-primary" style="width: 50%"></div>
										</div>
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Php Project</h6>
											<h6 class="font-weight-bold mb-1">60%</h6>
										</div>
										<div class="progress progress-sm mb-5">
											<div class="progress-bar bg-secondary" style="width: 60%"></div>
										</div>
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Ecommerce Project</h6>
											<h6 class="font-weight-bold mb-1">40%</h6>
										</div>
										<div class="progress progress-sm mb-5">
											<div class="progress-bar bg-info" style="width: 40%"></div>
										</div>
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Html Project</h6>
											<h6 class="font-weight-bold mb-1">100%</h6>
										</div>
										<div class="progress progress-sm mb-5">
											<div class="progress-bar bg-success" style="width: 100%"></div>
										</div>
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Java Project</h6>
											<h6 class="font-weight-bold mb-1">50%</h6>
										</div>
										<div class="progress progress-sm mb-5">
											<div class="progress-bar bg-danger" style="width: 50%"></div>
										</div>
										<div class="d-flex align-items-end justify-content-between mg-b-5">
											<h6 class="">Wordpress Project</h6>
											<h6 class="font-weight-bold mb-1">90%</h6>
										</div>
										<div class="progress progress-sm mb-0">
											<div class="progress-bar bg-warning" style="width: 90%"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-6 col-lg-4">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title">Project Review Activity</h3>
									</div>
									<div class="p-4 scrollbar h-330" id="scrollbar">
										<div class="activity">
											<img src="{{URL::asset('assets/images/users/14.jpg')}}" alt="" class="img-activity shadow3 border-primary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Adam Berry <span class="text-muted">Add a new projects </span> AngularJS Template</p>
													<small class="text-muted ">30 mins ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/10.jpg')}}" alt="" class="img-activity shadow3 border-secondary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Irene Hunter <span class="text-muted"> Add a new projects </span>Free HTML Template</p>
													<small class="text-muted ">1 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/4.jpg')}}" alt="" class="img-activity shadow3 border-success">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">John Payne<span class="text-muted"> Add a new projects </span>Free PSD Template</p>
													<small class="text-muted ">3 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/8.jpg')}}" alt="" class="img-activity shadow3 border-danger">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Julia Hardacre<span class="text-muted"> Add a new projects </span>Free UI Template</p>
													<small class="text-muted ">5 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/14.jpg')}}" alt="" class="img-activity shadow3 border-primary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Adam Berry <span class="text-muted">Add a new projects </span> AngularJS Template</p>
													<small class="text-muted ">30 mins ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/10.jpg')}}" alt="" class="img-activity shadow3 border-secondary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Irene Hunter <span class="text-muted"> Add a new projects </span>Free HTML Template</p>
													<small class="text-muted ">1 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/4.jpg')}}" alt="" class="img-activity shadow3 border-success">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">John Payne<span class="text-muted"> Add a new projects </span>Free PSD Template</p>
													<small class="text-muted ">3 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/8.jpg')}}" alt="" class="img-activity shadow3 border-danger">
											<div class="time-activity mb-0">
												<div class="item-activity mb-0">
													<p class="mb-0 font-weight-bold">Julia Hardacre<span class="text-muted"> Add a new projects </span>Free UI Template</p>
													<small class="text-muted ">5 days ago</small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-lg-4">
								<div class="card overflow-hidden">
									<div class="card-header">
										<h3 class="card-title">Email Notification</h3>
									</div>
									<div class="p-4 scrollbar2 h-330" id="scrollbar2">
										<div class="activity">
											<img src="{{URL::asset('assets/images/users/4.jpg')}}" alt="" class="img-activity shadow3 border-primary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">New Project <span class="text-muted">Issue Fixed</span></p>
													<small class="text-muted ">30 mins ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/2.jpg')}}" alt="" class="img-activity shadow3 border-secondary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Wordpress Project<span class="text-muted"> New theme updated </span></p>
													<small class="text-muted ">1 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/1.jpg')}}" alt="" class="img-activity shadow3 border-success">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">E-Commerce<span class="text-muted">Plugin Issue Fixed and Updated</span></p>
													<small class="text-muted ">3 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/3.jpg')}}" alt="" class="img-activity shadow3 border-danger">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">New Theme<span class="text-muted"> Updated in Site</span></p>
													<small class="text-muted ">5 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/4.jpg')}}" alt="" class="img-activity shadow3 border-primary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">New Project <span class="text-muted">Issue Fixed</span></p>
													<small class="text-muted ">30 mins ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/2.jpg')}}" alt="" class="img-activity shadow3 border-secondary">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">Wordpress Project<span class="text-muted"> New theme updated </span></p>
													<small class="text-muted ">1 days ago</small>
												</div>
											</div>
											<img src="{{URL::asset('assets/images/users/1.jpg')}}" alt="" class="img-activity shadow3 border-success">
											<div class="time-activity">
												<div class="item-activity">
													<p class="mb-0 font-weight-bold">E-Commerce<span class="text-muted">Plugin Issue Fixed and Updated</span></p>
													<small class="text-muted ">3 days ago</small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--End row-->
					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')
<!--Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Daterangepicker js-->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/daterange.js')}}"></script>
<!-- ECharts js -->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
<!-- Chartjs js -->
<script src="{{URL::asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>
<!--Morris Charts js-->
<script src="{{URL::asset('assets/plugins/morris/raphael-min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/morris/morris.js')}}"></script>
<!-- P-scroll js-->
<script src="{{URL::asset('assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<!-- Index js-->
<script src="{{URL::asset('assets/js/index3.js')}}"></script>
@endsection