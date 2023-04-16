<html dir="rtl">
  <head>
    <title>ايصال صرف</title>
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
                <img src="ttachments/{{ $our->logo_photo}}" >
                <p> {{ $sys->logo_name }}</p>
                <p>{{ $sys->phone }}</p>
                <p>{{ $sys->email }}</p>
              </div>
              <div>
                <h2>ايصال صرف قيمة </h2>
                <div> ايصال رقم: {{$bill->id}} </div>
              </div>
              <div class="header-left">
                <p>{{ date('Y-m-d') }}</p>
              </div>
            </div>
            <div class="body">
              
              <table style="margin-bottom: 30px;">
                <thead style="background-color: #3a3a3a ;color: #fff;">
                  @if ($bill->type == 0)
                  <tr>
                    <th>استلام من </th>
                    <td>{{ $bill->cn }}</td>
                    <th>رقم الهاتف</th>
                    <td>{{ $bill->phone }}</td>
                  </tr>    
                  @else
                  <tr>
                    <th>البيان  </th>
                    <td colspan="3">{{ $bill->desc }}</td>
                  </tr>
                  @endif
                  
                </thead>
            </table>

            <table>
              <thead>
                <tr>
                  <th>مبلغا وقدره</th>
                  <td>{{ $bill->price }}</td>
                  @if ($bill->type == 0)
                  <th>المتبقي له</th>
                  <td>{{ $total->Residualsum }}</td>
                  @endif
                </tr>
              </thead>
            </table>
            </div>
            <div class="footer" style="margin-top: 30px;">
              <h5>اسم الموظف المسؤوول  : {{$bill->username}}</h5>
              <h5>التوقيع : .......................</h5>
            </div>
        </div>
    </div>
  </body>
</html>