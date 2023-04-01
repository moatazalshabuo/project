@extends('layouts.master')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    ادارة المستخدمين
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    الرئيسية</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
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
            @if (session()->has('massage'))
                <div class="alert alert-success">{{session()->get('massage')}}</div>
            @endif
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <a class="btn btn-outline-primary btn-block"
                             href="{{ route('register') }}">إضافة مستخدم</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (@isset($user) && !@empty($user) && count($user) > 0)
                            <table id="example1" class="table key-buttons text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">ر.ت</th>
                                        <th class="border-bottom-0">اسم المستخدم</th>
                                        <th class="border-bottom-0">البريد الإلكتروني</th>
                                        {{-- <th class="border-bottom-0">كلمة المرور</th> --}}
                                        <th class="border-bottom-0">نوع المستخدم</th>
										<th class="border-bottom-0">تاريخ الإنشاء</th>
                                        {{-- <th class="border-bottom-0">السعر</th> --}}
                                        {{-- <th></th> --}}
                                        {{-- <th class="border-bottom-0">بواسطة</th> --}}
                                        {{-- <th class="border-bottom-0">العمليات</th> --}}

                                    </tr>

                                </thead>

                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    <tr>



                                        @foreach ($user as $dates)
                                            @php
                                                $i++;
                                            @endphp



                                            </td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $dates->name }}</td>
                                            <td>{{ $dates->email }}</td>
                                            {{-- <td>{{ $dates->password }}</td> --}}
                                            <td>@if ($dates->user_type == 1)
												ادمن
												@else
												موظف
											@endif </td>
                                            <td>{{ $dates->created_at }}</td>
                                            {{-- <td></td>
                                            <td></td> --}}
                                            <td>
                                                {{-- <button class="btn btn-outline-success btn-sm"
                                                    data-name="{{ $dates->name }}" data-user_id="{{ $dates->id }}"
                                                    data-password="{{ $dates->password}}"
                                                    data-toggle="modal"
                                                    data-target="#edit_Product">تعديل</button> --}}
                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale" 
														data-id="{{ $dates->id }}" data-name="{{ $dates->name }}"
														data-password="{{ $dates->password }}" data-email="{{ $dates->email }}"
                                                         data-user_type="{{ $dates->user_type }}"   data-toggle="modal" href="#exampleModal2"
														title="تعديل"><i class="las la-pen"></i></a>
    
                                                <button class="btn btn-outline-danger btn-sm "
                                                    data-pro_id="{{ $dates->id }}"
                                                    data-product_name="{{ $dates->name }}" data-toggle="modal"
                                                    data-target="#modaldemo9">حذف</button>
                                            </td>
                                    </tr>
                        @endforeach
                    @else
                        <span> لاتوجد مستخدمين بالنظام</span>
                        @endif

                        </tbody>



                        {{-- @endforeach --}}



                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!--div-->
        <!-- Basic modal -->

        <!-- End Basic modal -->
    </div>


    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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

               <form action="{{ url('users/update') }}" method="post" autocomplete="off">
                   {{method_field('patch')}}
                   @csrf
                   <div class="form-group">
                       <input type="hidden" name="id" id="id" value="">
                       <label for="recipient-name" class="col-form-label">اسم المستخدم:</label>
                       <input class="form-control" name="name" id="name" type="text">
                   </div>
                   <div class="form-group">
                       <label for="message-text" class="col-form-label">كلمة المرور:</label>
                       <input type="password" class="form-control" id="password" name="password">
                   </div>
                   <div class="form-group">
                    <label for="message-text" class="col-form-label">البريد الإلكتروني:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                <label for="message-text" class="col-form-label">نوع المستخدم:</label>
                {{-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label> --}}
                <select name="user_type" id="user_type" class="form-control" required>
                    {{-- @foreach ($user as $dates) --}}
<option value="">اختر الحالة</option>

<option value="1" @if ($dates->user_type  == 1) selected @endif>ادمن</option>
<option value="0" @if ($dates->user_type  == 0) selected @endif>موظف</option>                       
                    
                    {{-- @endforeach --}}
                </select>
                </div>
         
           <div class="modal-footer">
               <button type="submit" class="btn btn-primary">تاكيد</button>
               <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
           </div>
           </form>
       </div>
   </div>
</div>



    <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف المستخدم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="users/destroy" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <p>هل انت متاكد من عملية الحذف ؟</p><br>
                    <input type="hidden" name="pro_id" id="pro_id" value="">
                    <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">تاكيد</button>
                </div>
            </form>
        </div>
    </div>
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
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    
    <script>
	$('#exampleModal2').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id = button.data('id')
		var section_name = button.data('name')
		var description = button.data('email')
        var password = button.data('password')
        var user_type = button.data('user_type')
		var modal = $(this)
		modal.find('.modal-body #id').val(id);
		modal.find('.modal-body #name').val(section_name);
		modal.find('.modal-body #email').val(description);
        modal.find('.modal-body #password').val(password);
        modal.find('.modal-body #user_type').val(user_type);

	})
</script>

<script>
$('#modaldemo9').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var pro_id = button.data('pro_id')
    var product_name = button.data('product_name')
    var modal = $(this)

    modal.find('.modal-body #pro_id').val(pro_id);
    modal.find('.modal-body #product_name').val(product_name);
})
</script>

    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>
@endsection
