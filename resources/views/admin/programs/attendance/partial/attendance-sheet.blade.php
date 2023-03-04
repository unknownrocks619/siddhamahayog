@php
    // $attendanceGroupByStudent = \Illuminate\Support\Arr::keyBy($all_attendance, 'attendance_date_id');
@endphp
@foreach (array_chunk($studentList, 500) as $chunked)
    @foreach ($chunked as $member)
        <tr>

            <td>
                {{ $member->full_name }}

            </td>
            @foreach ($dateSheet as $date)
                @php
                    $present = false;
                    $attendanceList = \Illuminate\Support\Arr::where($all_attendance, function ($value, $key) use ($date, $member) {
                        if ($value->attendance_date_id == $date->attendance_id && $value->student == $member->user_id) {
                            return $value;
                        }
                    });
                    if (count($attendanceList) >= 1) {
                        $present = true;
                    }
                @endphp
                <td @if ($present) class="bg-success" @else class='bg-danger' @endif>
                    <span class="text-white">
                        @if ($present)
                            Present
                        @else
                            Absent
                        @endif
                    </span>
                </td>
            @endforeach
        </tr>
    @endforeach
@endforeach
