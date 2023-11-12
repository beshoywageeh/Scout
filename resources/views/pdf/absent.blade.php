<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['department']->name }}</title>
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
        .data thead tr{
            background-color: black;

        }
        .data thead tr th{

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
    <table id='header'>

        <tr>
            <td rowspan="2" style="width: 100%">

                    <img class='logo' src="{{ $data['path'] }}">


            </td>
            <td colspan='4' style="width: 100%">{{ $data['department']->name }}</td>
            <td rowspan="2" style="width: 100%">
                <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
            </td>
        </tr>
        <tr>
            <td style="width: 100%">غياب</td>
            <td style="width: 100%">{{ $data['absent'] }}</td>
            <td style="width: 100%">أعتذار</td>
            <td style="width: 100%">{{ $data['e3tezar'] }}</td>

        </tr>
        <tr>
            <td colspan='6'> تاريخ الطباعه :
                {{ date('Y-m-d') }}

            </td>

        </tr>
    </table>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>الكود</th>
                <th>الاسم</th>
                <th>الحالة</th>
                <th>التليفون الشخصي</th>
                <th>تليفون البيت</th>
            </tr>
        </thead>
        @foreach ($data['attendance'] as $user_data)
            @if (!empty($user_data->users->first_name))
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user_data->users->code }}</td>
                    <td>{{ $user_data->users->first_name . ' ' . $user_data->users->second_name . ' ' . $user_data->users->third_name }}
                    </td>

                    <td>{{ $user_data->status == 2 ? 'غياب' : 'اعتذار' }}</td>
                    <td>{{ $user_data->users->phone_number }}</td>
                    <td>{{ $user_data->users->home_number }}</td>
                </tr>
            @else
            @endif
        @endforeach

        </tbody>
    </table>
</body>

</html>
