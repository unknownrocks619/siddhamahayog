<div class="row mt-2">
    <div class="col-md-12">
        <?php
        $history_lession = $watchHistory->lession;
        $vidoe_id = \Illuminate\Support\Str::afterLast($lession->video_link, "/");
        ?>
        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $vidoe_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <p><a href="#">{{ $watchHistory->program->program_name }}| </a> on <a href="#">Siddhamahayog.org</a>.</p>

    </div>
</div>