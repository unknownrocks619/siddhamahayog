@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span>
        Guru Dakshina
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <div class="card mb-4">
                <h5 class="card-header">Your guru dakshinas </h5>
                @if(site_settings('donation') || user()->role_id == 1)
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex py-2 align-items-start bg-light align-items-sm-center gap-4 justify-content-between">
                        <div class="button-wrapper mx-2">
                            <form method="post" action="{{ route('donations.donate',['esewa']) }}" class="mt-3">
                                @csrf
                                <div class="input-group">
                                    <span class="input-group-text">NRs</span>
                                    <input name="amount" type="text" require class="form-control" placeholder="Amount" aria-label="Amount (to the nearest dollar)">
                                    <span class="input-group-text">.00</span>
                                    <button type="submit" class=" ms-4 btn btn-success ">E-sewa Dakshina</button>
                                    <a href="{{-- route('donations.donate_get',['stripe']) --}}" class="btn btn-primary ms-2 disabled">Other Payment (Coming soon)</a>

                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-border table-hover" id="donationTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Donation Amount</th>
                                <th>Payment Source</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( $donations )
                            @forelse ($donations as $donation)
                            <tr>
                                <td>{{ date("Y-m-d",strtotime($donation->created_at)) }}</td>
                                <td>
                                    @if(\Str::contains($donation->type, 'esewa', true))
                                    NRs . {{ number_format($donation->amount,2) }}
                                    @elseif(\Str::contains($donation->type,'stripe',true) )
                                    USD . {{ number_format($donation->amount,2) }}
                                    @else
                                    {{ number_format($donation->amount,2) }}
                                    @endif
                                </td>
                                <td> {{ $donation->type }} </td>
                                <td>
                                    @if($donation->verified)
                                    <span class="badge bg-label-success">Verified</span>
                                    @else
                                    <span class="badge bg-label-warning">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Guru Dakshina Not Found.
                                </td>
                            </tr>
                            @endforelse
                            @else
                            <tr>
                                <td colspan="5" class="text-center text-muted fs-4">
                                    Guru Dakshina Not Found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <hr class="my-0" />
                @endif
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@push("custom_script")
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    @if( $donations && $donations->count())
    $(document).ready(function() {
        $("#donationTable").DataTable();
    })
    @endif
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

@push('custom_css')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
