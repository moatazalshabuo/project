@extends('layouts.master')
@section('title')
	الرئيسية
@endsection
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
						  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبا بك من جديد!</h2>
						  
						</div>
					</div>
					<div class="main-dashboard-header-right">
						
						<div>
							<label class="tx-13">تاريخ اليوم</label>
							<h5><?php echo  date("F j, Y, g:i a"); ?></h5>
						</div>
						
					</div>
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
@if (Auth::user()->user_type == 1 ||Auth::user()->user_type == 0 ||Auth::user()->user_type == 2)

				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">عدد فواتير المبعات</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $countsals[1] }}</h4>
											<p class="mb-0 tx-12 text-white op-7">فواتير هذا اليوم</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">{{$countsals[0]}}</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">عدد فواتير المشتريات</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $countpur[1] }}</h4>
											<p class="mb-0 tx-12 text-white op-7">فواتير اليوم</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">{{ $countpur[0] }}</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">عدد ايصالات الصرف</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $countpay[1] }}</h4>
											<p class="mb-0 tx-12 text-white op-7">ايصالات صرف اليوم</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
											<span class="text-white op-7">{{ $countpay[0] }}</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">عدد ايصالات القبض</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $countexc[1] }}</h4>
											<p class="mb-0 tx-12 text-white op-7">ايصالات قبض اليوم</p>
										</div>
										<span class="float-right my-auto mr-auto">
											<i class="fas fa-arrow-circle-down text-white"></i>
											<span class="text-white op-7">{{ $countexc[0] }}</span>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-4 col-md-12 col-lg-12">
						<div class="card bg-danger text-white">
							<div class="card-header pb-1 bg-danger text-white">
								<h3 class="card-title mb-2">فواتير قيد العمل</h3>

							</div>
							<div class="card-body p-0 customers mt-1" style="height:400px;overflow-y:scroll">
								<table class="table text-white">
									<thead class="text-white">
										<th class="text-white">ت</th>
										<th class="text-white"> الفاتورة</th>
										<th class="text-white">العميل</th>
									</thead>
									<tbody>
										@php
											$i = 0;
										@endphp
										@foreach ($bill_process as $item)
											<tr>
												<td>{{ $i+=1 }}</td>
												<td><a class="text-white" href="{{ route('salesbill',$item->id) }}"> فاتورة مبيعات رقم{{ $item->id }} </a></td>
												<td>{{$item->name}}-{{$item->phone}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-12 col-lg-6">
						<div class="card">
							<div class="card-header pb-1">
								<h3 class="card-title mb-2">فواتير مكتملة غير مستلمة</h3>
								<div class="card-body p-0 customers mt-1" style="height:400px;overflow-y:scroll">
									<table class="table ">
										<thead >
											<th >ت</th>
											<th > الفاتورة</th>
											<th >العميل</th>
										</thead>
										<tbody>
											@php
												$i = 0;
											@endphp
											@foreach ($bills_done as $item)
												<tr>
													<td>{{ $i+=1 }}</td>
													<td><a  href="{{ route('salesbill',$item->id) }}"> فاتورة مبيعات رقم{{ $item->id }} </a></td>
													<td>{{$item->name}}-{{$item->phone}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>							</div>
							<div class="product-timeline card-body pt-2 mt-1">
								
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-md-12 col-lg-6">
						<div class="card">
							<div class="card-header pb-1">
								<h3 class="card-title mb-2">مواد قاربة على النفاذ</h3>
								{{-- <p class="tx-12 mb-0 text-muted">Sales activities are the tactics that salespeople use to achieve their goals and objective</p> --}}
							</div>
							<div class="product-timeline card-body pt-2 mt-1">
								<div class="card-body p-0 customers mt-1" style="height:400px;overflow-y:scroll">
									<table class="table ">
										<thead >
											<th >ت</th>
											<th > المادة</th>
											<th >الكمية</th>
										</thead>
										<tbody>
											@php
												$i = 0;
											@endphp
											@foreach ($raw as $item)
												<tr>
													<td>{{ $i+=1 }}</td>
													<td>{{ $item->material_name }}</td>
													<td>{{ floatval($item->quantity)}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<!-- row close -->	
@endif
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
{{-- <script src="{{URL::asset('assets/js/apexcharts.js')}}"></script> --}}
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	
@if (session()->has('massage'))
	<script>
		var r = '{{ session()->get('massage') }}'
	Swal.fire(r)
	</script>
@endif
@endsection