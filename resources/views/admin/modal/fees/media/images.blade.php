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
                        <tr>
                            <th>Bank name</th>
                            <td>
                                {{$transaction->remarks->bank_name}}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Transaction Date
                            </th>
                            <td>
                                {{$transaction->remarks->upload_date}}
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-md-12">
                <img src="{{asset($transaction->file->path)}}" class="img-fluid" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
