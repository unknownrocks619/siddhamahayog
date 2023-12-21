@php
    $fee_detail = \App\Models\ProgramStudentFeeDetail::with(['student'])->find($fee_detail);
@endphp

<div class="modal-header">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="modal-body p-2">
    <div class='row'>

        <div class='col-md-12'>
            <table class='table table-border table-hover'>

                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Voucher Date</th>
                        <th>Name</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>{{$fee_detail->remarks->bank_name}} </td>
                        <td>{{$fee_detail->remarks->upload_date}}</td>
                        <td>{{strtoupper($fee_detail->student->full_name)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class='col-md-12  mt-3 border'>
            <img src='{{asset($fee_detail->file->path)}}' class='img-fluid' />
        </div>

    </div>
</div>
