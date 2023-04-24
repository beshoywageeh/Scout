<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        table,
        td,
        th {
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
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>الكود</th>
                <th>الاسم</th>
                <th>العنوان</th>
                <th>اب الاعتراف</th>
                <th>التليفون الشخصي</th>
                <th>تليفون البيت</th>
                <th>تاريخ الارشفة</th>
            </tr>
        </thead>
        @foreach ($data['user'] as $user_data)
            @if (!empty($user_data->first_name))
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user_data->code }}</td>
                    <td>{{ $user_data->first_name . ' ' . $user_data->second_name . ' ' . $user_data->third_name }}
                    </td>

                    <td>{{ $user_data->adress }}</td>
                    <td>{{ $user_data->chruch_father }}</td>
                    <td>{{ $user_data->phone_number }}</td>
                    <td>{{ $user_data->home_number }}</td>
                    <td>{{ Carbon\Carbon::parse($user_data->deleted_at)->format('Y-m-d') }}</td>
                </tr>
            @else
            @endif
        @endforeach

        </tbody>
    </table>
</body>

</html>
