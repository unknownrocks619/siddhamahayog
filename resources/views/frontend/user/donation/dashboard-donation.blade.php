<ul class="p-0 ms-2 me-2">
    @forelse ($donations as $donation)
    <li class="d-flex mb-4 pb-1">
        <div class="avatar flex-shrink-0 me-3">
            <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}" alt="User" class="rounded">
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
                <small class="text-muted d-block mb-1">
                    <?php
                    if (\Str::contains($donation->type, 'esewa', true)) {
                        $type = 'Esewa';
                    } elseif (\Str::contains($donation->type, 'stripe', true)) {
                        $type = "Stripe";
                    } else {
                        $type = "Wallet";
                    }
                    ?>
                    {{-- $type --}}
                </small>
                <h6 class="mb-0">{{ $type }}</h6>
            </div>
            <div class="user-progress d-flex align-items-center gap-1">
                <h6 class="mb-0">{{ number_format($donation->amount,2) }}</h6>
                <span class="text-muted">
                    @if($type == "Stripe")
                    USD
                    @else
                    NRs.
                    @endif
                </span>
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