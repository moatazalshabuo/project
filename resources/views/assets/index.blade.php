@extends('layouts.master')
@section('title')
    الاصول
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
                <h4 class="content-title mb-0 my-auto">الاصول</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <button type="button" data-target="#w" data-toggle="modal" class="btn btn-primary ml-2"><i
                        class="mdi mdi-plus"></i> اضافة صنف</button>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="get">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label>البحث </label>
                                <input type="text" name="name" value="@isset($_GET['name']){{ $_GET['name']; }}@endisset" placeholder="بيان الاصل" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-outline-primary mt-3" value="بحث">
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
                                    <th class="wd-15p border-bottom-0"></th>
                                    <th class="wd-15p border-bottom-0">بيان الاصل</th>
                                    <th class="wd-20p border-bottom-0">القيمة</th>
                                    <th class="wd-15p border-bottom-0">المستخدم </th>
                                    <th class="wd-10p border-bottom-0">تاريخ المعاملة</th>
                                    <th class="wd-15p border-bottom-0">التحكم</th>
                                </tr>
                            </thead>
                            <tbody class="" id="myTable">
                                @foreach ($data as $item)
                                    <tr>
                                        <td></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->value }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ route('asset.destroy',$item) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>

                                              </form>
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
    <div class="modal" id="w">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة اصل</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('asset.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                          <label>اسم الأصل</label>
                          <input type="text" name="name" required value="{{old('name')}}" class="form-control">
                        </div>
                        <div class="form-group">
                          <label>القيمة</label>
                          <input type="number" name="value" required min="0" value="{{old('value')}}" class="form-control">
                        </div>
                        <button class="btn ripple btn-primary"  type="submit">حفظ</button>
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
