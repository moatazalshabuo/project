@extends('layouts.master')
@section('title')
فاتورة المبيعات 
@endsection
@section('css')
<!-- Interenal Accordion Css -->
<link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
<style>

</style>
@endsection

@empty($data)

@section('content')
<div class=" text-center">
    <div class="card" style="margin:auto;margin-top: 100px;max-width: 450px;">
      <div class="card-body">
        <p>يس لديك اي فاتورة </p>
        <p>هل  تريد فتح فاتورة جديدة ل</p>
        <a href="{{ route('salesbiil_create') }}" class="btn btn-primary text-white">فاتورة جديد </a>
      </div>
  </div>
</div>
@endsection
@endempty

@empty(!$data)
@section('num')
<div class="btn-group">
	
	<button type="button" class="btn btn-warning  btn-icon ml-2" id="refresh"><i class="mdi mdi-refresh"></i></button>
	<a type="button" class="btn btn-primary btn-icon ml-1" @if ($first && $data->id != $first) href='{{route('salesbill',$first)}}' @else disabled @endif ><<</a>
	<a type="button" class="btn btn-primary btn-icon" @if ($prev) href='{{route('salesbill',$prev)}}' @else disabled @endif ><</a>
	<input type="text" class="form-control" id="bill_id" value="{{ $data->id }}">
	<a type="button" class="btn btn-primary btn-icon ml-1" @if ($next) href='{{route('salesbill',$next)}}' @else disabled @endif >></a></a>
	<a type="button" class="btn btn-primary btn-icon" @if ($last && $data->id != $last) href='{{route('salesbill',$last)}}' @else disabled @endif >>></a>
</div>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header row">
					<div class="my-auto col-md-5">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">فاتورة المبيعات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">{{ $data->name }}/{{ $data->created_at }}</span>
						</div>
					</div>
					<div class="btn-group left-content col-md-7" style="overflow-x:scroll">
						<button class="btn btn-info ml-2" id="print-bill" >طباعة الفاتورة</button>
						<button class="btn btn-info ml-2" id="print-work" >طباعة امر عمل</button>
						<a href="{{ route("salesbill_edit",$data->id) }}" @if($data->status)disabled @endif class="btn btn-info ml-2">تعديل الفاتورة</a>
						<button class="btn btn-info ml-2" id="close-bill" @if($data->status == 0)disabled @endif>حفظ الفاتورة</button>
						<a href="{{ route("salesbiil_create") }}" type="button" class="btn btn-danger  ml-2">فاتورة جديدة </a>						
					</div>
				</div>
				<div class="row">
				<div class="col-md-5 col-10">
					<form id="form-client">
						<select class="form-control select2-no-search mb-1" name="client" id="client" @if($data->status == 0) disabled @endif>
							<option label="الزبون">
							</option>
						</select>
					</form>
					<p class="text-danger" id="client-err"></p>
				</div>
				<div class="col-md-1 col-2">
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
											<select name="product" class="form-control" id="product">
												<option disabled >اختر الصنف</option>
											</select>
											<div class="text-danger" id="product_error"></div>
										</div>
										<div class="col-md-2 col-6">
											<label>الكمية</label>
											<input class="form-control m2" required @if($data->status == 0)disabled @endif placeholder="الكمية" id="quant" name="quant" type="number">
											<div class="d-flex">
												<input type="number" @if($data->status == 0)disabled @endif class="form-control  m3 m-1" id="length" disabled name="length" placeholder="طول">
												<input type="number" @if($data->status == 0)disabled @endif class="form-control mateFiled m3 m-1" id="width" disabled name="width" placeholder="العرض">
											</div>
											<div class="text-danger" id="q_error"></div>
										</div>
										<div class="col-md-1 col-6">
											<label>سعر </label>
											<input class="form-control" id="price" name="price" disabled type="number">
											{{-- <input class="form-control" @if($data->status == 0)disabled @endif placeholder="العرض" type="text"> --}}
										</div>
										<div class="col-md-2 col-6">
											<label>التخفيض</label>
											<input class="form-control" placeholder="التخفيض" value="0" type="number" id="descount" name="descont" @if($data->status == 0)disabled @endif>
										
										</div>
										<div class="col-md-2 col-6">
											اجمالي السعر
											<input class="form-control" disabled placeholder="الاجمالي" type="number" id="totel">
										</div>
										<div class="col-md-4">
											<label for="descripe"> تفاصيل المنتج</label>
											<input type="text" name="descripe" id="descripe" @if($data->status == 0)disabled @endif class="form-control">
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
								
								
							</div>
							<div class="card-body" style="height: 330px;overflow-y:scroll">
								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap text-left">
										<thead>
											<tr>
												<th>ت</th>
												<th>الصنف</th>
												<th>التفاصيل</th>
												<th>الكمية</th>	
												<th>التخفيض</th>
												<th>اجمالي سعر</th>
												<th>الحالة</th>
												<th>تاريخ المعاملة</th>
												<th>اخرى</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-2">
						<div class="card card-primary p-1">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-4">
									<div class="form-group p-1">
										الاجمالي : <input type="number" disabled value="0" class="form-control" id="total">
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-4">
								<div class="form-group p-1 ">
									الخالص : <input type="number" @if($data->status == 0)disabled @endif  class="form-control" id="sincere">
								</div>
								
								<p class="text-danger" id="sincere-err"></p>
								</div>
								<div class="col-lg-12 col-md-12 col-4">
								<div class="form-group p-1">
									المتبقي : <input type="number" disabled value="0" class="form-control" id="Residual">
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				
				
							<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
		<!-- Basic modal -->
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
								<input type="number" name="phone" id="phone" class="form-control">
								<p id="phone_err" class="text-danger"></p>
							</div>
							<div class="form-group">
								<label>الايميل(اختياري)</label>
								<input type="email" name="email" id="email" class="form-control">
								<p id="phone_err" class="text-danger"></p>
							</div>
							<div class="form-group">
								<label>الموقع(اختياري)</label>
								<input type="text" name="address" id="address" class="form-control">
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
<!--Internal  Datepicker js -->
{{-- <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script> --}}
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>	
<!--- Internal Accordion Js -->
{{-- <script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script> --}}
{{-- <script src="{{URL::asset('assets/js/accordion.js')}}"></script> --}}
<script>
	$(function(){

		$("#product,#client").select2()
		// $("#product").val("8")
		$('#bill_id').keyup(function(e){
			var code = (e.keyCode ? e.keyCode : e.which)
			if (code==13) {
				location.replace("{{ route('salesbill','') }}/"+$(this).val())
			}
		})
	function getProduct(id= ""){
		$.ajax({
			url:"{{ route('product_select','') }}/"+id,
		type:"get",
		success:function(res){
			$("#product").html(res)
		},error:function(re){
			console.log(re.responseJSON)
		}
		})		
	}
	function add_item_sale(){
		rest();
		// console.log($("#input-item").serialize());
		$.ajax({
			url:"{{ route('add_item') }}",
			type:"POST",
			data:$("#input-item").serialize()+"&price="+$("#price").val()+"&id={{ $data->id }}",
			success:function(r){
				
				get_totel()
				if(r == 1){
				alertify.success('تم الاضافة بنجاح');
			$("#input-item").trigger("reset");	
			}else{
					Swal.fire(r)
				}
			},error:function(ers){
				r = ers.responseJSON;
				// console.log(r.errors.quant)
				$("#q_error").text(r.errors.quant || r.errors.length + " " +r.errors.width)
				$("#product_error").text(r.errors.product)
			}
		})
	}
	function getClient(id= ""){
		$.ajax({
			url:"{{ route('clientSelect','') }}/"+id,
		type:"get",
		success:function(res){
			// console.log(res)
			$("#client").html(res)
		},error:function(re){
			console.log(re.responseJSON)
		}
		})
	}

	client = {{ $data->client }}
	getClient(client)
	getProduct()


	$(".m3").hide()

	$("#product").change(function(){
		rest();
		if($(this).val() != 0){
		$.ajax({
			url:"{{ route('selectprod','') }}/"+$(this).val(),
			type:"get",
			success:function(res){
				$data = JSON.parse(res)
				
				$("#price").val(parseFloat($data['price']))
			}
		})
		$.ajax({
			'url':"{{route('get_type_product','')}}/"+$(this).val(),
			'type':"get",
			success:function(res){
			if(res == 3){
					$("#input-item .m3").removeAttr('disabled');
					$('#input-item .m3').show()
					$("#input-item .m2").attr('disabled','disabled');
					$('#input-item .m2').hide()
				}else{
					$("#input-item .m2").removeAttr('disabled');
					$('#input-item .m2').show()
					$("#input-item .m3").attr('disabled','disabled');
					$('#input-item .m3').hide()
				}
			}
		})
	}
	})
	function totel_product(){
		var quan = $("#quant").val() || $("#length").val()*$("#width").val() 
		$("#totel").val(parseFloat($("#price").val()*quan))
	}
	$("#quant,#length,#width").keyup(function(){
		totel_product()
	})
	$("#addItem").click(function(){
		add_item_sale()
	})
	$("#input-item .m2,#input-item .m3,#descount , #descripe").keyup(function(e){
		if(e.which == 13){
			add_item_sale()
		}
	})
	function get_totel(){
		$.ajax({
			url:"{{ route('getItembill',$data->id) }}",
			type:"get",
			success:function(e){
				$data = JSON.parse(e)
				$("#total").val(parseFloat($data['total']))
				$("#sincere").val(parseFloat($data['sincere']))
				$("#Residual").val(parseFloat($data['Residual']))
				$("tbody").html($data['tbody'])
			},error:function(e){
				console.log(e)
			}
		})
	}
	get_totel()
	$(document).on('click',".dele",function(){
		$.ajax({
			url:"{{ route('deleteSaleItem','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(r){
				get_totel()
				if(r == 1){
				alertify.success('تم الحذف بنجاح');
				}else{
				Swal.fire(r)}
			},error:function(r){
				console.log(r.responseJSON)
			}
		})
	})
	$(document).on('click',".edit",function(){
		$.ajax({
			url:"{{ route('editSaleItem','') }}/"+$(this).attr('id'),
			type:"get",
			success:function(r){
				data = JSON.parse(r)
				if(data['type'] == 1){
					$("#price").val(parseFloat(data['price']))
				$("#descount").val(parseFloat(data['descont']))
				$("#totel").val(parseFloat(data['total']))
				$("#quant").val(parseFloat(data['qoun']))
				getProduct(data['product'])
				get_totel()

				}else{
					Swal.fire(data['massege'])
				}
			},error:function(r){
				console.log(r.responseJSON)
			}
		})
	})
	function rest(){
		$("#q_error").text("")
		$("#product_error").text("")
		$("#name_err").html("")
		$("#phone_err").html("")
		$(".war").text("")
	}
// ==========================================
	function add_client(){
		$.ajax({
			url:"{{ route('createClient') }}",
			type:"post",
			data:$("#form-client-add").serialize(),
			success:function(e){
				getClient(e)
				$("#select2modal").modal("hide")
				$("#form-client-add").trigger("reset")
				alertify.success('تم الاضافة بنجاح');
				rest()
			},error:function(e){
				re = e.responseJSON
				console.log(re)
				$("#name_err").html(re.errors.name)
				$("#phone_err").html(re.errors.phone)
			}
		})
	}
	$("#save-client").click(function(){
		add_client();
	})
	$("#phone,#address,#email").keypress(function(e){
		if(e.which == 13){
			add_client();
		}
	})
	$("#refresh").click(function(){
		location.reload()
	})
	
	$("#close-bill").click(function(){
		$.ajax({
			url:"{{ route('salesbill_save') }}",
			type:"post",
			data:"_token={{ csrf_token() }}&client="+$("#client").val()+"&sincere="+$("#sincere").val()+"&id={{ $data->id }}",
			success:function(re){
				res = JSON.parse(re)
				if(res['id']){
					location.replace("{{ route('salesbill','') }}/"+res['id'])
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
	$('#print-bill').click(function(){
		$.ajax({
			url:"{{route('check_bill',$data->id)}}",
			type:"get",
			success:function(res){
				if(res['success']){
					// location.replace("{{ route('invicebill', $data->id) }}")
					window.open ("{{ route('invicebill', $data->id) }}",
						"mywindow","menubar=1,resizable=1,width=1300,height=1000");
				}else{
					Swal.fire(res['mass'])
				}
			}
		})
	})
	$('#print-work').click(function(){
		$.ajax({
			url:"{{route('check_bill',$data->id)}}",
			type:"get",
			success:function(res){
				if(res['success']){
					// location.replace("{{ route('invicebill', $data->id) }}")
					window.open ("{{ route('work', $data->id) }}",
						"mywindow","menubar=1,resizable=1,width=1300,height=1000");
				}else{
					Swal.fire(res['mass'])
				}
			}
		})
	})

	})
</script>
@endsection
@endempty