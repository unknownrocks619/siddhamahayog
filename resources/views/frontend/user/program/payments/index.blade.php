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
                <h5 class="card-header">Your Transaction history for <span class="fs-4 text-primary">`{{ $program->program_name }}`</span></h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">All Your transactions for {{$program->program_name}} will be available here.</p>
                        </div>

                    </div>
                    @if(! $paymentHistories && $program->program_type == "paid")
                    <?php

                    $url = url()->temporarySignedRoute('vedanta.payment.create', now()->addMinute(10), $program->id);
                    ?>
                    <button data-href="{{ $url }}" type="button" class="mt-2 mb-2 btn btn-outline-danger clickable">Clear Admission Payment</button>
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
                                    NRs. {{ number_format($transaction->amount,2,",",'.') }}
                                </td>
                                <td>
                                    @if($transaction->verified)
                                    <span class="badge bg-label-success">Verified</span>
                                    @else
                                    <span class="badge bg-label-danger">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Transaction not found.
                                </td>
                            </tr>
                            @endforelse
                            @else
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Transaction not found.
                                </td>
                            </tr>
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