<html dir="rtl">
  <head>
    <title>ايصال قبض</title>
  </head>
  <style>
    .main{
      border: 1px solid #3a3a3a;
      padding: 10px;
    }
    .header ,.footer{
      display: flex;
    justify-content: space-between;
    }
    .header h2{
      margin-top: 80px;
    }
    .header .header-rigth{
      text-align: center;
    }
    .header img{
      width: 150px;
      height: 100px;
    } 
    .body{
      border-top: 1px  #3a3a3a;
      border-bottom: 1px #3a3a3a;
      padding: 30px;
    }
    table{
      width: 100%;
    }
    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th,td{
  padding: 15px;
}
  </style>
  <body onload="print()">
    <div style="width: 95%;margin: auto;">
        <div class="main">
            <div class="header">
              <div class="header-rigth">
                @if (! empty($our))
                  <img src="/Attachments/{{$our->logo_photo}}" >
                  <p> {{ $our->logo_name }}</p>
                  <p>{{ $our->phone }}</p>
                  <p>{{ $our->email }}</p>
                @endif
              </div>
              <div>
                <h2>ايصال قبض قيمة </h2>
                <div> ايصال رقم: {{$bill->id}} </div>
              </div>
              <div class="header-left">
                <p>{{ date('Y-m-d') }}</p>
              </div>
            </div>
            <div class="body">
              
              <table style="margin-bottom: 30px;">
                <thead style="background-color: #3a3a3a ;color: #fff;">
                  <tr>
                    <th>استلام من </th>
                    <td>{{ $bill->cn }}</td>
                    <th>رقم الهاتف</th>
                    <td>{{ $bill->phone }}</td>
                  </tr>
                </thead>
            </table>

            <table>
              <thead>
                <tr>
                  <th>مبلغا وقدره</th>
                  <td>{{ floatval($bill->price) }}</td>
                  <th>المتبقي عليه</th>
                  <td>{{ floatval($total->Residualsum) }}</td>
                </tr>
              </thead>
            </table>
            </div>
            <div class="footer" style="margin-top: 30px;">
              <h5>اسم الموظف المسؤوول  :{{$bill->name}}</h5>
              <h5>التوقيع : .......................</h5>
            </div>
        </div>
    </div>
  </body>
</html>