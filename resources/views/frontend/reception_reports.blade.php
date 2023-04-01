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
@section('title')
فواتير المبيعات
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">فواتير المبيعات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> اضافة</span>
        </div>
    </div>

</div>
<!-- breadcrumb -->
<form>
    <div class="row">
        <div class="col-md-4">
            <label>نوع الفاتورة</label>
            <select class="form-control">
                <option>اختر</option>
                <option value="2">الكل</option>
                <option value="0">الفواتير المغلقة</option>
                <option value="1">الفواتير المفتوحة</option>
            </select>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>من</label>
                <input type="datetime-local" class="form-control" name="form">
                <label>الى</label>
                <input type="datetime-local" class="form-control" name="form">
            </div>
        </div>
    </div>
</form>
@endsection
@section('content')

@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>

</div>
	
@endif

@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('edit') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('Add') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('error') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('delete') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

        <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        {{-- <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">إضافة مادة</a>
                        </div>	 --}}
                    </div>
                    <div class="card-body" style="height: 450px;overflow-y:scroll">
                        <div class="table-responsive">
                            <table class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">رقم الفاتورة </th>
                                        <th class="border-bottom-0">قيمة الفاتورة </th>
                                        <th class="border-bottom-0">التخفيض</th>
                                        <th class="border-bottom-0">القيمة الخالصة</th>
                                        <th class="border-bottom-0">القيمة المتبقية</th>
                                        <th class="border-bottom-0">الانتقال للفاتورة</th>												
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@isset($data) && !@empty($data) && count($data) >0 )

                                    @else
                                    {{-- <p>  لاتوجد مواد مخزنة بالنظام</p> --}}
                                    @endif
                                </tbody>										
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->

            <!--div-->
                    <!-- Basic modal -->
<div class="modal" id="modaldemo1">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('rawmaterials.store') }}" method="POST">
                @csrf
            
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">اسم المادة</label>
                    <input type="text" class="form-control" id="material_name" name="material_name" required>
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">نوع المادة</label>
                    <input type="text" class="form-control" id="material_type" name="material_type" required>

                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">نوع الحسبة</label>
                <select name="hisba_type" id="hisba_type"  class="form-control">
                <option value="">حدد نوع الحسبة</option>
                <option value="1">بالمتر</option>
                <option value="2">بالطرف</option>
            </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">كمية المخزون</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">السعر</label>
                    <input type="number" class="form-control" id="" name="price" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">تأكيد</button>
                <button type="button" class="btn btn-secondary">إغلاق</button>

            </div>
        </form>
        </div>
    </div>
</div>
		<!-- End Basic modal -->
</div>
					<!-- edit -->
					{{-- <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ url('sections/update') }}" method="post" autocomplete="off">
                                            {{method_field('patch')}}
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" id="id" value="">
                                                <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                                                <input class="form-control" name="section_name" id="section_name" type="text">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">ملاحظات:</label>
                                                <textarea class="form-control" id="description" name="description"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}

						  <!-- delete -->
						  {{-- <div class="modal" id="exampleModal11">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content modal-content-demo">
									<div class="modal-header">
										<h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
																					   type="button"><span aria-hidden="true">&times;</span></button>
									</div>
									<form action="sections/destroy" method="post">
										{{method_field('delete')}}
										{{csrf_field()}}
										<div class="modal-body">
											<p>هل انت متاكد من عملية الحذف ؟</p><br>
											<input type="hidden" name="id" id="id" value="">
											<input class="form-control" name="section_name" id="section_name" type="text" readonly>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
											<button type="submit" class="btn btn-danger">تاكيد</button>
										</div>
								</div>
								</form>
							</div>
						</div> --}}
				
				<!-- row closed -->
			
			<!-- Container closed -->
		
		<!-- main-content closed -->
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
{{-- <script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
		modal.find('.modal-body #description').val(description);

	})
</script>

<script>
	$('#exampleModal11').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('section_name')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #section_name').val(section_name);
	})
</script> --}}

<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
