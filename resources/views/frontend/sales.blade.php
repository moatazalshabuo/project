@extends('layouts.master')
@section('title')
فاتورة المبيعات 
@endsection
@section('css')
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
} */
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
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header row">
					<div class="my-auto col-md-5">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">فاتورة المبيعات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">{{ $data->name }}/{{ $data->created_at }}</span>
						</div>
					</div>
					<div class="row my-xl-auto left-content col-md-7">
						<div class="col-md-2 col-sm-3 col-3 mb-2 mb-xl-0">
							<button class="btn btn-info ml-2" id="print-bill" >طباعة الفاتورة</button>
						</div>
						<div class="col-md-2 col-sm-3 mb-2 col-3 mb-xl-0">
							<a href="{{ route("salesbill_edit",$data->id) }}" @if($data->status)disabled @endif class="btn btn-info ml-2">تعديل الفاتورة</a>
						</div>
						<div class="col-md-2 col-sm-3 mb-2 col-3 mb-xl-0">
							<button class="btn btn-info ml-2" id="close-bill" @if($data->status == 0)disabled @endif>حفظ الفاتورة</button>
						</div>
						<div class="mb-2 col-sm-3 col-md-2 col-3">
							<a href="{{ route("salesbiil_create") }}" type="button" class="btn btn-danger  ml-2">فاتورة جديدة </a>
						</div>
						<div class="mb-2 col-md-1 col-sm-1 col-2">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="d-flex mb-2 mb-xl-0 col-sm-4 col-7 col-md-3">
							<a type="button" class="btn btn-primary btn-icon" @if ($next) href='{{route('salesbill',$next)}}' @else disabled @endif ><</a>
						
							<input type="text" class="form-control" id="bill_id" value="{{ $data->id }}">
	
							<a type="button" class="btn btn-primary btn-icon" @if ($prev) href='{{route('salesbill',$prev)}}' @else disabled @endif >></a>
						</div>
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
												<optin disabled >اختر الصنف</optin>
											</select>
											<div class="text-danger" id="product_error"></div>
										</div>
										<div class="col-md-2 col-6">
											<label>الكمية</label>
											<input class="form-control" required @if($data->status == 0)disabled @endif placeholder="الكمية" id="quant" name="quant" type="number">
											{{-- <input class="form-control" @if($data->status == 0)disabled @endif placeholder="العرض" type="text"> --}}
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
				
				
				{{-- <div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card overflow-hidden">
							<div class="card-header pb-0">
								<h3 class="card-title">Accordion Style01</h3>
								<p class="text-muted card-sub-title mb-0">The default collapse behavior to create an accordion.</p>
							</div>
							<div class="card-body">
								<div class="panel-group1" id="accordion11">
									<div class="panel panel-default  mb-4">
										<div class="panel-heading1 bg-primary ">
											<h4 class="panel-title1">
												<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion11" href="#collapseFour1" aria-expanded="false">Section 1<i class="fe fe-arrow-left ml-2"></i></a>
											</h4>
										</div>
										<div id="collapseFour1" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
											<div class="panel-body border">
												<p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words </p>
												<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise</p>
											</div>
										</div>
									</div>
									<div class="panel panel-default mb-0">
										<div class="panel-heading1  bg-primary">
											<h4 class="panel-title1">
												<a class="accordion-toggle mb-0 collapsed" data-toggle="collapse" data-parent="#accordion11" href="#collapseFive2" aria-expanded="false">Section 2 <i class="fe fe-arrow-left ml-2"></i></a>
											</h4>
										</div>
										<div id="collapseFive2" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
											<div class="panel-body border">
												<p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words </p>
												<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Accordion Style02</h3>
							</div>
							<div class="card-body">
								<div id="accordion" class="w-100 br-2 overflow-hidden">
									<div class="">
										<div class="accor bg-primary" id="headingOne1">
											<h4 class="m-0">
												<a href="#collapseOne1" class="" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
												   Accordions With Text <i class="si si-cursor-move ml-2"></i>
												</a>
											</h4>
										</div>
										<div id="collapseOne1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
											<div class="border p-3">
												I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful
												sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae
											</div>
										</div>
									</div>
									<div class="">
										<div class="accor  bg-primary" id="headingTwo2">
											<h4 class="m-0">
												<a href="#collapseTwo2" class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
													Accordions with images <i class="si si-cursor-move ml-2"></i>
												</a>
											</h4>
										</div>
										<div id="collapseTwo2" class="collapse b-b0 bg-white" aria-labelledby="headingTwo" data-parent="#accordion">
											<div class="border p-3">
												<div class="row">
													<div class="col-lg-3 col-md-6">
														<img class="img-fluid rounded" src="{{URL::asset('assets/img/photos/8.jpg')}}" alt="banner image">
													</div>
													<div class="col-lg-3 col-md-6">
														<img class="img-fluid rounded" src="{{URL::asset('assets/img/photos/10.jpg')}}" alt="banner image ">
													</div>
													<div class="col-lg-3 col-md-6">
														<img class="img-fluid rounded" src="{{URL::asset('assets/img/photos/11.jpg')}}" alt="banner image ">
													</div>
													<div class="col-lg-3 col-md-6">
														<img class="img-fluid rounded " src="{{URL::asset('assets/img/photos/12.jpg')}}" alt="banner image ">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="">
										<div class="accor  bg-primary" id="headingThree3">
											<h4 class="m-0">
												<a href="#collapseThree1" class="collapsed" data-toggle="collapse" aria-expanded="false" aria-controls="collapseThree">
													Accordions with tables <i class="si si-cursor-move ml-2"></i>
												</a>
											</h4>
										</div>
										<div id="collapseThree1" class="collapse b-b0 bg-white" aria-labelledby="headingThree" data-parent="#accordion">
											<div class="border p-3">
												<table class="table mb-0 table-bordered border-top mb-0">
													<thead>
													  <tr>
														<th>#</th>
														<th>First Name</th>
														<th>Last Name</th>
														<th>Username</th>
													  </tr>
													</thead>
													<tbody>
													  <tr>
														<th scope="row">1</th>
														<td>Mark</td>
														<td>Otto</td>
														<td>@mdo</td>
													  </tr>
													  <tr>
														<th scope="row">2</th>
														<td>Jacob</td>
														<td>Thornton</td>
														<td>@fat</td>
													  </tr>
													  <tr>
														<th scope="row">3</th>
														<td>Larry</td>
														<td>the Bird</td>
														<td>@twitter</td>
													  </tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- Row -->
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="card">
							<div class="card-body">
								<div>
									<h6 class="card-title mb-1">Colored Style Accordion</h6>
									<p class="text-muted card-sub-title">The default collapse behavior to create an accordion.</p>
								</div>
								<div aria-multiselectable="true" class="accordion accordion-dark" id="accordion2" role="tablist">
									<div class="card mb-0">
										<div class="card-header" id="headingOne2" role="tab">
											<a aria-controls="collapseOne2" aria-expanded="false" data-toggle="collapse" href="#collapseOne2">Making a Beautiful CSS3 Button Set</a>
										</div>
										<div aria-labelledby="headingOne2" class="collapse show" data-parent="#accordion2" id="collapseOne2" role="tabpanel">
											<div class="card-body">
												A concisely coded CSS3 button set increases usability across the board, gives you a ton of options, and keeps all the code involved to an absolute minimum. Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.
											</div>
										</div>
									</div>
									<div class="card mb-0">
										<div class="card-header" id="headingTwo2" role="tab">
											<a aria-controls="collapseTwo2" aria-expanded="true" class="collapsed" data-toggle="collapse" href="#collapseTwo2">Horizontal Navigation Menu Fold Animation</a>
										</div>
										<div aria-labelledby="headingTwo2" class="collapse" data-parent="#accordion2" id="collapseTwo2" role="tabpanel">
											<div class="card-body">
												Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore.
											</div>
										</div>
									</div>
									<div class="card mb-0">
										<div class="card-header" id="headingThree2" role="tab">
											<a aria-controls="collapseThree2" aria-expanded="false" class="collapsed" data-toggle="collapse" href="#collapseThree2">Creating CSS3 Button with Rounded Corners</a>
										</div>
										<div aria-labelledby="headingThree2" class="collapse" data-parent="#accordion2" id="collapseThree2" role="tabpanel">
											<div class="card-body">
												Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore.
											</div>
										</div><!-- collapse -->
									</div>
								</div><!-- accordion -->
							</div>
							<div class="card-footer">
								<table class="table main-table-reference mt-0 mb-0">
									<thead>
										<tr>
											<th class="wd-40p">Class Reference</th>
											<th class="wd-60p">Values</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><code class="pd-0 bg-transparent">class="accordion accordion-[value]"</code></td>
											<td>indigo | blue | dark | gray</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div> --}}
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
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>	
<!--- Internal Accordion Js -->
<script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script src="{{URL::asset('assets/js/accordion.js')}}"></script>
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
			// console.log(res)
			$("#product").html(res)
		},error:function(re){
console.log(re.responseJSON)
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
	$("#product").change(function(){
		rest();
		if($(this).val() != 0)
		$.ajax({
			url:"{{ route('selectprod','') }}/"+$(this).val(),
			type:"get",
			success:function(res){
				$data = JSON.parse(res)
				// console.log($data)
				$(".war").html($data['warning']);
				$("#price").val($data['price'])
			}
		})
	})
	$("#quant").keyup(function(){
		$("#totel").val(($("#price").val()*$(this).val()))
	})
	$("#addItem").click(function(){
		rest();
		console.log($("#input-item").serialize());
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
				$("#q_error").text(r.errors.quant)
				$("#product_error").text(r.errors.product)
			}
		})
	})
	function get_totel(){
		$.ajax({
			url:"{{ route('getItembill',$data->id) }}",
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
					$("#price").val(data['price'])
				$("#descount").val(data['descont'])
				$("#totel").val(data['total'])
				$("#quant").val(data['qoun'])
				getProduct(data['product'])
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
	function rest(){
		$("#q_error").text("")
		$("#product_error").text("")
		$("#name_err").html("")
		$("#phone_err").html("")
		$(".war").text("")
	}
	$("#save-client").click(function(){
		// console.log($("#form-client").serialize())
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
		
	})
	$("#close-bill").click(function(){
		// console.log($('#form-client').serialize())
		// console.log("_token={{ csrf_token() }}"+$('#form-client').serialize()+"&sincere="+$("#sincere").val()+"&id={{ $data->id }}")
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
	})
</script>
@endsection
@endempty