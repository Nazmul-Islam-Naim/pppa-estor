<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Damage request mail from user</title>
</head>
<body>
    <h3>User Details:</h3>
    <div style="margin-left: 10px; padding:10px;">
        <strong>Name: </strong> {{$damage->user->name}}<br>
        <strong>Designation: </strong> {{$damage->user->designation->title}}<br>
        <strong>Department: </strong> {{$damage->user->department->title}}<br>
        <strong>Email: </strong> {{$damage->user->email}}<br>
        <strong>Note: </strong> {{$damage->note}}<br>
        <div>{{$damage->update_at}}</div>
    </div>

    <div>
        <h3>Damage Products Detail:</h3>
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
                @foreach ($damage->damageRequestProducts as $item)
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
