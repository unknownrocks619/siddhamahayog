<div class="modal-header">
    <h5 class="modal-title" id="exampleModalToggleLabel">
        {{ $course->course_name }} - {{ $lession->lession_name }}
    </h5>
    <button type="button" class="btn-close bg-danger text-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-0">
    <div class="row mt-2">
        <div class="col-md-12">
            <?php
            $video_id = \Illuminate\Support\Str::afterLast($lession->video_link, '/');
            ?>
            <div style="padding:56.25% 0 0 0;position:relative;"><iframe
                    src="https://player.vimeo.com/video/{{ $video_id }}?title=0&byline=0&portrait=0&badge=0"
                    style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>
            <script src="https://player.vimeo.com/api/player.js"></script>
            <div class="mt-2 border text-center">
                <h5>
                    You are currently watching.
                </h5>
                <p class="text-danger">
                    {{ $program->program_name }} > {{ $course->course_name }} > {{ $lession->lession_name }}
                </p>
            </div>
            <div class="mt-2 fs-4 text-black ms-2 py-1">
                {!! $lession->video_description !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    setTimeout(() => {
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            global: false,
            url: "{{ route('user.account.programs.videos.store.history', [$program->id, $course->id, $lession->id]) }}",
        })
    }, 5000);
    setTimeout(() => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            global: false,
            url: "{{ route('user.account.programs.videos.video-permission', [$program->id, $lession->getKey()]) }}",
            success: function(response) {
                console.log('response: ', response);
                if (response) {
                    $(".post-modal-body-content").empty().html(response);
                }
            }
        })
    }, 100)
</script>
