@extends('layouts.master')
@section('title')
    الايداع والسحب
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الايداع والسحب</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
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

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap text-center" id="">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0"></th>
                                    <th class="wd-15p border-bottom-0">بيان العملية</th>
                                    <th>النوع</th>
                                    <th class="wd-20p border-bottom-0">القيمة</th>
                                    <th class="wd-10p border-bottom-0">تاريخ المعاملة</th>
                                    <th class="wd-15p border-bottom-0">التحكم</th>
                                </tr>
                            </thead>
                            <tbody class="" id="myTable">
                                @foreach ($data as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item->title }}</td>
                                        <td>@if ($item->type)
                                            ايداع
                                            @else
                                            سحب
                                        @endif</td>
                                        <td>{{ $item->ammont }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ route('Wdtreasury.destroy',$item->id) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>

                                              </form>
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


    @if (session()->get('success'))
        <script>
            Swal.fire(
                'نجاح العملية!',
                '{{ session()->get('success') }}!',
                'success'
            )
        </script>
    @endif
    @if (session()->get('error'))
        <script>
            Swal.fire(
                'فشل العملية!',
                '{{ session()->get('error') }}!',
                'success'
            )
        </script>
    @endif
@endsection
