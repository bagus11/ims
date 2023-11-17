<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reminder</title>
</head>
<body>
    <p style="font-size:11px">
        Dear {{$user}}, <br>
        Please immediate request <b>{{$data->name}}</b> to a minimum of {{$data->min_quantity}} {{$data->uom}}. 
        <br>
        Current quantity of this stock is {{$data->quantity}} {{$data->uom}}. 
        <br>
        <br>
        <br>
        For detail of the work order transaction, please click  <a href="{{ url('master_product')}}">here</a> <br> 
        Thank you for your cooperation
    </p>
  
</body>
</html>