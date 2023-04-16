@extends('layouts.master')
@section('title')
قيد العمل
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
							<h4 class="content-title mb-0 my-auto">اعمال لم تكتمل</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="card">
				<div class="card-body">
					<form action="{{route('all-progress-search')}}" method="get" >
						<div class="row">
							<div class="form-group col-md-3">
								<label>البحث </label>
								<input type="text" name="descrip" placeholder="بيان المنتج" class="form-control">
							</div>
							<div class="form-group col-md-3">
								<label>اسم المنتج </label>
								<select name="product" class="form-control">
									<option value="">اختر المنتج</option>
									@foreach ($product as $item)
										<option value="{{$item->id}}">{{$item->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-3">
								<label>اسم الزبون </label>
								<select name="client" class="form-control">
									<option value="">اختر الزبون</option>
									@foreach ($client as $item)
										<option value="{{$item->id}}">{{$item->name}}-{{ $item->phone }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
							<input type="submit" class="btn btn-outline-primary mt-3" value="بحث">
							</div>
							<div class="col-md-2">
								<a href="{{route('all_progress')}}" class="btn btn-outline-dark">عرض الكل</a>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
						
							<div class="card-body">
                            
								<div class="table-responsive">
									<table class="table text-md-nowrap text-center" id="">
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">الصنف</th>
												<th class="wd-15p border-bottom-0">بيان الصنف</th>
												<th class="wd-20p border-bottom-0">رقم الفاتورة</th>
												<th class="wd-15p border-bottom-0">كمية </th>
												<th class="wd-15p border-bottom-0">الزبون</th>
												<th class="wd-10p border-bottom-0">تاريخ المعاملة</th>
                                                <th class="wd-15p border-bottom-0">الحالة</th>
											</tr>
										</thead>
										<tbody class="" id="myTable">
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{ $item->descripe }}</td>
                                                <td><a href="{{route("salesbill",$item->sales_id) }}">فاتورة رقم {{$item->sales_id}}</a></td>
                                                @if ($item->type_Q == 3)
                                                    <td>{{ $item->length }} * {{ $item->width }}</td> 
                                                @else
                                                    <td>{{ $item->qoun }}</td>
                                                @endif
                                                <td>{{ $item->cl_name}} - {{ $item->phone }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
													@if ($item->status == 0)
														<span class="text-danger">قيد العمل</span>
													@endif
													@if ($item->status == 1)
														<span class="text-primary">مكتمل</span>
													@endif
													@if ($item->status == 2)
														<span class="text-success">تم الاستلام</span>
														<a class="text-danger" href="{{ route('its_completed',$item->id) }}?backdone=true">تراجع</a>
													@endif
												</td>
                                                </tr>
                                            @endforeach			
										</tbody>
									</table>
									{!! $data->links() !!}
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
	$("select").select2()
	$(function(){
		$("#send_all").click(function(){
            arra = []
		for(i = 0;i< $('.disabled:checked').length;i++)
			arra[i]=$('.disabled:checked')[i].value
                
            if($('.disabled:checked').length > 0){
                // console.log(arra.toString())
                location.replace("{{ route('its_done','') }}/"+arra)
            }
                // console.log(arra.toString())
        })
		
		$("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            // console.log($(this).text().toLowerCase().indexOf(value) > -1)
            if($(this).text().toLowerCase().indexOf(value) > -1){
                console.log(true)
                $(this).find("input").addClass('disabled')
            }else{
                console.log(false)
                $(this).find("input").removeClass("disabled")
            }
            });
        });

        $("#all").change(function(){
            if($(this).is(':checked'))
            $(".disabled").attr("checked","checked")
            else
            $(".disabled").removeAttr("checked")
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