@extends('layouts.master')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }
    </style>
@endsection
@section('title')
امر عمل
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فاتورة مبيعات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                     طباعة امر عمل</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            {{-- <h1 class="invoice-title" style="color: black">فاتورة مبيعات</h1> --}}
                            <div>
                                <span style="    font-weight: bold;">التاريخ: 
                                    {{ date('Y-m-d') }}
                                 </span>
                                 <br>
                                 <span style="    font-weight: bold;">اليوم: 
                                     {{ date("d"); }}
                                  </span>
                            </div>
                           @if (! empty($our))
                           <div class="billed-from">
                           
                            <h4 style="color: black">{{ $our->logo_name }}</h4>
                            <h5>logo_name<br>
                                رقم الهاتف: {{$our->phone}}<br>
                                Email: {{$our->email}}</h5>
                        </div>
                           @endif
                            
                        </div>
                        <div class="row mg-t-20">
                        
                            <div class="col-md">
                                <h1 style="color: black; text-align:center" class="tx-gray-600">امر عمل داخلي </h1>
                             
                                <table class="mt-5 table table-dark">
                                    <thead class="text-white p-2">
                                        <tr>
                                            <th class="text-white" style="width: 10%;">الأسم  {{$bill->cn}}</th>
                                            
                                            <th style="width: 10%;" class="text-white">رقم الزبون {{ $bill->phone }}</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                               
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40" >
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th><h1>البيان</h1></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        
                                            @if ($item->type_Q == 3)
                                            <tr >
                                            <td>{{ $item->descripe }}</td>
                                            <td >{{ $item->name }}</td>
                                            
                                            <td >
                                                <p class="mr-5">{{$item->width}}</p>
                                                <div class="row">
                                                <div class="col-md-2">{{ $item->length }}</div>
                                                <div class="" style="width: 100px;height:100px;border:1px solid">
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                            @else
                                            <tr >
                                            <td >{{ $item->descripe }}</td>
                                            <td >{{ $item->name }}</td>
                                            <td class="col-md-5 row">
                                                {{$item->qoun}}
                                            </td>
                                            </tr>
                                            @endif
                                            
                                        
                                        <hr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5">
                            <div style="
                                width: 300px;;display: inline-block; margin-bottom: 40px;    font-weight: bold;
                                "> الإجمالي
                                <span style="
                                border: solid 1px;border-radius: 10px;padding-right: 10px;padding-left: 10px;
                            "></span>
                            </div>
                            <div
                            style="
                                width: 300px;display: inline-block;    font-weight: bold;
                                "
                            > المدفوع 
                                <span style="border: solid 1px;
                                border-radius: 10px;
                                padding-right: 10px;
                                padding-left: 10px;;"></span>
                            </div>
                            <div
                            style="
                                width: 300px;display: inline-block;    font-weight: bold;"
                            >الباقي
                                <span style="
                                border: solid 1px; border-radius: 10px;padding-right: 10px;padding-left: 10px;;
                                "></span>
                            </div>
                            
                        </div>
                        <span style="font-weight: bold;">
                            التوقيع: ..................
                        </span>
                        <hr class="mg-b-40">



                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>طباعة</button>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>


    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
        $(function(){
          
            $("body").on("load",
            printDiv()
            )
        })
    </script>

@endsection
