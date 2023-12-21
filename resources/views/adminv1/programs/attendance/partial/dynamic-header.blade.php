@foreach ($dateSheet as $date)
    <th style="font-size:11px;padding:5px;">
        {{ $date->attendance_date }}
    </th>
@endforeach
