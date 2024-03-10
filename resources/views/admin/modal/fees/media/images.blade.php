@php
    $transaction = \App\Models\ProgramStudentFeeDetail::where('id',request()->transactionID)->first();
    $transactionOverview = \App\Models\ProgramStudentFee::where('id',$transaction->program_student_fees_id)->first();
    $member = \App\Models\Member::where('id',request()->memberID)->first();
@endphp
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">`{{$member->full_name}}` Transaction File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        @if($transaction->remarks && isset($transaction->remarks->bank_name))
                        <tr>
                            <th>Bank name</th>
                            <td>
                                {{$transaction->remarks->bank_name}}
                            </td>
                        </tr>
                        @endif
                        @if($transaction->fee_added_by_center)
                        <tr>
                            <th>Center Name</th>
                            <td>
                                {{$transaction->center->center_name}}
                            </td>
                        </tr>
                        <tr>
                            <th>Uploaded By</th>
                            <td>
                                {{$transaction->staff->full_name()}}
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>
                                Transaction Date
                            </th>
                            <td>
                                {{$transaction->remarks?->upload_date ?? $transaction->created_at}}
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                @if($transaction->file)
                <img src="{{asset($transaction->file->path)}}" class="img-fluid" />
                @else
                    @if($transaction->voucherImage)
                        <img src="{{ App\Classes\Helpers\Image::getImageAsSize($transaction->voucherImage->filepath,'m')}}" class="img-fluid" />
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
