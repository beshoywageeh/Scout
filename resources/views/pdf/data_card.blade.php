<!DOCTYPE html>
<html lang="ar" dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data['user']->first_name . ' ' . $data['user']->second_name}}</title>
    <style>
        table {
            display: flex;
            width: 100%;
            overflow: auto;
        }

       
       table td,
    {
            text-align: center;
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="2">الكود</td>
            <td colspan="2">{{ $data['user']->code }}</td>
        </tr>
        <tr>
            <td>الاسم</td>
            <td>{{ $data['user']->first_name . ' ' . $data['user']->second_name . ' ' . $data['user']->third_name }}
            </td>
            <td>القطاع</td>
            <td>{{ $data['user']->department->name }}</td>

        </tr>
        <tr>
            <td>التليفون</td>
            <td>{{ $data['user']->phone_number }}</td>
            <td>تليفون المنزل</td>
            <td>{{ $data['user']->home_number }}</td>
        </tr>
        <tr>
            <td>العنوان</td>
            <td>{{ $data['user']->address }}</td>
            <td>أب الاعتراف</td>
            <td>{{ $data['user']->church_father }}</td>
        </tr>
        <tr>
            <td>تاريخ الميلاد</td>
            <td>{{ $data['user']->birth_date }}</td>
            <td>تاريخ الالتحاق</td>
            <td>{{ $data['user']->join_date }}</td>
        </tr>
        <tr>
            <td>اجمالي الحضور</td>
            <td>{{ $data['attendance'] }}
            </td>
            <td>اجمالي الشارات</td>
            <td>{{ $data['user']->badges_count }}</td>
        </tr>
    </table>
</body>

</html>
