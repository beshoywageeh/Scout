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
            <td colspan='4' style="width: 100%"><span>{{ $data['department']->name }}</span></td>
            <td rowspan="2" style="width: 100%">
                <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
            </td>
        </tr>
        <tr>
            <td style="width: 100%">إجمالي</td>
            <td style="width: 100%">{{ $data['department']->users->count() }}</td>
            <td style="width: 100%">أرشيف</td>
            <td style="width: 100%">
                {{ \App\Models\User::onlyTrashed()->where('department_id', $data['department']->id)->count() }}</td>
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
                <th>كود</th>

                <th>الاسم</th>
                <th>العنوان</th>
                <th>رقم التليفون</th>
                <th>تاريخ الميلاد</th>
                <th>تليفون البيت</th>
                <th>اب الاعتراف</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['department']->users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->code }}</td>
                    <td>{{ $user->first_name . ' ' . $user->second_name . ' ' . $user->third_name }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->birth_date }}</td>
                    <td>{{ $user->home_number }}</td>
                    <td>{{ $user->church_father }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</body>

</html>
