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
    <table id='header'>

        <tr>
            <td rowspan="3" style="width: 100%">

                @if (is_null($data['department']->image))
                    <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
                @else
                    <img class='logo'
                        src="{{ asset('storage/attachments/departments/' . $data['department']->image->filename) }}">
                @endif

            </td>
            <td colspan='6' style="width: 100%">{{ $data['department']->name }}</td>
            <td rowspan="3" style="width: 100%">
                <img class='logo' src="{{ asset('images/login-banner.jpg') }}">
            </td>
        </tr>
        <tr>
            <td colspan='2'> من تاريخ :
                {{ date($data['from']) }}

            </td>
            <td colspan='2'> الي تاريخ :
                {{ date($data['to']) }}

            </td>
            <td colspan='2'> تاريخ الطباعه :
                {{ date('Y-m-d') }}

            </td>

        </tr>
    </table>
    <table class="data">
    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">الكود</th>
                                            <th rowspan="2">الاسم</th>
                                            <th colspan="3">الحالة</th>
                                        </tr>
                                        <tr>
                                            <th>ح</th>
                                            <th>غ</th>
                                            <th>ع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['user'] as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->code }}</td>
                                                <td>{{ $user->full_name() }}</td>

                                                {{ $user->count_status($data['from'], $data['to'], $user->code, $user->department_id) }}

                                            </tr>
                                        @endforeach
                                    </tbody>



    </table>

</body>

</html>
