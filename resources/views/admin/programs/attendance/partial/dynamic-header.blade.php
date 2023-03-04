@foreach ($dateSheet as $date)
    <th>
        {{ $date->attendance_date }}
        {{ $date->attendance_id }}
    </th>
@endforeach
