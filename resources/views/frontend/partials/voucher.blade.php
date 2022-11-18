@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Program /</span>
        <span class="text-muted fw-light"><a href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a> /</span>
        Payment
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <form id="paymentConfirmation" enctype="multipart/form-data" action="{{ route('user.account.programs.payment.store.voucher',$program->id) }}" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-md-8">
                            <h5 class="card-header mt-0 pt-0">You are paying using <span class="fs-4 text-success">`Voucher Upload`</span></h5>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-danger clickable" data-href="{{ route('user.account.programs.program.index') }}">
                                <i class="bx bx-window-close">
                                </i>
                                Close Payment
                            </button>
                        </div>
                    </div>
                    <!-- Payment information detail -->
                    <div class="card-body">
                        <p class="text-info">
                            Please Note: You can make a payment for yourself only. Amount uploaded from this account is not transferable to other user or group.

                        </p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="text" name="amount" class="form-control" value="NRs {{ ( ! $program->student_admission_fee) ? $program->active_fees->admission_fee : $program->active_fees->monthly_fee }}" readonly id="amount" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type</label>
                                    <input type="text" name="payment_type" class="form-control" value="{{ ( ! $program->student_admission_fee) ? 'Admission Fee' : 'Monthly Fee' }}" readonly id="payment_type" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bank_name">Bank Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" value="Garima Bikas Bank" readonly name="bank_name" id="bank_name" class="form-control @error('bank_name') border border-danger @enderror" />
                                    @error('bank_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucherPhoto">Voucher Photo
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="file" required name="voucherPhoto" id="voucherPhoto" class="form-control @error('voucherPhoto') border border-danger @enderror" accept="image/*" />
                                    @error('voucherPhoto')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucherUploadDate">Voucher Deposited Date
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="date" name="voucher_date" required id="voucher_date" class="form-control @error('voucher_date') border border-danger @enderror" />
                                    @error('voucher_date')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                    Upload Bank Voucher
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <!-- /Payment information detail -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push("custom_script")
<script>
    $('form#paymentConfirmation').submit(function(event) {
        event.preventDefault();
        $(this).find('button').prop('disabled', true);
        return $(this)[0].submit();
    })
</script>
@endpush