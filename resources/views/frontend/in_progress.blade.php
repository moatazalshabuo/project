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
                    <label>البحث </label>
					<input type="text" id="myInput" placeholder="البحث .. " class="form-control">
				</div>

			</div>
		</div>
	</div>
<!-- row opened -->
				{{-- @if (Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
				@endif --}}
				{{-- {!! Helper::cost(6) !!} --}}

				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
						
							<div class="card-body" style="overflow-y: scroll;height:500px">
                                <div class="form-group">
                                    <input id="all" type="checkbox">
                                    <label>تحديد الكل</label>
                                    <button type="button" id="send_all" class=" m-1 btn btn-outline-dark">اكتمال</button>
                                </div>
                            
								<div class="table-responsive">
									<table class="table text-md-nowrap text-center" id="">
										<thead>
											<tr>
                                                <th></th>
												<th class="wd-15p border-bottom-0">الصنف</th>
												<th class="wd-15p border-bottom-0">بيان الصنف</th>
												<th class="wd-20p border-bottom-0">رقم الفاتورة</th>
												<th class="wd-15p border-bottom-0">كمية </th>
												<th class="wd-15p border-bottom-0">الزبون</th>
												<th class="wd-10p border-bottom-0">تاريخ المعاملة</th>
                                                <th class="wd-15p border-bottom-0">التحكم</th>
											</tr>
										</thead>
										<tbody class="" id="myTable">
                                            @foreach ($data as $item)
                                            <tr>
                                                <td><input name="done" type="checkbox" value="{{ $item->id }}" class="disabled"></td>
                                                <td>{{$item->name}}</td>
                                                <td>{{ $item->descripe }}</td>
                                                <td><a href="{{route("salesbill",$item->sales_id) }}">فاتورة رقم {{$item->sales_id}}</a></td>
                                                @if ($item->type_Q == 3)
                                                    <td>{{ floatval($item->length) }} * {{ floatval($item->width) }}</td> 
                                                @else
                                                    <td>{{ floatval($item->qoun) }}</td>
                                                @endif
                                                <td>{{ $item->cl_name}} - {{ $item->phone }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <a href="{{ route('its_done',$item->id) }}" class="btn btn-outline-success">اكتمال العمل</a>
                                                </td>
                                                </tr>
                                            @endforeach			
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