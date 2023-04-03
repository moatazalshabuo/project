@extends('layouts.master')
@section('title')
	فاتورة المشتريات
@endsection
@section('css')
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

<!-- Interenal Accordion Css -->
<link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
<style>
	/* .overlay{
  position: absolute;
  top:0px;
  left: 0px;
  width: 100%;
  height: 100%;
  background-color: #eee;
  z-index: 9999;
/*  display: none;*/
/* } */ 
</style>
{{-- @endsection --}}

@empty($data)
@section('content')
<div class=" text-center">
    <div class="card" style="margin:auto;margin-top: 100px;max-width: 450px;">
      <div class="card-body">
        <p>يس لديك اي فاتورة </p>
        <p>هل  تريد فتح فاتورة جديدة ل</p>
        <a href="{{ route('Purchasesbill_create') }}" class="btn btn-primary text-white">فاتورة جديد </a>
      </div>
  </div>
</div>
@endsection
@endempty

@empty(!$data)
@section('page-header')
				<!-- breadcrumb -->
				

				<div class="breadcrumb-header row">
					<div class="my-auto col-md-5">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">فاتورة مشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">{{ $data->name }}</span>
						</div>
					</div>
					<div class="col-md-7 row my-xl-auto ">
						<div class="col-md-3 col-sm-3 col-3 mb-2 mb-xl-0">
							<a href="{{ route("purchasesbill_edit",$data->id) }}" @if($data->status)disabled @endif class="btn btn-info ml-2">تعديل الفاتورة</a>
						</div>
						<div class="col-md-3 col-sm-3 col-3 mb-2 mb-xl-0">
						<button class="btn btn-info ml-2" id="close-bill" @if($data->status == 0)disabled @endif>حفظ الفاتورة</button>
						</div>
						<div class="mb-2 col-md-2 col-sm-3 col-3">
							<a href="{{ route("Purchasesbill_create") }}" type="button" class="btn btn-danger  ml-2">فاتورة جديدة </a>
						</div>
						<div class="mb-2 col-md-1">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="d-flex mb-2 mb-xl-0 col-md-3 col-sm-3 col-3">
							<a type="button" class="btn btn-primary btn-icon" @if ($next) href='{{route('Purchasesbill',$next)}}' @else disabled @endif ><</a>
						
							<input type="text" class="form-control" id="bill_id" value="{{ $data->id }}">
						
							<a type="button" class="btn btn-primary btn-icon" @if ($prev) href='{{route('Purchasesbill',$prev)}}' @else disabled @endif >></a>
						</div>
					</div>
					
				</div>
				<div class="row m-1">
					<div class="col-md-5">
						<select id="custom" class="form-control select2-no-search mb-1 select" @if($data->status == 0) disabled @endif>
							<option label="المورد">
							</option>
							
						</select>
						<div class="text-danger" id="client-err"></div>
					</div>
					<div class="col-md-1">
						<button class="btn btn-primary" data-target="#select2modal" data-toggle="modal"><i class="mdi mdi-plus"></i></button>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body">
								<form id="input-item">
									@csrf
									<div class="row">
										<div class="col-md-4">
											<label>الصنف</label>
											<select name="material" class="form-control select" id="mate">
												<option >اختر الصنف</option>
												@foreach ($mate as $item)
												<option value="{{$item->id}}">{{$item->material_name}}</option>													
												@endforeach
											</select>
											<div class="text-danger" id="product_error"></div>
										</div>
										<div class="col-md-3">
											<label>الكمية الموجودة</label>
											<input class="form-control" disabled placeholder="الكمية" id="old_quant" type="number">
											
										</div>
										<div class="col-3">
											<label>اخر سعر</label>
											<input class="form-control" id="old_price" disabled type="number">
										</div>
										<div class="col-md-2"></div>
										<div class="col-md-2">
											<label>الكمية</label>
											<input class="form-control" @if($data->status == 0)disabled @endif placeholder="الكمية" id="quant" name="quant" type="number">
											<div class="text-danger" id="q_error"></div>
										</div>
										<div class="col-md-2">
											<label>السعر الحالي</label>
											<input class="form-control" placeholder="السعر" value="0" type="number" id="price" name="price" @if($data->status == 0)disabled @endif>
											<div class="text-danger" id="price_error"></div>
										</div>
										<div class="col-md-2">
											اجمالي السعر
											<input class="form-control" disabled placeholder="الاجمالي" type="number" id="totel">
										</div>
										<div class="col-md-1">
											<br>
											<button class="btn btn-primary" id="addItem" type="button">حفظ</button>
										</div>
										<div class="text-warning war"></div>
									</div>
								</form>		
							</div>

						</div>
					</div>
				</div>
			
				<div class="row">
					<div class="col-lg-10 col-md-10">
						<div class="card card-primary">
							<div class="card-header">
								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap table-bordered text-center">
										<thead>
											<tr>
												<th>ت</th>
												<th>الصنف</th>
												<th>الكمية</th>
												<th>التخفيض</th>
												<th>اجمالي سعر</th>
												<th>تاريخ المعاملة</th>
												<th>اخرى</th>
											</tr>
										</thead>
									</table>
								</div>
								
							</div>
							<div class="card-body" style="height: 330px;overflow-y:scroll">
								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap text-left">
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2">
						<div class="card card-primary">
							<div class="form-group p-1">
								الاجمالي : <input type="number" disabled value="0" class="form-control" id="total">
							</div>
							<div class="form-group p-1">
								الخالص : <input type="number" disabled value="0" class="form-control" id="sincere">
							</div>
							<div class="form-group p-1">
								المتبقي : <input type="number" disabled value="0" class="form-control" id="Residual">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
		<div class="modal" id="select2modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة زبون</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h6>ادخل البيانات</h6>
						<!-- Select2 -->
						<form id="form-client-add">
							@csrf
							<div class="form-group">
								<label>الاسم</label>
								<input type="text" name="name" class="form-control">
								<p id="name_err" class="text-danger"></p>
							</div>
							<div class="form-group">
								<label>رقم الهاتف</label>
								<input type="number" name="phone" class="form-control">
								<p id="phone_err" class="text-danger"></p>
							</div>
						</form>						
						<!-- Select2 -->
					</div>
					<div class="modal-footer">
						<button class="btn ripple btn-primary" id="save-client" type="button">حفظ</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('js')
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>	
<!--- Internal Accordion Js -->
<script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script src="{{URL::asset('assets/js/accordion.js')}}"></script>
<script>
	$(".select").select2()
	$(function(){
		$('#bill_id').keyup(function(e){
			var code = (e.keyCode ? e.keyCode : e.which)
			if (code==13) {
				location.replace("{{ route('Purchasesbill','') }}/"+$(this).val())
			}
		})
		function get_totel(){
		$.ajax({
			url:"{{ route('getItempurbill',$data->id) }}",
			type:"get",
			success:function(e){
				$data = JSON.parse(e)
				$("#total").val($data['total'])
				$("#sincere").val($data['sincere'])
				$("#Residual").val($data['Residual'])
				$("tbody").html($data['tbody'])
			},error:function(e){
				console.log(e)
			}
		})
	}
	get_totel()
		$("#mate").change(function(){
			$.ajax({
				url:"{{ route('getoldprice','') }}/"+$(this).val(),
				type:"get",
				success:function(res){
					// console.log(res)
					data = JSON.parse(res)
					$("#old_price").val(data['price'])
					$("#old_quant").val(data['quantity'])

				}
			})
		})
		function reset(){
			$("#q_error").text("")
			$("#product_error").text("")
			$("#price_error").text("")
			$("#name_err").html("")
			$("#phone_err").html("")
			$(".war").text("")
		}
		$("#addItem").click(function(){
		reset();
		// console.log($("#input-item").serialize());
		$.ajax({
			url:"{{ route('add_puritem') }}",
			type:"POST",
			data:$("#input-item").serialize()+"&id={{ $data->id }}",
			success:function(r){
				// console.log(r)
				// get_totel()
				if(r == 1){
					get_totel()
				alertify.success('تم الاضافة بنجاح');
			$("#input-item").trigger("reset");	
			}else{
					Swal.fire(r)
				}
			},error:function(ers){
				r = ers.responseJSON;
				// console.log(r.errors.quant)
				$("#q_error").text(r.errors.quant)
				$("#product_error").text(r.errors.material)
				$("#price_error").text(r.errors.price)
			}
		})
	})
	$("#price").keyup(function(){
		$("#totel").val($(this).val()*$("#quant").val())
	});

	$(document).on('click',".dele",function(){
		$.ajax({
			url:"{{ route('deletePurItem','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(r){
				get_totel()
				if(r == 1){
				alertify.success('تم الاضافة بنجاح');
				}else{
				Swal.fire(r)}
			},error:function(r){
				console.log(r.responseJSON)
			}
		})
	})
	$(document).on('click',".edit-item",function(){
		$.ajax({
			url:"{{ route('editPurItem','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(r){
				data = JSON.parse(r)
				if(data['type'] == 1){
					$("#price").val(data['price'])
				$("#totel").val(data['total'])
				$("#quant").val(data['qoun'])
				$("#mate").val(data['mate']).change()
				get_totel()

				}else{
					Swal.fire(data['massege'])
				}
				
				// if(r == 1){
				// alertify.success('تم الاضافة بنجاح');
			},error:function(r){
				console.log(r.responseJSON)
			}
		})
	})

	function getClient(id= ""){
		$.ajax({
			url:"{{ route('customSelect','') }}/"+id,
		type:"get",
		success:function(res){
			// console.log(res)
			$("#custom").html(res)
			},error:function(re){
				console.log(re.responseJSON)
			}
		})
		
	}

	client = "{{ $data->custom }}"
	getClient(client)

	$("#save-client").click(function(){
		// console.log($("#form-client").serialize())
		$.ajax({
			url:"{{ route('createCustom') }}",
			type:"post",
			data:$("#form-client-add").serialize(),
			success:function(e){
				getClient(e)
				$("#select2modal").modal("hide")
				$("#form-client-add").trigger("reset")
				alertify.success('تم الاضافة بنجاح');
				reset()
			},error:function(e){
				re = e.responseJSON
				console.log(re)
				$("#name_err").html(re.errors.name)
				$("#phone_err").html(re.errors.phone)
			}
		})
		
	})

	$("#close-bill").click(function(){
		// console.log($('#form-client').serialize())
		// console.log("_token={{ csrf_token() }}"+$('#form-client').serialize()+"&sincere="+$("#sincere").val()+"&id={{ $data->id }}")
		$.ajax({
			url:"{{ route('purchasesbill_save') }}",
			type:"post",
			data:"_token={{ csrf_token() }}&client="+$("#custom").val()+"&id={{ $data->id }}",
			success:function(re){
				res = JSON.parse(re)
				if(res['id']){
					location.replace("{{ route('Purchasesbill','') }}/"+res['id'])
				}else{
					Swal.fire(res['mass'])
				}
				// console.log(res)
			},error:function(res){
				error = res.responseJSON
				// console.log(error)
				alertify.error('يوجد خطاء اثناء الحفظ');
				$("#client-err").text(error.errors.client)
				$("#sincere-err").text(error.errors.sincere)
			}
		})
	})

	})
</script>
@endempty
@endsection