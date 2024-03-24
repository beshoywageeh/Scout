@foreach ($data['department'] as $department)
    <tr>
        <td>
            {{ $department->name }}
        </td>
        <td>
            {{ $department->users_count }}
        </td>
        <td>{{ $department->user_trashed() }}
        </td>
        <td>{{ $department->attendance_data($data['date'], 1) }}</td>
        <td>{{ $department->attendance_data($data['date'], 2) }}</td>
        <td>{{ $department->attendance_data($data['date'], 3) }}</td>

    </tr>
@endforeach
