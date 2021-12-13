<div class="card" id="cointnue_watch_card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h5>Cotinue Where You Left.</h5>
            </div>
            <div class="col-md-4">
                <a href='#' id="dismiss_suggestion" class='btn btn-sm btn-dark'>Dismiss</a>
            </div>
        </div>
    </div>
    <div class='card-body'>
        <p>
            You were watching {{ $offlineVideo->video_title }} from
            chapter {{ $offlineVideo->chapter->chapter_name }}
        </p>
        <br />
        <a href="#" class='btn btn-info'>Cotinue Watching</a>
    </div>
</div>

<script>
    $("#dismiss_suggestion").click(function(event){
        event.preventDefault();
        $("#cointnue_watch_card").remove();
    })
</script>