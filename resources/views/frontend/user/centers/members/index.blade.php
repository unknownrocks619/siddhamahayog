@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Centers /</span>
        Sadhaks
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <div class="card mb-4">
                <h5 class="card-header">All Sadhak for your authorized Centers </h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4 justify-content-between">
                        <div class="button-wrapper mx-2">
                            <button type="submit" data-bs-toggle="modal" data-bs-target="#paymentSelection" class="btn btn-primary">
                                <x-plus></x-plus>Add New Sadhak
                                <span class="text-white">(You can only add sadhak to your centers.)</span>
                            </button>
                        </div>
                        <div>
                            <button class="btn btn-danger btn-sm clickable" data-href="{{ route('user.account.programs.program.index') }}">
                                <i class="bx bx-window-close">
                                </i>
                                Close
                            </button>
                        </div>
                    </div>
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Address</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Program Enrolled</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
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
        @include('frontend.user.centers.partials.payment-selection')
    </div>
</x-modal>
@endif
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