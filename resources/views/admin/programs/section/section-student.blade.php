<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                S.No
            </th>
            <th>
                Full Name
            </th>
            <th>
                Section
            </th>
            <th>
                Address
            </th>
            <th>
                Phone Number
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($all_students as $student)
        <tr>
            <td>
                {{ $loop->iteration }}
            </td>
            <td>
                <a href="{{ route('admin.members.admin_show_for_program',[$student->student->id,$program->id]) }}">{{ $student->student->full_name }}</a>
            </td>
            <td>
                {{ $student->section->section_name }}
            </td>
            <td>
                {{ ($student->student->address) ? $student->student->address->street_address : "Not Available"  }}
            </td>
            <td>
                {{ $student->student->phone_number }}
            </td>
            <td>
                <a href="{{ route('admin.program.sections.admin_change_student_section',[$student->program_id,$student->student->id,$student->section->getKey()]) }}" data-target="#edit_create_section" data-toggle="modal">Change Section</a>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">
                {{ $section->section_name }} doesn't have any student.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
