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
        th {
            text-align: center;
            border: 1px solid black;
        }

        thead,
        th {
            background-color: #ddd;
            color: black;
            padding: 0.2rem;

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

        .alert {
            font-weight: bold;
            font-size: 1.2em;
        }

        .alert-success {
            color: #155724
        }

        .alert-danger {
            color: #721c24;
        }

        .alert-warning {
            color: #856404;
        }

        .alert-info {
            color: #0c5460;
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
            <td style="width: 100%">حضور</td>
            <td style="width: 100%">{{ $data['came'] }}</td>
            <td style="width: 100%">غياب</td>
            <td style="width: 100%">{{ $data['absent'] }}</td>
            <td style="width: 100%">أعتذار</td>
            <td style="width: 100%">{{ $data['e3tezar'] }}</td>

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
                <th>الكود</th>
                <th>الاسم</th>
                <th>التاريخ</th>
                <th>الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['attendance'] as $attendance)
                <tr>
                    <td>{{ $attendance->users->code }}</td>
                    <td>{{ $attendance->users->full_name() }}</td>
                    <td>{{ $attendance->attendance_date }}</td>
                    {{ $attendance->status_check($attendance->status) }}
                </tr>
            @endforeach
        </tbody>



    </table>

</body>

</html>
