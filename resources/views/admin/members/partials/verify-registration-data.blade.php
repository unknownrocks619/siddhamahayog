
<div class="card">
    <div class="card-body">
        @php /**  @todo Remove Registration Code After Hanumand Yagya  **/ @endphp

        <div class="row my-5">
            <div class="col-md-12 fs-2 alert alert-success text-center">
                New Account was successfully created.
            </div>
        </div>
        <div class="row d-none">
            <div class="col-md-12">
                <input type="hidden" name="memberID" value="{{$member->getKey()}}" class="form-control d-none" />
                <input type="hidden" name="existing_member" value="1" class="form-control d-none" />
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2">
                <a href="{{route('admin.members.verification.send-verification-email',['member' => $member,'source'=>'registration'])}}"  class="btn btn-primary">
                    Send Verification Email
                </a>
            </div>
            @if(\App\Classes\Helpers\UserHelper::isCountry($member,'NP') && $member->phone_number)
                <div class="col-md-2">
                    <button class="btn btn-primary">
                        Verify Phone
                    </button>
                </div>
            @endif
        </div>
        <!-- / Payment Option -->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-end justify-content-between">
                <a href="{{route('admin.members.all')}}" class="btn btn-danger btn-icon">
                    <i class="fas fa-arrow-left"></i></a>

                <a href="{{route('admin.members.create')}}" class="btn btn-primary">
                    Create new Registration
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.step_one_search_option').hide();
</script>
