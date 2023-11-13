<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Stock Move Report ({{$from}} - {{$to}})</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <p style="font-size:10px;margin-top:-10px">
            <b style="font-size:14px">Stock Move Report</b> <br>
            period : {{date("d-m-Y", strtotime($from))}} - {{date("d-m-Y", strtotime($to))}}
        </p>
       
    </div>
    <p style="font-size:10px">
        <b>Stock move list :</b>
    </p>
  
    <table class="table-stepper">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Created At</th>
                <th rowspan="2">Request Code</th>
                <th rowspan="2">Item Name</th>
                <th rowspan="2">Location</th>
                <th rowspan="2">Des Location</th>
                <th colspan="3">Quantity</th>
                <th rowspan="2">UOM</th>
                <th rowspan="2">PIC</th>
                <th rowspan="2">Remark</th>
            </tr>
            <tr>
                <th>Before</th>
                <th>Request</th>
                <th>Current</th>
            </tr>
        </thead>
        <tbody>
            @php
            
                $i = 0;
            @endphp
            {{$data}}
            @forelse ($data as $item)
                    @php
                        $remark = str_replace(['<p>', '</p>'], '', $item->transactionRelation->remark);
                    @endphp
                    <tr>
                        <td style="text-align:center;width:5%">{{$i+1}}</td>
                        <td style="text-align:center;width:10%">{{$item->created_at}}</td>
                        <td style="text-align:center;width:10%">{{$item->transactionRelation->request_code}}</td>
                        <td style="text-align:left;width:10%">{{$item->itemRelation->name}}</td>
                        <td style="text-align:left;width:10%">{{$item->locationRelation->name}}</td>
                        <td style="text-align:left;width:10%">{{$item->desLocationRelation->name}}</td>
                        <td style="text-align:center;width:5%">{{$item->quantity}}</td>
                        <td style="text-align:center;width:5%">{{$item->quantity_request}}</td>
                        <td style="text-align:center;width:5%">{{$item->quantity_result}}</td>
                        <td style="text-align:center;width:5%">{{$item->itemRelation->uom}}</td>
                        <td style="text-align:left;width:15%">{{$item->transactionRelation->userRelation->name}}</td>
                        <td style="text-align:left;width:25%">{{$remark}}</td>
                     
                    </tr>
                @php
                    $i++;
                @endphp
            @empty
                    <tr>
                        <td colspan="13">
                            Data is empty
                        </td>
                    </tr>
            @endforelse
        </tbody>
    </table>
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
</style>