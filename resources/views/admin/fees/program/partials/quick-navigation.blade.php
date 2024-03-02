@php /** @var \App\Models\Program $program */@endphp

<div class="card">
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            @if( in_array(adminUser()->role(),[App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,App\Classes\Helpers\Roles\Rule::SUPER_ADMIN]))
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-topology-full ti-md"></i>
                        </span>
                    </div>
                    <div class="row w-100 align-items-center">
                        <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                            <div class="mb-0 fw-medium">
                                <a href="{{ route('admin.program.fee.admin_fee_overview_by_program', ['program' => $program])  }}">
                                    Overview
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="ti ti-report-money ti-md"></i>
                    </span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{ route('admin.program.fee.admin_fee_transaction_by_program',['program' => $program]) }}">
                                Transactions
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info"><i class="ti ti-code ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{route('admin.program.fee.admin_display_unpaid_list',['program' => $program])}}">
                                Unpaid List
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @endif
            <li class="d-flex mb-4 pb-1 align-items-center">
                <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-info"><i class="ti ti-plus ti-md"></i></span>
                </div>
                <div class="row w-100 align-items-center">
                    <div class="col-sm-8 col-lg-12 col-xxl-8 mb-1 mb-sm-0 mb-lg-1 mb-xxl-0">
                        <div class="mb-0 fw-medium">
                            <a href="{{route('admin.members.create')}}">
                                Add Transaction
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
