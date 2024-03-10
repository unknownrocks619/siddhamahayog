<div class="card">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['syllabus_and_resources']['access']))
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
                                    {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['syllabus_and_resources']['label']}}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif

            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['program_daily_attendance']['access']))
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="ti ti-code ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <div class="mb-0 fw-medium">
                                <a href="{{route('admin.program.attendances.list',['program'=>$program])}}">
                                    {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['program_daily_attendance']['label']}}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['account_and_management']['access']))
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="ti ti-currency-dollar ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <div class="mb-0 fw-medium">
                                <a href="{{ route('admin.program.fee.admin_fee_overview_by_program', ['program' => $program]) }}">
                                    {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['account_and_management']['label']}}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['assign_member_to_program']['access']))
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-brand-dribbble ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <a href="#" class="mb-0 fw-medium ajax-modal" data-bs-target="#assignStudentToProgram" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'members.list','program' => $program->getKey()])}}">
                                {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['assign_member_to_program']['label']}}
                            </a>
                        </div>
                    </div>
                </li>
            @endif
            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['register_new_member_to_program']['access']))
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-warning"><i class="ti ti-user ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <div class="mb-0 fw-medium">
                                <a href="{{ route('admin.members.admin_add_member_to_program', ['program' => $program->id]) }}">
                                    {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['register_new_member_to_program']['label']}}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['scholarship_and_special_permission']['access']))
                <li class="d-flex align-items-center pb-1 mb-4">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-free-rights ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <a href="{{route('admin.program.scholarship.list', ['program' => $program->getKey()])}}" class="mb-0 fw-medium">
                                {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['scholarship_and_special_permission']['label']}}

                            </a>
                        </div>
                    </div>
                </li>
            @endif

            @if(in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['vip_and_guest_list']['access']))
                <li class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-vip ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <a href="{{ route('admin.program.guest.list', ['program' => $program]) }}" class="mb-0 fw-medium">
                                {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['vip_and_guest_list']['label']}}
                            </a>
                        </div>
                    </div>
                </li>
            @endif

            @if ($program->getKey() == 5 && in_array(adminUser()->role(), \App\Models\Program::QUICK_NAVIGATION_ACCESS['grouping']['access']))
                <li class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-vip ti-md"></i></span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <a href="{{ route('admin.program.admin_program_grouping_list', ['program' => $program]) }}" class="mb-0 fw-medium">
                                {{\App\Models\Program::QUICK_NAVIGATION_ACCESS['grouping']['label']}}
                            </a>
                        </div>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
