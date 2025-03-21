<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Data (Updated)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: left;
            margin-bottom: 10px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div class="header">
        <strong>User:</strong> {{ $userName }} <br>
        <strong>Date:</strong> {{ $currentDate }}
    </div>

    <div class="title">Updated Product Data</div>

    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Name</th>
                <th>Category</th>
                <th>Location</th>
                <th>Quantity Before</th>
                <th>Quantity After</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($updatedProducts as $product)
                <tr>
                    <td>{{ $product['product_code'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['category_id'] }}</td>
                    <td>{{ $product['location_id'] }}</td>
                    <td>{{ $product['quantity_before'] }}</td>
                    <td>{{ $product['quantity_after'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
