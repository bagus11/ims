<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Petty Cash Voucher</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <p style="font-size:10px;margin-top:-10px">
            <b style="font-size:14px">Petty Cash Voucher</b> <br>
        </p>
       <br>
      
    </div>
    <p style="font-size:10px">
        <b>General Transaction : </b>
    </p>
    <table style="width: 40%; font-size:11px;font-family: Arial, Helvetica, sans-serif;margin-left:20px;">
        <tr>
            <td style="width :2%">PC Code</td>
            <td style="width: 1%"> : </td>
            <td style="width: 50%"> {{$pc_code}} </td>
        </tr>
        <tr>
            <td style="width :2%">Request By</td>
            <td style="width: 1%"> : </td>
            <td style="width: 50%"> {{$data->picRelation->name}} </td>
        </tr>
        <tr>
            
            <td style="width :2%">Location</td>
            <td style="width: 1%"> : </td>
            <td style="width: 50%"> {{$data->locationRelation->name}} </td>
        </tr>
        <tr>
            <td style="width :2%">Department</td>
            <td style="width: 1%"> : </td>
            <td style="width: 50%"> {{$data->departmentRelation->name}} </td>
        </tr>
               {{-- Terbilang  --}}
               @php
               function penyebut($nilai) {
                   $nilai = abs($nilai);
                   $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                   $temp = "";
                   if ($nilai < 12) {
                   $temp = " ". $huruf[$nilai];
                   } else if ($nilai <20) {
                   $temp = penyebut($nilai - 10). " belas";
                   } else if ($nilai < 100) {
                   $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
                   } else if ($nilai < 200) {
                   $temp = " seratus" . penyebut($nilai - 100);
                   } else if ($nilai < 1000) {
                   $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
                   } else if ($nilai < 2000) {
                   $temp = " seribu" . penyebut($nilai - 1000);
                   } else if ($nilai < 1000000) {
                   $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
                   } else if ($nilai < 1000000000) {
                   $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
                   } else if ($nilai < 1000000000000) {
                   $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
                   } else if ($nilai < 1000000000000000) {
                   $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
                   }     
                   return $temp;
               }
               
               function terbilang($nilai) {
                   if($nilai<0) {
                   $hasil = "minus ". trim(penyebut($nilai));
                   } else {
                   $hasil = trim(penyebut($nilai));
                   }     
               return $hasil;
               }
   
               // Format Rupiah 
               function rupiah($angka){
                   
                   $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                   return $hasil_rupiah;
                   
               }
               // Format Rupiah 
           
           @endphp
           {{-- Terbilang  --}}
        <tr>
            <td style="width :2%">Amount</td>
            <td style="width: 1%"> : </td>
            <td style="width: 50%"> {{rupiah($data->amount)}} ({{terbilang($data->amount)}} rupiah)</td>     
        </tr>
        <tr>
            <td style="width :2%">Remark</td>
            <td style="width: 1%"> : </td>
            <td style="width: 80%"> {{$data->remark}} </td>
        </tr>

    </table>

    <p style="font-size:10px">
        <b>Detail Transaction : </b>
    </p>
    <table class="table-stepper" style="margin-left: 40px;margin-right:40px">
        <thead>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Sub Category Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
          @foreach ($dataProduct as $item)
         
              <tr>
                <td style="text-align: center">{{$no}}</td>
                <td>{{$item->categoryRelation->name}}</td>
                <td>{{$item->subcategory_name}}</td>
                <td style="text-align: right">Rp.{{number_format($item->amount, 2, ",", ".")}}</td>
              </tr>
              @php
                  $no ++;
              @endphp
          @endforeach
        </tbody>
    </table>
    <br>
    <div class="container">
        <p style="font-size: 9px;text-align:right;margin-bottom:5px"> {{date('F d Y')}}</p>
       <table style="width: 100%;font-size:9px;">
           <tr>
               <td style="width: 13%;text-align:center"> Requested By</td>
               <td style="width:20%"></td>
               <td style="width: 33%;text-align:center"> Dikerjakan</td>
               <td style="width:20%"></td>
               <td style="width: 13%;text-align:center;">Mengetahui</td>
           </tr>
       </table>
 
       <table style="width: 100%;font-size:9px">
           <tr>
               <td style="width: 13%;text-align:center">
                <img src="{{$data->picRelation->signature}}" alt="" style="width: 150px; margin-left:30px">
                </td>
               <td style="width:20%"></td>
               <td style="width: 33%;text-align:center"></td>
               <td style="width:20%"></td>
               <td style="width: 13%;text-align:center;">
                <img src="
                {{$data->status == 3 ? $cashier->approvalRelation->signature : ''}}" alt=""  style="width: 150px; margin-left:30px">
                </td>
           </tr>
       </table>
       <table style="width: 100%;font-size:9px;margin-top:20px">
           <tr>
               <td style="width: 13%;text-align:center">{{$data->picRelation->name}}</td>
               <td style="width:20%"></td>
               <td style="width: 33%;text-align:center">Bagus SLamet Oetomo</td>
               <td style="width:20%"></td>
               <td style="width: 13%;text-align:center;"> {{$cashier->approvalRelation->name}}
                </td>
           </tr>
       </table>

    </div>
</body>
</html>
<style>
      .table-stepper{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        border: 1px solid #ddd;
        
  }
    .table-stepper tr:nth-child(even){background-color: #f2f2f2;}

    .table-stepper tr:hover {background-color: #ddd;}

    .table-stepper th {
        border: 1px solid #ddd;
        padding-top: 10px;
        padding-bottom: 10px;
        font-size: 9px;
        text-align: center;
        background-color: #26577C;
        color: white;
        overflow-x:auto !important;
    }
    .table-stepper td, .datatable-stepper th {
        border: 1px solid #ddd;
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }







    .table-general{
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 9px;
        width: 100% !important;
        border: 1px solid #ddd;
        
  }
    .table-general tr:nth-child(even){background-color: #f2f2f2;}

    .table-general tr:hover {background-color: #ddd;}

    .table-general th {
        border: 1px solid  rgb(182, 181, 181);
        padding-top: 5px;
        font-size: 9px;
        padding-bottom: 5px;
        text-align: center;
        /* background-color: #D61355; */
        color: rgb(123, 121, 121);
        overflow-x:auto !important;
    }
    .table-general td, .datatable-general th {
        /* border: 1px solid #ddd; */
        padding: 8px;
       
    }
    table tr:last-child {
        font-weight: bold;  
    }
</style>