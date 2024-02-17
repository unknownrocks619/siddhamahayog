<a href='{{route('admin.program.admin_program_detail', [$program->getKey()])}}'
    class='btn btn-primary btn-sm'>
    <i class='fas fa-eye me-1'></i>
</a>

@if(in_array(adminUser()->role(), App\Models\Program::EDIT_PROGRAM_ACCESS) )

    <a href='{{route('admin.program.admin_program_edit', [$program->getKey()])}}'
        class='btn btn-info btn-sm mx-1'>
        <i class='fas fa-pencil'></i>
    </a>

    <a href="{{route('admin.program.admin_program_edit', ['program' => $program->getKey()]) }}"
        class='btn btn-danger btn-sm'>
        <i class='fas fa-trash'></i>
    </a>
@endif