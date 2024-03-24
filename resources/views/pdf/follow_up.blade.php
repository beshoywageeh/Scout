<!DOCTYPE html>
<html lang="ar" dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>كروت المتابعه</title>
    <style>
        table td,
            {
            border-collapse: collapse;
            text-align: center;
        }

        #header,
            {
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
            margin: auto;
        }

        #header {
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .logo {
            width: 100vw;
            border-radius: 50%;
        }

        .data {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .data tr th,
        .data tr td {
            padding: 5px;
            border: 1px solid #6d6d6d;
        }

        .data thead tr {
            background-color: black;

        }

        .data thead tr th {

            color: white;
        }

        #header tr th,
        #header tr td {
            padding: 5px;
            border: 1px solid #6d6d6d;
        }
    </style>
</head>

<body>
    @foreach ($data['users'] as $user )
    <table id='header'>
        <tr>
            <td rowspan="3" style="width: 100%">

                @if (is_null($user->department->image))
                    <img style="width:100px,height:100px" class='logo' src="{{ asset('images/login-banner.jpg') }}">
                @else
                    <img class='logo'
                        src="{{ asset('storage/attachments/departments/' . $user->department->image->filename) }}">
                @endif

            </td>
            <td colspan='6' style="width: 100%">{{ $user->code }}</td>

            <td rowspan="3" style="width: 100%">
                <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
            </td>
        </tr>
        <tr>
            <td colspan='6' style="width:100%">{{ $user->full_name() }} </td>

        </tr>
    </table>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>التاريخ</th>
                <th>قداس</th>
                <th>خدمة</th>
                <th>إعتراف</th>
            </tr>
        </thead>
        @foreach ($data['dates'] as $date )
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$date->format('d-m-Y')}}</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
        @endforeach
    </table>
    @endforeach
</body>

</html>
