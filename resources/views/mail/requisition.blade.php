<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisition mail from user</title>
</head>
<body>
    <h3>User Details:</h3>
    <div style="margin-left: 10px; padding:10px;">
        <strong>Name: </strong> {{$requisition->user->name}}<br>
        <strong>Designation: </strong> {{$requisition->user->designation->title}}<br>
        <strong>Department: </strong> {{$requisition->user->department->title}}<br>
        <strong>Email: </strong> {{$requisition->user->email}}<br>
        <strong>Note: </strong> {{$requisition->note}}<br>
        <div>{{date('d F Y h:i A',strtotime('2023-04-15'))}}</div>
    </div>

    <div>
        <h3>Products Detail:</h3>
        <table>
            <thead>
                <tr>
                    <th style="border: 1px solid #eee; width:5%; text-align:center">Sl</th>
                    <th style="border: 1px solid #eee; width:55%; text-align:left">Product</th>
                    <th style="border: 1px solid #eee; width:20%; text-align:center">Quantity</th>
                    <th style="border: 1px solid #eee; width:20%; text-align:center">Unit</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ;?>
                @foreach ($requisition->requisitionProducts as $item)
                <tr>
                    <td style="border: 1px solid #eee; width:5%; text-align:center">{{$counter++}}</td>
                    <td style="border: 1px solid #eee; width:55%; text-align:left">{{$item->product->name}}</td>
                    <td style="border: 1px solid #eee; width:20%; text-align:center">{{$item->quantity}}</td>
                    <td style="border: 1px solid #eee; width:20%; text-align:center">{{$item->product->unit->name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</body>
</html>