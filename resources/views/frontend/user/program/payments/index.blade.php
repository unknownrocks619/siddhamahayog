@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Program /</span>
        <span class="text-muted fw-light"><a href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a> /</span>
        Resources
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <div class="card mb-4">
                <h5 class="card-header">Your Payment history for <span class="fs-4 text-primary">`{{ $program->program_name }}`</span></h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 justify-content-between">
                        <div class="button-wrapper mx-2">
                            <?php
                            $checkVoidScholarship =  \App\Models\Scholarship::where('program_id', $program->getKey())->where('student_id', auth()->id())
                                ->where('scholar_type', 'void')
                                ->first();

                            //$url = url()->temporarySignedRoute('vedanta.payment.create', now()->addMinute(10), $program->id);
                            ?>
                            <?php

                            $displayPaymentOption = true;
                            $studentFee = user()->studentFeeOverview()->where('program_id', $program->id)->first();

                            if ($studentFee) {
                                $displayPaymentOption = false;
                            }

                            if ($checkVoidScholarship) {
                                $displayPaymentOption = false;
                            }
                            ?>
                            @if($displayPaymentOption && (site_settings('online_payment') || user()->role_id == 1))
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#paymentSelection" class="btn btn-primary">
                                <x-plus></x-plus>Choose Payment Options
                            </button>
                            @endif
                        </div>
                        <div>
                            <button class="btn btn-danger btn-sm clickable" data-href="{{ route('user.account.programs.program.index') }}">
                                <i class="bx bx-window-close">
                                </i>
                                Close
                            </button>
                        </div>
                    </div>

                    @if(! $paymentHistories && $program->program_type == "paid")

                    <!-- <button data-href="{{-- $url --}}" type="button" class="mt-2 mb-2 btn btn-outline-danger clickable">Clear Admission Payment</button> -->
                    @endif
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Program</th>
                                <th>Remark</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $paymentHistories )
                            @forelse ($paymentHistories->transactions as $transaction)
                            <tr>
                                <td>{{ date("Y-m-d",strtotime($transaction->created_at)) }}</td>
                                <td>
                                    {{ $transaction->program->program_name }}
                                </td>
                                <td> {{ __("payment.".$transaction->amount_category) }} </td>
                                <td>
                                    NRs. {{ number_format($transaction->amount,2,",") }}
                                </td>
                                <td>
                                    @if($transaction->verified)
                                    <span class="badge bg-label-success">Verified</span>
                                    @elseif ($transaction->rejected)
                                    <span class="badge bg-label-danger">Rejected</span>
                                    @else
                                    <span class="badge bg-label-info">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            @if($checkVoidScholarship)
                            <tr>
                                <td>{{ date("Y-m-d",strtotime($checkVoidScholarship->created_at)) }}</td>
                                <td>
                                    {{ $program->program_name }}
                                </td>
                                <td> {{ __("payment.admission_fee") }} </td>
                                <td>
                                    NRs. {{ number_format(9000,2,",") }}
                                </td>
                                <td>
                                    <span class="badge bg-label-success">Verified</span>
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Transaction not found.
                                </td>
                            </tr>
                            @endif
                            @endforelse
                            @else

                            @if (! $checkVoidScholarship)
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Transaction not found.
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td>{{ date("Y-m-d",strtotime($checkVoidScholarship->created_at)) }}</td>
                                <td>
                                    {{ $program->program_name }}
                                </td>
                                <td> {{ __("payment.admission_fee") }} </td>
                                <td>
                                    NRs. {{ number_format(9000,2,",") }}
                                </td>
                                <td>
                                    <span class="badge bg-label-success">Verified</span>
                                </td>
                            </tr>
                            @endif
                            @endif
                        </tbody>
                    </table>
                </div>
                <hr class="my-0" />
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@if(site_settings('online_payment') || user()->role_id == 1)
<x-modal modal="paymentSelection">
    <div class="modal-header">
        <h5 class="modal-title" id="modalFullTitle">Select Payment Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'esewa']) }}" class="btn btn-success clickable py-2 px-2 ">
                    Esewa Payment
                </a>
                <a href="{{ route('user.account.programs.payment.create.form',[$program->id,'paymentOpt'=>'voucher']) }}" class="btn btn-primary clickable py-2 px-2">
                    Voucher Payment
                </a>
            </div>
        </div>
        {{-- @include('frontend.partials.payment-selection') --}}
    </div>
</x-modal>
@endif
<div class="modal fade" id="resourceImage" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content" id="resourceContent">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFullTitle">{{ $program->program_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            Please wait while loading your content...
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@push("custom_script")
<script type="text/javascript">
    $("#resourceImage").on("shown.bs.modal", function(event) {
        $.ajax({
            method: "get",
            url: event.relatedTarget.dataset.href,
            success: function(response) {
                $("#resourceContent").html(response);
            }
        })
    });
</script>
@endpush