<div class="row mt-2">
    <div class="col-md-12">
        <?php
        $vidoe_id = \Illuminate\Support\Str::afterLast($lession->video_link, "/");
        ?>
        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $vidoe_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <div class="mt-5 border text-center">
            <h5>
                You are currently watching.
            </h5>
            <p class="text-danger">
                {{ $program->program_name }} > {{ $course->course_name }} > {{ $lession->lession_name }}
            </p>
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
            url: "{{ route('user.account.programs.videos.store.history',[$program->id,$course->id,$lession->id]) }}",
        })
    }, 5000);

    setTimeout(() => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            global: false,
            url: "{{ route('user.account.programs.videos.video-permission', [$program->id])}}",
            success: function(response) {
                if (response) {
                    $("#videoContent").html(response);
                }
            }
        })
    }, 20000)
</script>