
<form method="post" class="ajax-component-form" action="{{ route('admin.program.fee.admin_store_student_fee',['member' => request()->member]) }}">

    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2">
        <!-- Select User -->
        <div class="mb-4 pb-2">
            <label for="select2Basic" class="form-label fs-4">Select Program make Payment</label>
            <div class="position-relative">
                <div class="position-relative">
                    <div class="position-relative">
                        <select name="program_name" id="select2Basic" class="form-select form-select-lg share-project-select " data-allow-clear="true">
                            @foreach(\App\Models\Program::with(['students'])->where('status','active')->get() as $program)
                                @if(request()->member && ! $program->students()->where('student_id', request()->member)->exists())
                                    @php continue; @endphp
                                @endif
                                <option value="{{$program->getKey()}}">{{$program->program_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment_type">Payment Type</label>
                    <select name="payment_type" id="payment_type" class="form-control">
                        <option value="admission_fee">Admission Fee</option>
                        <option value="monthly_fee">Monthly Fee</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment_type">Payment Mode</label>
                    <select name="payment_mode" onchange="window.selectElementChange(this,'payment_type')" id="payment_mode" class="form-control">
                        <option value="voucher">Voucher Upload</option>
                        <option value="esewa" selected>E-sewa Transaction</option>
                        <option value="banking">Banking Transaction</option>
                        <option value="khalti">Khalti Transaction</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="verified">Verified</label>
                    <select name="verified" id="verified" class="form-control">
                        <option value="0">No</option>
                        <option value="1" selected>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row payment_type esewa mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="esewa_reference_number">
                        Esewa Reference Number
                    </label>
                    <input type="text" name="esewa-reference-number" id="esewa_reference_number" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="esewa-transaction-id">Esewa Transaction ID</label>
                    <input type="text" name="esewa-transaction-id" id="esewa-transaction-id" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label for="esewa-transaction-date">Esewa Transaction Dqte</label>
                    <input type="date" name="esewa-transaction-date" id="esewa-transaction-date" class="form-control">
                </div>
            </div>
        </div>
        <div class="row payment_type khalti mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="khalti_reference_number">
                        Khalti Reference Number
                    </label>
                    <input type="text" name="khalti-reference-number" id="khalti_reference_number" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="khalti-transaction-id">Khalti Transaction ID</label>
                    <input type="text" name="khalti-transaction-id" id="khalti-transaction-id" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="form-group">
                    <label for="kahlti-transaction-date">Khalti Transaction Dqte</label>
                    <input type="date" name="khalti-transaction-date" id="khalti-transaction-date" class="form-control">
                </div>
            </div>
        </div>
        <div class="row payment_type voucher mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="upload-voucher">
                        Please Upload Voucher
                    </label>
                    <input type="file" name="file" id="file" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bank_name">Bank name</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-group">
                    <label for="voucher_date">Voucher Deposited Date</label>
                    <input type="date" name="voucher_date" id="voucher_date" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button class="submit btn btn-primary">
                    Make Payment
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    window.selectElementChange($('#payment_mode'),'payment_type');
</script>
