@php
    $memberLink = \App\Models\MemberUnderLink::where('teacher_id', user()?->getKey())
        ->where('student_id', request()->student)
        ->first();
    $member = \App\Models\Member::where('id', request()->student)->first();
@endphp
@if (!$memberLink)
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Member Not Found</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    Member not found.
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Account:
            {{ $member->full_name ? $member->full_name : $member->full_name() }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="{{ $member->email ? $member->email : '' }}" name="email"
                        id="email" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save Email</button>
                <button type="button" class="btn btn-label-secondary text-danger"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
@endif
