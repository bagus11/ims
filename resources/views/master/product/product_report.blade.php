<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
    <title>Report Product {{date('Y-m-d')}}</title>
</head>
<body>
        <h6 style="text-align: center">Report Product {{date('d F Y')}}</h6>
        <table class="table-stepper">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Category</th>
                    <th>Location</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($data as $item)
                    <tr>
                        <td>{{$item->product_code}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->categoryRelation->name}}</td>
                        <td>{{$item->locationRelation->name}}</td>
                        <td>{{$item->quantity}}</td>
                    </tr>
               @endforeach
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