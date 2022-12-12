@extends("frontend.theme.portal")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            Member / Detail /
        </span>
        {{ $member->full_name }}
    </h4>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <button type="button" data-href="{{ route('center.admin.dashboard') }}" class="btn btn-outline-primary clickable">
                        <x-arrow-left>
                            Go back
                        </x-arrow-left>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 y-3">
            <x-alert></x-alert>
        </div>
        <div class="col-md-5">
            @include("centers.admin.members.show.program_enrolled",compact('member'))
        </div>
        <div class="col-md-6">
            @include('centers.admin.members.show.payment-list',compact('member'))
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            @include('centers.admin.members.show.reference')
        </div>
    </div>
</div>
@endsection