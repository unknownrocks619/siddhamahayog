@php
    $studentAttendance = [];
    $importedDate = [];
@endphp
@foreach ($studentList as $member)
    <tr>
        <td>
            {{ $member->full_name }}
        </td>
        <td>
            {{ $member->phone_number }}
            <br />
            {{ $member->email }}
        </td>
        @foreach ($dateSheet as $date)
            @php
                $present = false;
                $attendanceList = \Illuminate\Support\Arr::where($all_attendance, function ($value, $key) use ($date, $member) {
                    if ($value->attendance_date_id == $date->attendance_id && $value->student == $member->user_id) {
                        return $value;
                    }
                });

                if (!isset($studentAttendance[$member->user_id])) {
                    $studentAttendance[$member->user_id] = ['present' => 0, 'absent' => 0];
                }

                if (!isset($storedCount[$date->attendance_id])) {
                    $storedCount[$date->attendance_id] = ['present' => 0, 'absent' => 0];
                }

                if (count($attendanceList) >= 1) {
                    $present = true;
                    $storedCount[$date->attendance_id]['present'] = $storedCount[$date->attendance_id]['present'] + 1;
                } else {
                    $storedCount[$date->attendance_id]['absent'] = $storedCount[$date->attendance_id]['absent'] + 1;
                }

                if (!in_array($date->attendance_id, $importedDate)) {
                    if ($present) {
                        $studentAttendance[$member->user_id]['present'] = $studentAttendance[$member->user_id]['present'] + 1;
                    } else {
                        $studentAttendance[$member->user_id]['absent'] = $studentAttendance[$member->user_id]['absent'] + 1;
                    }
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

        <td>
            <span class="badge bg-label-success px-2 fs-5 mb-1 d-block">P :
                {{ $studentAttendance[$member->user_id]['present'] }}</span>
            <span class="badge bg-label-danger px-2 fs-5">A :
                {{ $studentAttendance[$member->user_id]['absent'] }}</span>
        </td>
    </tr>
@endforeach

@php
    $GLOBALS['attendance'] = $storedCount;
@endphp
