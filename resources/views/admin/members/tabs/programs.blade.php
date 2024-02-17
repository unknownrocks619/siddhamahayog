<!-- Project table -->
<div class="card mb-4">
    <h5 class="card-header">User's Projects List</h5>

    <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-info ajax-modal" data-bs-toggle="modal" data-bs-target="#enrollToProgram" data-action="{{route('admin.modal.display',['view' => 'programs.program-select','member'=>$member->getKey()])}}" data-method="post">Add Program</button>
                </div>
            </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table datatable-project border-top">
            <thead>
                <tr>
                    <th></th>
                    <th>Program Name</th>
                    <th class="text-nowrap">Joined Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($member->member_detail as $member_program)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $member_program->program->program_name }}
                        </td>
                        <td>
                            {{ $member_program->created_at }}
                        </td>
                        <td>
                            @if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
                                <button type="button" data-method="delete" data-action="{{ route('admin.program.enroll.admin_remove_student_from_program',$member_program->id) }}" data-confirm="Are you sure you want remove this user from program. If there are any active transaction for his user in the program you must first remove transaction" class="btn btn-sm btn-danger btn-small data-confirm">Remove</button>
                            @else
                                <button type="button" disabled data-confirm="You do not have permission to perform this action." class="btn btn-sm btn-danger btn-small data-confirm">Remove</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Member not enrolled in any program.</td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
<!-- /Project table -->
<x-modal modal="enrollToProgram">

</x-modal>
