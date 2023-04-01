@extends('layouts.master')
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
							<h4 class="content-title mb-0 my-auto">الاصناف</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ادارة الاصناف</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						{{-- <div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>--}}
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div> 
						@if (Auth::user()->user_type == 1)
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button"  data-target="#select2modal" data-toggle="modal" class="btn btn-primary ml-2"><i class="mdi mdi-plus"></i> اضافة صنف</button>
						</div>
						@endif
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				@if (Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
				@endif
				{{-- {!! Helper::cost(6) !!} --}}

				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="crad-header p-5">
								<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="البحث با اسم المنتج">
							</div>
							<div class="card-body" style="overflow-y: scroll;height:500px">
								<div class="table-responsive">
									<table class="table text-md-nowrap text-center" id="">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">ت</th>
												<th class="wd-15p border-bottom-0">اسم الصنف</th>
												<th class="wd-20p border-bottom-0">نوع الكمية</th>
												<th class="wd-15p border-bottom-0">سعر التكلفة</th>
												<th class="wd-10p border-bottom-0">سعر البيع</th>
												<th>الحالة</th>
												<th class="wd-25p border-bottom-0">التحكم</th>
											</tr>
										</thead>
										<tbody class="" id="myTable">
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
		<!-- main-content closed -->
		<div class="modal" id="select2modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة صنف</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form id="form-add">
							@csrf
							<div class="row">
								<div class="form group col-8">
									<input type="text" name="name" placeholder="اسم الصنف" class="form-control">
								<p class="text-danger error_name">
									
								</p>
								</div>
								<div class="form group col-4">
									<select class="form-control" name="type_Q">
										<option label="نوع الكمية">
										</option>
										<option value="1">
										متر
										</option>
										
										<option value="2">
											قطعه
										</option>
									</select>
									<p class="text-danger error_type">
									
									</p>
								</div>
							</div>
						</form>
						</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" id="add_product" type="button">حفظ</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
					</div>
				</div>
			</div>
		</div>


		<!-- Grid modal -->
		<div class="modal" id="modaldemo6">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">ادارة بيانات منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-4">
								<h3>مواد انتاج الصنف</h3>
								<form id="prod">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<select class="form-control" name="s_name" id="s-name">
													<option value="0">اختر المادة</option>
												</select>
											</div>
											<p class="text-danger error_name_add">
												
											</p>
										</div>
										<div class="col-md-6">
											<input type="number" placeholder="كمية" name="quan" class="form-control" >
											<input type="hidden" name="proid" class="proid">
											<p class="text-danger error_quan_add">
												
											</p>
										</div>
										<div class="col-md-3">
											<input type="button" class="btn btn-success" id="add-mate" value="اضافة">
										</div>
									</div>
								</form>
								<ul class="list-group" style="height: 200px;overflow-y:scroll" id="rawm">
								
								</ul>
							</div>
							<div class="col-md-4">
								<h3>خدمات انتاج الصنف</h3>
								<form id="work-form">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>اسم الخدمة</label>
												<input type="text" placeholder="اسم الخدمة" class="form-control" name="work_name" id="work_name">
											</div>
											<p class="text-danger error_work_name">
												
											</p>
										</div>
										<div class="col-md-6">
											<label>السعر للمتر / القطعة</label>
											<input type="number" placeholder="السعر" name="price_work" id="work_price" class="form-control" >
											<input type="hidden" name="proid" class="proid" id="proid_work">
											<p class="text-danger error_price_work">
												
											</p>
										</div>
										<div class="col-md-3">
											<input type="button" class="btn btn-success" id="add-work" value="اضافة">
										</div>
									</div>
								</form>
								<ul class="list-group" style="height: 200px;overflow-y:scroll" id="work-hand">
								
								</ul>
							</div>
							<div class="col-md-4">
								<h3>تعديل بيانات الصنف</h3>
								<div class="top">
									<form id="form-edit">
										@csrf
										<div class="row">
											<div class="form group col-8">
												<input type="text" name="name" id="name" placeholder="اسم الصنف" class="form-control">
												<input type="hidden" name="id" id="id">
												<p class="text-danger error_name_e">
												
											</p>
											</div>
											<div class="form group col-4">
												<select class="form-control" id="type_Q" name="type_Q">
													<option label="نوع الكمية">
													</option>
													<option value="1">
													متر
													</option>
													
													<option value="2">
														قطعه
													</option>
												</select>
												<p class="text-danger error_type_e">
												
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>السعر</label>
													<input type="number" name="price" id="price" value="0" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>التكلفة</label>
													<input type="number" disabled id="cost" value="0" class="form-control">
												</div>
											</div>
										</div>
										<input type="button" id="update" class="btn btn-primary " value="تعديل">
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">انهاء</button>
					</div>
				</div>
			</div>
		</div>
		<!--End Grid modal -->
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
		function getitem(){
			$.ajax({
				url:"{{route('getitem')}}",
				type:"get",
				success:function(e){
					$('tbody').html(e)
				}
			})
		}
		getitem()
		$('#add_product').click(function(){
		$.ajax({
			url:"{{ route('add_prod') }}",
			type:"post",
			data:$('#form-add').serialize(),
			success:function(res){
				// console.log(res);
				$('#form-add').trigger("reset");
				$("#select2modal").modal('hide')
				alertify.success('تم الاضافة بنجاح');
				getitem();
			},error:function(e){
				$data = e.responseJSON;
				// console.log(e)
				$(".error_name").append($data.errors.name)
				$(".error_type").append($data.errors.type_Q)
			}
		})
	})
	
		$(document).on("click",".edit_product",function(){
			id = $(this).attr('id');
			getMatiSel(id)
			dataproed(id)
			getWork(id)
	})
	function dataproed(id){
		$.ajax({
			url:"{{ route('editprod') }}",
			type:"post",
			data:{"id":id,"_token": "{{ csrf_token() }}" },
			success:function(res){
				// console.log(res);
				$("#name").val((res[0].name))
				$("#id").val((res[0].id))
				$("#price").val((res[0].price))
				$("#type_Q").val((res[0].type_Q)).change()
				$("#cost").val(res.cost)
			}
		})
	}
	$("#update").click(function(){
		$.ajax({
			url:"{{ route('up_prod') }}",
			type:"post",
			data:$("#form-edit").serialize(),
			success:function(e){
				// $('#form-edit').trigger("reset");
				// $("#edit").modal('hide')
				alertify.success('تم التعديل بنجاح');
				getitem();
			},error:function(e){
				data = e.responseJSON
				// console.log(data);
				$(".error_name_e").append(data.errors.s_name)
				$(".error_quan_e").append(data.errors.quan)
			}
		})
	})
	function getMatiSel(id){
		$.ajax({
			url:"{{ route('get-mati','') }}/"+id,
			type:"get",
			success:function(res){
				$data = JSON.parse(res)
				// console.log($data['myMate'])
				$("#rawm").html($data['myMate'])
				$('.proid').val(id)
				$("#s-name").html($data['mate'])
				getitem();
			},error:function(res){
				// console.log(res.responseJSON)
			}
		})
	}

	function getWork(id){
		$.ajax({
			url:"{{ route('get-work','') }}/"+id,
			type:"get",
			success:function(res){
				$data = JSON.parse(res)
				// console.log($data['myMate'])
				$("#work-hand").html($data['myMate'])
				$('.proid').val(id)
				// $("#s-name").html($data['mate'])
				getitem();
			},error:function(res){
				// console.log(res.responseJSON)
			}
		})
	}

	$("#add-work").click(function(){
		$.ajax({
			url:"{{ route('add-work') }}",
			type:"post",
			data:$("#work-form").serialize(),
			success:function(res){
				proid = $('.proid').val()
				// console.log(res)
				alertify.success('تم اضافة بنجاح');
				getWork(proid)
				dataproed(proid)
				$("#work-form").trigger('reset')
				// getitem()
			},error:function(e){
				data = e.responseJSON
				// console.log(data);
				$(".error_work_name").append(data.errors.name)
				$(".error_price_work").append(data.errors.price)
			}
		})
	})

	$("#add-mate").click(function(){
		$.ajax({
			url:"{{ route('add-mate') }}",
			type:"post",
			data:$("#prod").serialize(),
			success:function(res){
				proid = $('.proid').val()
				// console.log(res)
				alertify.success('تم اضافة بنجاح');
				getMatiSel(proid)
				dataproed(proid)
				// getitem()
				$("#prod").trigger('reset')
			},error:function(e){
				data = e.responseJSON
				// console.log(data);
				$(".error_name_add").text(data.errors.name)
				$(".error_quan_add").text(data.errors.quan)
			}
		})
	})
	
	$(document).on("click",".dele-work-p",function(){
		$.ajax({
			url:"{{ route('del-work','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(res){
				proid = res
				// console.log(res)
				alertify.success('تم الحذف بنجاح');
				// getMatiSel(proid)
				dataproed(proid)
				getWork(proid)
				// getitem()
			},error:function(e){
				data = e.responseJSON
				
			}
		})
	})
	$(document).on("click",".dele-mate-p",function(){
		$.ajax({
			url:"{{ route('del-mate','')}}/"+$(this).attr('id'),
			type:"get",
			success:function(res){
				proid = res
				// console.log(res)
				alertify.success('تم الحذف بنجاح');
				getMatiSel(proid)
				dataproed(proid)
				// getitem()
			},error:function(e){
				data = e.responseJSON
				
			}
		})
	})
	
	$(document).on("click",".edit-work-p",function(){
		$.ajax({
			url:"{{ route('edit-work','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(res){
				data = JSON.parse(res)
				proid = data['proid']
				$("#work_name").val(data['name'])
				$("#work_price").val(data['price'])
				getWork(proid)
				dataproed(proid)
			},error:function(e){
			}
		})
	})
	$(document).on("click",'.dele',function(){
		Swal.fire({
				title: 'هل تريد حذف الصنف',
				showDenyButton: false,
				showCancelButton: true,
				confirmButtonText: 'حذف',
				denyButtonText: `Don't save`,
				}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					$.ajax({
						url:"{{ route('deleteprod','') }}/"+$(this).attr('id'),
						type:"get",
						success:function(res){
							if(res['success']){
								getitem();
								alertify.success(res['success']);
							}else if(res['error']){
								Swal.fire(res['error'])
							}
						}
					})
				} 
				})
		
	})
	$(document).on("click",".active-prod",function(){
		$.ajax({
			url:"{{ route('activeprod','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(res){
				getitem();
			}
		})
	})
	$(document).on("click",".unactive-prod",function(){
		$.ajax({
			url:"{{ route('unactiveprod','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(res){
				getitem();
			}
		})
	})
})
</script>
@endsection