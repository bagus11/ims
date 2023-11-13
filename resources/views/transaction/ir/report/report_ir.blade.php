<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Detail Report {{$request_code}}</title>
</head>
<body>
    <div class="container" style="text-align:center">
        <p style="font-size:10px;margin-top:-10px">
            <b style="font-size:14px">Detail Report {{$request_code}}</b> <br>
        </p>
       <br>
    </div>
    <p style="font-size:10px">
        <b>General Transaction :</b>
    </p>
    <table class="table-general" style="width: 100%;font-size:14px;margin-top:10px">
        <tr>
            <td style="width : 15%">Transaction Code</td>
            <td style="width : 1%">:</td>
            <td style="width : 24%">{{$detail->request_code}}</td>
            <td style="width: 20%"></td>
            <td style="width: 15%"></td>
            <td style="width: 1%"></td>
            <td style="width: 24%"></td>
            
        </tr>
        <tr>
            <td style="width: 15%">PIC</td>
            <td style="width: 1%">:</td>
            <td style="width: 24%">{{$detail->userRelation->name}}</td>
            <td style="width: 20%"></td>
            <td style="width: 15%"></td>
            <td style="width: 1%"></td>
            <td style="width: 24%"></td>
        </tr>
        <tr>
            <td style="width: 15%">Src Location</td>
            <td style="width: 1%">:</td>
            <td style="width: 24%">{{$detail->locationRelation->name}}</td>
            <td style="width: 20%"></td>
            <td style="width: 20%">Des Location</td>
            <td style="width: 1% !important">:  </td>
            <td style="width: 19%;margin-top:30px !important">{{$detail->locationRelation->name}}</td>
        </tr>
        <tr>
            @php
                 $remark = str_replace(['<p>', '</p>','&nbsp;'], '', $detail->remark);
            @endphp
            <td  style="width: 15%">Remark</td>
            <td  style="width: 1%">:</td>
            <td  style="width: 44%">{{$remark}}</td>
            <td  style="width: 10%"></td>
            <td  style="width: 5%"></td>
            <td  style="width: 1%"></td>
            <td  style="width: 24%"></td>
        </tr>
       
    </table>

    <p style="font-size:10px">
        <b>Item Request : </b>
    </p>
    <table class="table-stepper">
        <thead>
            <tr>
                <th rowspan="2">Item Name</th>
                <th colspan="3">Quantity</th>
                <th rowspan="2">UOM</th>
            </tr>
            <tr>
                <th>Current</th>
                <th>Request</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php
                    $total = '';
                    if($detail->request_type != 2){
                        $total = $detail->itemRelation->quantity - $detail->quantity_request;
                    }else{
                        $total = $detail->itemRelation->quantity + $detail->quantity_request;
                    }
                @endphp
                <td>{{$detail->itemRelation->name}}</td>
                <td style="text-align: center">{{$detail->itemRelation->quantity}}</td>
                <td style="text-align: center">{{$detail->quantity_request}}</td>
                <td style="text-align: center">{{$total}}</td>
                <td style="text-align: center">{{$detail->itemRelation->uom}}</td>
            </tr>
        </tbody>
    </table>

    <p style="font-size:10px">
        <b>Detail Log Transaction : </b>
    </p>
    <table class="table-stepper">
        <thead>
            <tr>
                <th>Created At </th>
                <th>PIC</th>
                <th>Status</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @php
            
                $i = 0;
            @endphp
            @forelse ($log as $item)
                  @php
                      $status ='';
                      $approvalStatus ='-';
                      if($item->status== 1){
                          $status ='New';
                        }else if($item->status == 2){
                          $status ='On Queue '.$i;
                          if($item->approval_status == 1){
                            $approvalStatus= 'Approve';
                          }else{
                              $approvalStatus= 'Reject';
                          }
                        } else if($item->status == 3){
                            $status ='On Progress';
                        }else if($item->status == 4){
                            $status ='Checking';
                            if($item->checking == 1){
                                $approvalStatus ='Checking Done';
                            }else{
                                $approvalStatus ='Reject';
                            }
                        }else if($item->status == 5){
                            $status ='Revision';
                        }else if($item->status == 6){
                            $status ='Done';
                            if($item->checking == 1){
                                $approvalStatus ='Done';
                            }else{
                                $approvalStatus ='Reject';
                            }
                        }else{
                            $status ='Revision';
                        }
                        $remarkLog = str_replace(['<p>', '</p>','&nbsp;'], '', $item->comment);
                  @endphp
                    <tr>
                        <td style="text-align:center;width:15%">{{$item->created_at}}</td>
                        <td style="text-align:left;width:15%">{{$item->creatorRelation->name}}</td>
                        <td style="text-align:left;width:10%">{{$status}}</td> 
                        <td style="text-align:left;width:60%">{{$remarkLog}}</td>
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