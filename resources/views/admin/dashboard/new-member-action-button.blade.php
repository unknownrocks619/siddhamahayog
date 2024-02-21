@if(in_array(adminUser()->role(),[
                        App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,
                        App\Classes\Helpers\Roles\Rule::ADMIN,
                        App\Classes\Helpers\Roles\Rule::CENTER,
                        App\Classes\Helpers\Roles\Rule::CENTER_ADMIN,
                    ]))
    <div class="col-md-12 my-3">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.members.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add New Member
                </a>

            </div>
        </div>
    </div>
@endif
