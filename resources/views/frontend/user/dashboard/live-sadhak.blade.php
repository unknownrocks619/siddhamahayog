<li class=" mb-4 pb-1 border-bottom">
    <div class="d-flex">
        <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-mobile-alt"></i></span>
        </div>
        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
            <div class="me-2">
                <h6 class="mb-0">
                    Vedanta Darshan: Arthapanchak (Tattva Gyan) Course - First Batch
                </h6>
                <?php
                $previousVedantaCheck = \DB::connection('sadhak')->table('zoom_settings')
                    ->find('5');
                ?>

                @if($previousVedantaCheck->is_active)
                <small class="text-muted">Started at {{ date('H:i A', strtotime($previousVedantaCheck->updated_at)) }}</small>
                @endif


            </div>
            <div class="user-progress">
                <?php
                $roles = App\Models\Role::$roles
                ?>
                @if(array_key_exists(user()->role_id,$roles) && $roles[user()->role_id] == 'Admin')
                <form class="d-inline" action="{{route('frontend.sadhak.join_as_admin')}}" method="post">
                    @csrf
                    <button onclick="this.innerText='Please wait...';" type="submit" class="fw-semibold btn btn-sm btn-success">
                        Join as Host
                    </button>
                </form>
                <form class="d-inline" action="{{ route('frontend.sadhak.join_as_sadhak') }}" method="post">
                    @csrf
                    <button onclick="this.innerText='Please wait...';" type="submit" class="fw-semibold btn btn-sm btn-success">
                        Join as Sadhak
                    </button>
                </form>
                @elseif($previousVedantaCheck->is_active)
                <form class="d-inline" action="{{ route('frontend.sadhak.join_as_sadhak') }}" method="post">
                    @csrf
                    <button onclick="this.innerText='Please wait...';" type="submit" class="fw-semibold btn btn-sm btn-success">
                        Join Session
                    </button>
                </form>
                @else
                <div class="user-progress">
                    <small class="fw-semibold btn btn-sm btn-secondary">
                        Not Available
                    </small>
                </div>

                @endif
            </div>
        </div>
    </div>
</li>