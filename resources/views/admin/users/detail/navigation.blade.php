<div class='card-body'>
        @if(Route::currentRouteName() != 'users.view-user-detail')
            <div class="row mb-2">
                <div class='col-12'>
                    <a href="{{ route('users.view-user-detail',$user_detail->id) }}" class='text-danger'>
                        Go Back
                    </a>
                </div>

            </div>
    @endif
    <div class="row">

        <a href="{{ route('users.view-user-detail',$user_detail->id) }}" class='btn mx-1 @if(Route::currentRouteName() == "users.view-user-detail") btn-disabled text-success @else btn-primary @endif '>
            Profile Detail
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'verification']) }}" class="btn  mx-1 @if(Request::is('admin/user-detail/*/verification')) text-success btn-disabled @else btn-primary @endif">
            
            Verification
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'nights']) }}" class="btn mx-1 @if(Request::is('admin/user-detail/*/nights')) text-success btn-disabled @else btn-primary @endif ">
            Visit History
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'donations']) }}" class="btn mx-1  @if(Request::is('admin/user-detail/*/donations')) text-success btn-disabled @else btn-primary @endif ">
            Donation History
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'medias']) }}" class="btn mx-1   @if(Request::is('admin/user-detail/*/medias')) text-success btn-disabled @else btn-primary @endif ">
            Media
        </a>

        <a href="{{ route('users.view-service-detail',[$user_detail->id,'sewas']) }}" class="btn mx-1   @if(Request::is('admin/user-detail/*/sewas')) text-success btn-disabled @else btn-primary @endif ">
            Sewas
        </a>

    </div>
</div>