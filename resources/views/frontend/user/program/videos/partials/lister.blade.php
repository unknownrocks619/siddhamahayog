<li class="list-group-item border-bottom-1 border-start-0 border-end-0 border-top-0 rounded-0">
    @if ($courses->lock )
        <button class="btn btn-link ps-0 text-muted " type="button">
            <i class='bx bxs-movie-play me-2'></i>
                {{ $lession->lession_name }}
                <span class="text-right me-2">
                    <i class='bx bxs-lock-alt text-danger'></i>
                </span>
        </button>

    @elseif ( $lession->video_lock && ! $lession->lock_after)
        <button class="btn btn-link ps-0 text-muted " type="button">
            <i class='bx bxs-movie-play me-2'></i>
                {{ $lession->lession_name }}
                <span class="text-right me-2">
                    <i class='bx bxs-lock-alt text-danger'></i>
                </span>
        </button>

    @elseif($lession->lock_after)
        <?php
            $uploadedDate = \Carbon\Carbon::parse($lession->created_at);
            $todayDate = \Carbon\Carbon::now();
            $lock = false;
            if ($uploadedDate->diffInDays($todayDate) > $lession->lock_after) {
                $lock = true;
            }
        ?>

        <button class="btn btn-link ps-0 @if(! $lock) watchLession @else text-muted @endif" @if( ! $lock) data-href="{{ route('user.account.programs.videos.show',[$program->id,$courses->id,$lession->id]) }}" @endif type="button">
            <i class='bx bxs-movie-play me-2'></i> {{ $lession->lession_name }}
            @if( $lock )
            <span class="text-right me-2">
                <i class='bx bxs-lock-alt text-danger'></i>
            </span>
            @endif
        </button>
        @elseif ( ! $lession->video_lock )
        <button class="btn btn-link ps-0 watchLession "  data-href="{{ route('user.account.programs.videos.show',[$program->id,$courses->id,$lession->id]) }}" type="button">
            <i class='bx bxs-movie-play me-2'></i> {{ $lession->lession_name }}
        </button>
    @endif
</li>
