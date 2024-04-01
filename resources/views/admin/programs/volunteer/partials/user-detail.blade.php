<div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
    <!-- User Pills -->
    <ul class="nav nav-pills flex-column flex-md-row mb-4">
        <li class="nav-item">
            <a class="nav-link active "><i class="ti ti-user-check ti-xs me-1"></i>Signed Up Dates</a>
        </li>
    </ul>

<!-- Project table -->
<form class="ajax-form" action="{{route('admin.program.volunteer.admin_volunteer_update_status',['program' => $program,'volunteer' => $volunteer ]) }}" method="post">
    <div class="card mb-4">
        <div class="card-body">

            <div class="row">
                @foreach ($volunteer->availableDates ?? [] as $availableDates)
                <div class="col-md-3 my-3">
                    <div class="form-check">
                        <div class="">
                            <input class="form-check-input" @if($availableDates->status == 'approved') checked @endif type="checkbox" value="{{$availableDates->getKey()}}" name="dates[]" id="{{str($availableDates->available_dates)->slug('-')->value()}}">
                            <label class="form-check-label" for="{{str($availableDates->available_dates)->slug('-')->value()}}">
                              {{$availableDates->available_dates}}
                            </label>
                        </div>

                        @if($availableDates->status != 'rejected')
                            <a href='{{route('admin.program.volunteer.admin_volunteer_update_status',['program' => $program, 'volunteer' => $volunteer,'availableDates' => $availableDates,'type' => 'rejected'])}}'
                                data-confirm='Reject {{$availableDates->available_dates}} for this user. '
                                data-method='post'
                                data-action="{{route('admin.program.volunteer.admin_volunteer_update_status',['program' => $program, 'volunteer' => $volunteer,'availableDates' => $availableDates,'type' => 'rejected'])}}"
                                class="text-danger data-confirm">Reject</a>
                        @endif

                        @if($availableDates->status != 'approved')
                        | 
                         <a href='' class="text-success ajax-modal" data-bs-target="#acceptUser" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.volunteer.accept','volunteer' => $volunteer->getKey(),'availableDate' => $availableDates->getKey(),'program' => $program->getKey()])}}">Accept</a>
                         @endif
                      </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row" id="remarks">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item my-2">
                      <h2 class="accordion-header">
                        <button class="accordion-button collapsed  bg-success text-white" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                          Bulk Accept All
                        </button>
                      </h2>
                      <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                        <input type="hidden" name="type" value="approved" />
                        <div class="row mt-3 p-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks / Instructions</label>
                                    <textarea name="remarks" maxlength="160" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-12 mt-3 text-end">
                                <button class="btn btn-primary">Accept All Dates</button>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button bg-danger text-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Bulk Reject All
                          </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="row mt-3">
                                <div class="col-md-12 alert alert-danger">
                                    You are about to reject this user as volunteer. Do you wish to continue.
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-danger">Reject All</button>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /Project table -->

    
</div>
