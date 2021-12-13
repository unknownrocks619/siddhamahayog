<div class="col-md-8 text-left" id="offline_video_list">
    <p class='text-muted'>Please Select Chapter First.</p>
</div>
<div class="row clearfix" id="loading_videos" style="display:none">
        <div class="col-lg-12 col-md-12 col-sm-12 px-2 py-2">
            <div class="card px-4 py-4">
                <div class="header">
                    <h2> <strong>Loading...</strong> <small>Please be Patient.</small> </h2>
                </div>

                <div class="body">                        
                    <div class="progress m-b-5">
                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <span class="sr-only">Loading In Progress</span> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="col-md-4">
    <div class="left">
        @foreach ($chapters as $chapter )
            <a class="chapter_list" href="{{ route('public.offline.public_offline_video_list',['__v'=>encrypt($chapter->id),'__s'=>encrypt($chapter->sibir_record_id)]) }}">
                <div class="top-droppable folder tooltiper tooltiper-up" data-tooltip="0 file" id="folder2">
                    <i class="fa fa-folder" aria-hidden="true"></i>
                    <i class="fa fa-check" aria-hidden="true"></i>
                    <p>
                        {{ $loop->index + 1 }}. 
                        {{ $chapter->chapter_name }}
                    </p>
                </div>            
                </a>
        @endforeach
    </div>

</div>


<script type="text/javascript">
    $(".chapter_list").click(function (event) {
        event.preventDefault();
        var eventThis = this;
        $("#loading_videos").fadeIn("slow",function() {
            $.ajax({
            type : "get",
            url : $(eventThis).attr("href"),
            success: function (response) {
                $("#loading_videos").fadeOut('medium', function() {
                    $("#offline_video_list").fadeIn("fast",function() {
                        $("#offline_video_list").html(response);
                    });
                });
            }
        });
        });

    })
</script>