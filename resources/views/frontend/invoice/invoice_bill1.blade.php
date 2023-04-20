<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <title>فاتورة مبيعات</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {
            float: right;
            margin-top: 8px;
        }

        #logo img {
            height: 90px;
        }

        #company {
            float: left;
            text-align: left;
        }


        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 5px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {}

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        table td,
        table th {
            text-align: right !important
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

        @media print {

            .bt {
                display: none;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
                margin-top: 80px !important;
            }

            table th,
            table td {
                padding: 5px;
                background: #EEEEEE;
                text-align: center;
                border-bottom: 1px solid #FFFFFF;
            }

            table th {
                white-space: nowrap;
                font-weight: normal;
                background-color: #555555 !important;
                color: #fff !important;
            }

            table td {
                text-align: right;
            }

            table td h3 {
                color: #57B223;
                font-size: 1.2em;
                font-weight: normal;
                margin: 0 0 0.2em 0;
            }

            table .no {
                color: #FFFFFF;
                font-size: 1.6em;
                background: #57B223;
            }

            table .desc {
                text-align: left;
            }

            table .unit {
                background: #DDDDDD;
            }

            table .qty {}

            table .total {
                background: #57B223;
                color: #FFFFFF;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1.2em;
            }

            table tbody tr:last-child td {
                border: none;
            }

            table tfoot td {
                padding: 10px 20px;
                background: #FFFFFF;
                border-bottom: none;
                font-size: 1.2em;
                white-space: nowrap;
                border-top: 1px solid #AAAAAA;
            }

            table tfoot tr:first-child td {
                border-top: none;
            }

            table tfoot tr:last-child td {
                color: #57B223;
                font-size: 1.4em;
                border-top: 1px solid #57B223;

            }

            thead th,
            tbody td {

                border: 1px solid #57B223
            }
        }
    </style>
</head>

<body style="padding: 10px" onload="print()">
    <button onclick="print()" class="bt">طباعة</button>
    <header class="clearfix">
      @empty(! $our)
        <div id="logo">
            <img src="/Attachments/{{ $our->logo_photo}}">
        </div>
        <div id="company">
            <h2 class="name">{{ $our->logo_name }}</h2>
            <div>{{ $our->address }}</div>
            <div>{{ $our->phone }}</div>
            <div><a href="mailto:company@example.com">{{ $our->email }}</a></div>
        </div>
        @endempty
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <div class="to"> فاتورة الى:</div>
                <h2 class="name">{{ $bill->cn }}</h2>
                <div class="address">{{ $bill->phone }}</div>
                <div class="email"><a href="mailto:john@example.com">john@example.com</a></div>
            </div>
            <div id="invoice">
                <div class="date">تاريخ الفاتورة: {{ $bill->created_at }}</div>
            </div>
        </div>
        <h1 style="text-align: center">فاتورة {{ $bill->id }}</h1>
        <table  cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th class="unit">الصنف</th>
                    <th class="desc">الصنف</th>
                    <th class="unit">الكمية</th>
                    <th class="qty">السعر</th>
                    <th class="qty">التخفيض</th>
                    <th class="total">الاجمالي</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($item as $ite)
                    <tr>
                        <td class="no" style="font-size: 10px">{{ $i }}</td>
                        <td class="desc">
                            <h3>{{ $ite->name }}</h3>
                        </td>
                        <td class="desc">
                            <h3>{{ $ite->descripe }}</h3>
                        </td>
                        <td class="unit">{{ floatval($ite->qoun) }}</td>
                        <td class="qty">${{ floatval($ite->price) }}</td>
                        <td class="qty">${{ floatval($ite->descont) }}</td>
                        <td class="total">${{ floatval($ite->total) }}</td>
                    </tr>
                    @php
                        $i += 1;
                    @endphp
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="1">الاجمالي</td>
                    <td>${{ floatval($bill->total) }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="1">الخالص</td>
                    <td>${{ floatval($bill->sincere) }}</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td colspan="1">المتبقي</td>
                    <td>${{ floatval($bill->Residual) }}</td>
                </tr>
            </tfoot>
        </table>
        <div id="thanks">شكرا لك!</div>
        <div id="notices">
            <div>ملاحظة:</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>
