@php
$route = route('admin.members.create') . "?";
$dharmasala = request()->dharmasala ? true  : false;

if ($dharmasala) {
    $route .= "dharmasala=true";
}
@endphp
<div class="row mt-2">
@foreach ($members as $member)
    <div class="col-md-6 my-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @if($member->profileImage)
                        <div class="col-md-2">
                            <img class="border img-thumbnail" src="{{\App\Classes\Helpers\Image::getImageAsSize($member->profileImage->filepath)}}" />
                        </div>
                    @endif
                    <div class="col-md-6">
                        <h4 class="title">{{$member->full_name}}</h4>
                        <span><b>Email: </b> {{$member->email}}</span>
                        <br />
                        <span><b>Phone Number: </b> {{$member->phone_number}}</span>
                    </div>
                    <div class="col text-end">
                        <a href="{{$route}}&member={{$member->getKey()}}" class="btn btn-primary">Select User</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
