<div class="card">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="ti ti-video ti-md"></i>
                    </span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{ route('admin.program.courses.admin_program_course_list', [$program->id]) }}">
                                Syllabus / Resources
                            </a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info"><i class="ti ti-code ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="">
                                Program Daily Attendance
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-success"><i class="ti ti-currency-dollar ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{ route('admin.program.fee.admin_fee_overview_by_program', ['program' => $program]) }}">
                                Accounts & Management
                            </a>
                        </div>
                    </div>
                </div>

            </li>
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-brand-dribbble ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <a href="#" class="mb-0 fw-medium ajax-modal" data-bs-target="#assignStudentToProgram" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'members.list','program' => $program->getKey()])}}">Assign Member to Program</a>
                    </div>
                </div>
            </li>
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-user ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{ route('admin.members.admin_add_member_to_program', ['program' => $program->id]) }}">Register New Member to Program</a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="d-flex align-items-center pb-1 mb-4">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-free-rights ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <a href="{{route('admin.program.scholarship.list', ['program' => $program->getKey()])}}" class="mb-0 fw-medium">Scholarship or Special Permission</a>
                    </div>
                </div>
            </li>
            <li class="d-flex align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-vip ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <a href="{{ route('admin.program.guest.list', ['program' => $program]) }}" class="mb-0 fw-medium">VIP / Guest Access List</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
