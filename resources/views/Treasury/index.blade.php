@extends('layouts.master')

@section('title')
    الخزينة
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet"> --}}
@endsection

@empty($treasury)
    @section('content')
        <div class=" text-center">
            <div class="card" style="margin:auto;margin-top: 100px;max-width: 450px;">
                <div class="card-body">
                    <p>ليس لديك خزينة </p>
                    <p>هل تريد انشاء خزينة </p>
                    <button class="btn btn-primary text-white" data-target="#select2modal" data-toggle="modal">خزينة جديد
                    </button>
                </div>
            </div>
        </div>
        <div class="modal" id="select2modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">انشاء خزينة</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <h6>ادخل البيانات</h6>
                        <form method="post" action="{{ route('treasury.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>الاسم</label>
                                <input type="text" name="name" class="form-control" value="الخزينة الرئيسية" required>
                            </div>
                            <div class="form-group">
                                <label>الرصيد الافتتاحي</label>
                                <input type="text" name="amount" min=0 id="amount" required class="form-control">

                            </div>
                            <div class="form-group">
                                <label>رأس المال</label>
                                <input type="text" name="capital" min="0" id="capital" required
                                    class="form-control">

                            </div>
                            <button class="btn ripple btn-primary" id="save-client" type="submit"><span
                                    class="spinner-border spinner-border-sm sp" style="display: none"></span><span
                                    class="text">حفظ</span></button>
                        </form>
                        <!-- Select2 -->
                    </div>
                    <div class="modal-footer">

                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endempty

@empty(!$treasury)
    @section('page-header')
        <!-- breadcrumb -->

        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ادارة
                        الخزينة</span>
                </div>
            </div>
            <div class="d-flex my-xl-auto right-content">
                {{-- <div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div> --}}
                <div class="pr-1 mb-3 mb-xl-0">
                    <button type="button" id="refrech" class="btn btn-danger btn-icon ml-2"><i
                            class="mdi mdi-refresh"></i></button>
                </div>
                <div class="pr-1 mb-3 mb-xl-0">
                    <button type="button" data-target="#diposit" data-toggle="modal" class="btn btn-primary ml-2"><i
                            class="mdi mdi-plus"></i> سحب </button>
                    <button type="button" data-target="#w" data-toggle="modal" class="btn btn-primary ml-2"><i
                            class="mdi mdi-plus"></i> ايداع </button>
                </div>
            </div>
        </div>
        <!-- breadcrumb -->
    @endsection
    @section('content')
        <!-- Grid موديل اضافة بيانات الخزينة -->
        <!-- row -->
        <div class="row row-sm">
            <div class="col-md-12">
                <h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">راس المال</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $treasury->capital }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">رأس المال</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7">{{ $treasury->capital }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">اجمالي الخزينة</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $treasury->amount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي الخزينة</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $treasury->amount }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-sm">
            <div class="col-md-12">
                <h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">

                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">الواردات</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $pay + $w }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">الواردات</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $pay + $w }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">الصادرات</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $exc + $exa + $d + $asset }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">الصادرات</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7">{{ $exc + $exa + $d + $asset }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">اجمالي الواردات - الصادرات</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ ($pay + $w )-($exc + $exa + $d + $asset) }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">القيمة</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ ($pay + $w )-($exc + $exa + $d + $asset) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">اجمالي الخزينة</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $treasury->amount }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي الخزينة</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $treasury->amount }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->

        <!-- row -->
        <div class="row row-sm">
            <div class="col-md-12">
                <h4 class="content-title mb-0 my-auto">المبيعات & المشتريات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">

                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">المبيعات</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $sales }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي قيمة المبيعات</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $sales }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">ايصالات القبض</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $pay }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي ايصالات القبض</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7">{{ $pay }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">فواتير المشتريات </h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $prus }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي قيمة فواتير المشتريات</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $prus }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">ايصالات الصرف للمورد</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $exc }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7"> اجمالي قيمة ايصالات الصرف للمورد</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $exc }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">ايصالات الصرف الاخرى</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $exa }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي ايصالات الصرف</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7">{{ $exa }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->


        <!-- row -->
        <div class="row row-sm">
            <div class="col-md-12">
                <h4 class="content-title mb-0 my-auto">الاصول</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">

                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">الاصول التابتة</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $sales }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي قيمة الاصول الثابتة</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-up text-white"></i>
                                    <span class="text-white op-7">{{ $asset }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">(المواد الخام)الاصول المتداولة</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $raw }}</h4>
                                    <p class="mb-0 tx-12 text-white op-7">اجمالي الاصول المتداولة</p>
                                </div>
                                <span class="float-right my-auto mr-auto">
                                    <i class="fas fa-arrow-circle-down text-white"></i>
                                    <span class="text-white op-7">{{ $raw }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- row closed -->
        <!--End Grid modal -->

        <div class="modal" id="diposit">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">سحب</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('treasury.deposit') }}">
                            @csrf
                            <div class="form-group">
                                <label>البيان</label>
                                <input type="text" name="title" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>الرصيد </label>
                                <input type="text" name="ammont" min="0" id="ammont" required
                                    class="form-control">
                                <input type="hidden" name="type" value="0">
                            </div>

                            <button class="btn ripple btn-primary" id="save-client" type="submit"><span
                                    class="spinner-border spinner-border-sm sp" style="display: none"></span><span
                                    class="text">حفظ</span></button>
                        </form>
                        <!-- Select2 -->
                    </div>
                    <div class="modal-footer">

                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="w">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">ايداع</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('treasury.deposit') }}">
                            @csrf
                            <div class="form-group">
                                <label>البيان</label>
                                <input type="text" name="title" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>الرصيد </label>
                                <input type="text" name="ammont" min="0" id="ammont" required
                                    class="form-control">
                                <input type="hidden" name="type" value="1">
                            </div>

                            <button class="btn ripple btn-primary" id="save-client" type="submit"><span
                                    class="spinner-border spinner-border-sm sp" style="display: none"></span><span
                                    class="text">حفظ</span></button>
                        </form>
                        <!-- Select2 -->
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                    </div>
                </div>
            </div>
        </div>
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

        <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
        @if (Session::has('success'))
            <script>
                $(function() {
                    Swal.fire(
                        'تم العملية بنجاح !',
                        "{{ Session::get('success') }}",
                        'success'
                    )
                })
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                $(function() {
                    Swal.fire(
                        'تم العملية بنجاح !',
                        "{{ Session::get('error') }}",
                        'success'
                    )
                })
            </script>
        @endif
    @endsection
@endempty
