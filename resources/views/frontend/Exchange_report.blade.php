@extends('layouts.master')
@section('title')
	ايصالات الصرف
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
			
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">تقرير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ايصال الصرف</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						{{-- <div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>--}}
						
						
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="{{ route("search_exc") }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-md-4">
								<label>العميل</label>
								<select name="custom" class="form-control">
									<option value="" >اختر المورد</option>
									@foreach ($custom as $item)
										<option value="{{$item->id}}">{{ $item->name }} - {{$item->phone}}</option>
									@endforeach
								</select>
								<div class="text-danger"></div>
							</div>
							التاريخ 
							<div class="col-md-1">
								<label>طول المدة</label>
								<input type="checkbox" name="all_time">
							</div>
							<div class="col-md-2">
								من
								<input class="form-control" type="datetime-local" value="{{ old('from') }}" name="from">
							</div>
							<div class="col-md-2">
								الى
								<input class="form-control" type="datetime-local" value="" name="to">
							@error('to')
								<div class="text-danger">{{ $message }}</div>
							@enderror
							</div>
							<div class="col-md-1">
								<br>
								<button class="btn btn-primary" id="addItem" type="submit">حفظ</button>
							</div>
							<div class="text-warning war"></div>
						</div>
					</form>		
				</div>

			</div>
		</div>
	</div>
<!-- row opened -->
				@if (Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
				@endif
				{{-- {!! Helper::cost(6) !!} --}}

				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="crad-header p-5">
								{{-- <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="البحث با اسم المنتج"> --}}
							</div>
							<div class="card-body" style="overflow-y: scroll;height:500px">
								<div class="table-responsive">
									<table class="table text-md-nowrap text-center" id="">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">رقم الايصال الصرف</th>
												<th class="wd-15p border-bottom-0">رقم فاتورة</th>
												<th class="wd-20p border-bottom-0">قيمة الايصال</th>
												<th class="wd-15p border-bottom-0">المسستخدم</th>
												<th class="wd-10p border-bottom-0">تاريخ الايصال</th>
												<th class="wd-25p border-bottom-0">التحكم</th>
											</tr>
										</thead>
										<tbody class="" id="myTable">
											@if ( session()->get('data'))
												@foreach (session()->get('data') as $item)
													<tr>
														<td>{{ $item->id }}</td>
														<td><a href="{{ route("Purchasesbill",$item->bill_id) }}"> فاتورة مشتريات رقم{{ $item->bill_id }}</a></td>
														<td>{{ $item->price }}</td>
														<td>{{ $item->name }}</td>
														<td>{{ $item->created_at }}</td>
														<td><button class="btn btn-danger dele" id="{{ $item->id }}"><i class='mdi mdi-transcribe'></i></button></td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->

					{{--  --}}
				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		

@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script>
	$(function(){
		$(".dele").click(function(){
			Swal.fire({
				title: 'هل تريد الحذف؟',
				icon: 'question',
				iconHtml: '؟',
				confirmButtonText: 'نعم',
				cancelButtonText: 'لا',
				showCancelButton: true,
				showCloseButton: true
				}).then((result)=>{
					if (result.isConfirmed) {
						location.replace("{{ route("delete_exc",'') }}/"+$(this).attr("id"))
					}
				})
		})
		
		
	})
</script>
@if (session()->get('success'))
	<script>
		Swal.fire(
		'نجاح العملية!',
		'{{ session()->get('success') }}!',
		'success'
		)
	</script>
@endif
@endsection