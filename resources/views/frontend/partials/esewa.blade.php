@extends('frontend.theme.portal')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Program /</span>
            <span class="text-muted fw-light">
                <a href="{{ route('user.account.programs.program.index') }}">
                    {{ $program->program_name }}
                </a> /
            </span>
            Payment
        </h4>
        <?php
        $studentFee = user()
            ->transactions()
            ->where('program_id', $program->id)
            ->where('amount_category', 'admission_fee')
            ->sum('amount');
        
        $toBePaid = $program->active_fees->admission_fee;
        
        if (!\App\Models\ProgramStudent::where('program_id', $program->getKey())->where('student_id', user()->getKey())->where('active', true)->exists()) {
            $allow_access = false;
        }
        if ($studentFee < $toBePaid) {
            $toBePaid = !$studentFee ? 9000 : $toBePaid - $studentFee;
        } else {
            $toBePaid = 0;
        }
        ?>
        @if (!$allow_access || !$toBePaid)
            @include('frontend.partials.not-allowed', ['program' => $program])
        @else
            <div class="row">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <form id="paymentConfirmation" action="{{ route('vedanta.payment.store', $program->id) }}" method="post">
                        @csrf
                        <div class="card mb-4">
                            <!-- Payment information detail -->
                            <div class="card-body">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-8">
                                        <h5 class="card-header mt-0 pt-0">You are paying using <span
                                                class="fs-4 text-success">`E-Sewa`</span></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-sm btn-danger clickable"
                                            data-href="{{ route('user.account.programs.program.index') }}">
                                            <i class="bx bx-window-close">
                                            </i>
                                            Close Payment
                                        </button>
                                    </div>
                                </div>
                                <p class="text-info">
                                    Please Note: You can only make a payment for yourself only.
                                </p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="amount">Amount</label>

                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">NRs</span>
                                            </div>
                                            <input type="number" id="amount" name="amount" class="form-control"
                                                placeholder="Amount" aria-label="Amount" value="{{ $toBePaid ?? 1500 }}"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-8 mt-2">
                                        <div class="form-group">
                                            <label for="remarks">Remark</label>
                                            <input type="text" name="remakrs" class="form-control"
                                                value="{{ !$program->student_admission_fee ? 'Admission Fee' : 'Monthly Fee' }}"
                                                readonly id="amount" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success">
                                            Confirm Payment
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
        @endif
    </div>
@endsection

@push('custom_script')
    <script>
        $('form#paymentConfirmation').submit(function(event) {
            event.preventDefault();
            $(this).find('button').prop('disabled', true);
            return $(this)[0].submit();
        })
    </script>
@endpush
