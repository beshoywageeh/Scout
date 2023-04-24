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
            text-align: center;
            border: 1px solid black;
        }
        thead,
        th {
            background-color: black;
            color: white;
        }

        #header,
        .data {
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
            margin: auto;
        }

        .logo {
            width: 100vw;
            border-radius: 50%;
        }

        .data {
            width: 100%;
        }
    </style>
</head>

<body>
    <table id='header'>

        <tr>
            <td rowspan="2" style="width: 100%">

                @if (is_null($data['department']->image))
                    <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
                @else
                    <img class='logo'
                        src="{{ asset('storage/attachments/departments/' . $data['department']->image->filename) }}">
                @endif

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
