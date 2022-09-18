<ul class="p-0 ms-2 me-2">
    @forelse ($donations as $donation)
    <li class="d-flex mb-4 pb-1">
        <div class="avatar flex-shrink-0 me-3">
            <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded">
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
                <small class="text-muted d-block mb-1">@if(\Str::contains($donation->type,'esewa',false)) Esewa @else Wallet @endif</small>
                <h6 class="mb-0">Esewa</h6>
            </div>
            <div class="user-progress d-flex align-items-center gap-1">
                <h6 class="mb-0">{{ $donation->amount }}</h6>
                <span class="text-muted">NRs</span>
            </div>
        </div>
    </li>
    @empty

    <li class="d-flex mb-4 pb-1">
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-center gap-2">
            <div class="me-2">
                <h6 class="mb-0 text-danger text-center"> Guru Sewa not found.
                </h6>
            </div>
        </div>
    </li>
    @endforelse

</ul>