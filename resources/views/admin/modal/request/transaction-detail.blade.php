@php
    $permission = \App\Models\PermissionUpdate::where('id',request()->permission)->first();
    $transaction = $permission->relation_table::with(['student_fee'])->find($permission->relation_id);

@endphp
<div class="modal-header">
    <h3 class="modal-title">
        Request Detail <span class="text-danger"></span>
    </h3>
    <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
    <div class="modal-body p-2">
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-response table-hover">
                    <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Voucher Number
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Tx Info
                            </th>
                            <th>
                                Amount
                            </th>
                            <th>
                                Tx Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{$transaction->student_fee->full_name}}
                            </td>
                            <td>
                                {{$transaction->voucher_number}}
                            </td>
                            <td>
                                @if ($transaction->verified)
                                <span class="badge bg-label-success"><a href="#" title="Verified"><i class="fas fa-check"></i></a></span>
                                @else
                                    <span class="badge bg-label-danger"><a href="#" title="Rejected"><i class="fas fa-cancel"></i></a></span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $displayText = "Media Not Available";
                                    $searchString = \Illuminate\Support\Str::contains($transaction->source_detail, 'e-sewa', true);
                                    if ($searchString) {
                                    $displayText .= "";
                                    //                            $string = "OID: " . $row->remarks->oid;
                                    //                            $string .= "<br />";
                                    $displayText .= "refId: " . $transaction->remarks->refId;

                                    }

                                    $searchString = \Illuminate\Support\Str::contains($transaction->source, 'stripe', true);

                                    if ($searchString) {
                                    $string = "Rate : " . $transaction->remarks->rate->exchange_data->buy . 'NRs';
                                    $string .= "<br />";
                                    $string .= "Currency: " . $transaction->remarks->paid_currency;
                                    $string .= "<br />";
                                    $string .= "Amount: " . $transaction->remarks->paid_amount;
                                        $displayText = $string;
                                    }

                                    echo $displayText
                                @endphp
                            </td>
                            <td>
                                {{default_currency(strip_tags($transaction->amount))}}
                            </td>
                            <td>
                                {{$transaction->created_at}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
        </div>
    </div>
