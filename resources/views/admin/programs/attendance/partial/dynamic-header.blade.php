@foreach ($dateSheet as $date)
    <th>
        {{ $date->attendance_date }}
    </th>
@endforeach
