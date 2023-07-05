<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        table td
            {
            border-collapse: collapse;
            text-align: center;
        }
        #header {
            width:100%;
            height:100%;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .data tr th,
        .data tr td {
            padding: 5px;
            border: 1px solid black;
        }

        .data thead tr {
            background-color: black;
            border: 1px solid white;

        }

        .data thead tr th {
            color: white;
            border: 1px solid white;

        }
        .1{
        background: yellow;
        }
        .2{
            background: pink;
        }
        .3{
            background: #2c689c;
        color:white
        }
        .5{
            background: green;
            color:white

        }
        .6{
            background: #9F3A38;
            color:white

        }
    </style>
</head>
<body>
    <table id='header' class="data">
            <thead>
            <tr>
                <th rowspan="2"></th>
      @foreach($data['department'] as $department)
          <th colspan="5">{{$department->name}}</th>
            @endforeach

            </tr>
            <tr>

                @foreach($data['department'] as $department)
                    <th>فعلي</th>
                    <th>حضور</th>
                    <th>غياب</th>
                    <th>عذر</th>
                    <th>أرشيف</th>
                @endforeach

            </tr>

            </thead>
           <tbody>
@foreach($data['dates'] as $date)

    <tr>
        <td>{{$date}}</td>

    @foreach ($data['department'] as $department)
            <td class="{{$loop->iteration}}">{{ \App\Models\User::where('department_id', $department->id)->where('created_at','<=',$date)->count() }}
            </td>
            <td class="{{$loop->iteration}}">{{ \App\Models\attendance::where('department_id', $department->id)->where('status',1)->where('attendance_date',$date)->count() }}
            </td>
            <td class="{{$loop->iteration}}">{{ \App\Models\attendance::where('department_id', $department->id)->where('status',2)->where('attendance_date',$date)->count() }}
            </td>
            <td class="{{$loop->iteration}}">{{ \App\Models\attendance::where('department_id', $department->id)->where('status',3)->where('attendance_date',$date)->count() }}
            </td>
            <td class="{{$loop->iteration}}">{{ \App\Models\User::onlyTrashed()->where('department_id', $department->id)->where('deleted_at', '>=', $date)->count() }}
            </td>

        @endforeach
    </tr>
@endforeach
           </tbody>
        </table>


</body>

</html>
