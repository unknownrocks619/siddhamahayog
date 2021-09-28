<div class='card-body'>
        @if(Route::currentRouteName() != 'users.view-user-detail')
            <div class="row mb-2">
                <div class='col-12'>
                    <a href="{{ route('users.sadhak.sadhak-enquries') }}" class='text-danger'>
                        Go Back
                    </a>
                </div>

            </div>
    @endif
    <div class="row">

        <a href="{{ route('users.view-user-detail',$user_detail->id) }}" class='btn mx-1 @if(Route::currentRouteName() == "users.view-user-detail") btn-disabled text-success @else btn-primary @endif '>
            Helath Detail
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'verification']) }}" class="btn  mx-1 @if(Request::is('admin/user-detail/*/verification')) text-success btn-disabled @else btn-primary @endif">
            Review
        </a>

        <a class='btn btn-primary' href="">
            Visit History
        </a>

    </div>
</div>