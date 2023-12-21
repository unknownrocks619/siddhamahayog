<!-- User Sidebar -->
<div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="user-avatar-section">
                <div class=" d-flex align-items-center flex-column">
                    @if($member->profileUrl)
                        <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $member->profileUrl->avatar }}" height="100" width="100" alt="User avatar" />
                    @endif
                    <div class="user-info text-center">
                        <h4 class="mb-2">{{$member->full_name}}</h4>
                        <span class="badge bg-label-secondary mt-1">
                            {{\App\Models\Role::$roles[$member->role_id]}}
                        </span>
                    </div>
                </div>
            </div>
            <p class="mt-4 small text-uppercase text-muted">Details</p>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-2 pt-1">
                        <span class="fw-medium me-1">First Name:</span>
                        <span>{{$member->first_name}}</span>
                    </li>
                    <li class="mb-2 pt-1">
                        <span class="fw-medium me-1">Last Name:</span>
                        <span>{{$member->last_name}}</span>
                    </li>
                    <li class="mb-2 pt-1">
                        <span class="fw-medium me-1">Email:</span>
                        <span>{{$member->email}}</span>
                    </li>
                    <li class="mb-2 pt-1">
                        <span class="fw-medium me-1">Country:</span>
                        <span class="badge bg-label-success">{{$member->countries?->name ?? 'N/A'}}</span>
                    </li>
                    <li class="mb-2 pt-1">
                        <span class="fw-medium me-1">Phone Number:</span>
                        <span>{{$member->phone_numnber ?? 'N/A'}}</span>
                    </li>
                </ul>
                <div class="d-flex justify-content-center">
                    <a href="#" class="me-3 data-confirm btn btn-label-danger suspend-user"  data-confirm="You will be Logged In As `{{$member->full_name}}`" data-method="post" data-action="{{route('admin.members.admin_login_as_user',$member->getKey())}}">View As</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /User Card -->
    <!-- Plan Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <span class="badge bg-label-primary">Password manager</span>
            </div>
            <form class="ajax-form" action="{{ route('admin.members.admin_change_user_password',$member->id) }}" onsubmit="return confirm('You are about to change the password for current user. Are you sure? this action cannot be undone')" method="put">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>
                                New Password
                                <sup class="text-danger">*</sup>
                            </strong>
                            <input required type="password" name="password" id="user_new_passowrd" class="form-control" />
                            @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>
                                Confirm Password
                                <sup class="text-danger">*</sup>
                            </strong>
                            <input type="password" name="password_confirmation" id="confirm_new_password" class="form-control" />
                            @error('password_confirmation')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid w-100 mt-4">
                    <button class="btn btn-primary" >Update Password</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Plan Card -->
</div>
<!--/ User Sidebar -->
