@php
    // lets check if this user have already watched.
    $user_detail = auth()->user()->user_detail_id;
    $attendance = \App\Models\OfflineVideoAttendance::where('video_id',$record->id)
                                                        ->where('user_id',$user_detail)
                                                        ->first();
    // check if this user is authorized.
    $userAuth = \App\Models\UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                                    ->where('sibir_record_id',$record->event_id)
                                                    ->first();
    dd($userAuth);
    if ($attendance && $userAuth) {
        $attendance->total_watch = $attendance->total_watch + 1;
        $attendance->start_time = \Carbon\Carbon::now();
        $attendance->last_visit_time = \Carbon\Carbon::now();
        $attendance->save();

        // 
    } elseif($userAuth && ! $attendance) {
        dd("if not attendance");
        $attendance = new \App\Models\OfflineVideoAttendance;
        $attendance->video_id = $record->id;
        $attendance->user_id = $user_detail;
        $attendance->total_watch = 1;
        $attendance->last_visit_time = \Carbon\Carbon::now();
        $attendance->start_time = \Carbon\Carbon::now();
        $attendance->save();
    }
    dd($attendance);
@endphp
<div class='modal-body'>
    @if( ! $userAuth )
        <p class='text-danger'>
        Sorry, You are not authorized to view this video.
    </p>
    @else
        @if($record->source == 'UPLOAD')
        <link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
        <video
            id="my-video"
            class="video-js"
            controls
            preload="auto"
            width="640"
            height="264"
            poster="MY_VIDEO_POSTER.jpg"
            data-setup="{}"
        >
        <source src="{{ video_asset($record->offline_video) }}" type="video/mp4" />

        </video>
        @elseif($record->source == "VIMEO")
        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $record->youtube_id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
            <p><a href="#">{{ $record->event_source->sibir_title }}| </a> <a href="#">{{ config('app.name') }}</a> on <a href="#">Siddhamahayog.org</a>.</p>

        @elseif($record->source=="YOUTUBE")
        <iframe
            modestbranding=1
            width="100%"  
            height="315" 
            src="https://www.youtube-nocookie.com/embed/{{ $record->youtube_id }}?controls=0&modestbranding=1" 
            title="YouTube video player" 
            frameborder="0" 
            showinfo="0"
            onload="adjust_width()"
            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture">
        </iframe>
        @endif
        
    @endif
</div>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    function adjust_width(){
//         var iframe = document.getElementsByTagName("iframe")[0];
// var elmnt = iframe.contentWindow.document.getElementByClassName(".ytp-copylink-button")[0];
// elmnt.style.display = "none";

        // var iframeWidth = $("iframe").contents().width();
        // // var iframe = $('iframe').contents().getElementByClassName('ytp-copylink-button').hide();
        // $("iframe").width(iframeWidth);
        // alert("hell");
    }
    var request_param=1;
    $('#page-modal').on('hidden.bs.modal', function () {
        $.ajax({
            type: "post",
            data : "r_id={{ encrypt($record->id) }}&a_id={{encrypt($attendance->id)}}&request_param="+request_param,
            url : "{{ route('public_offline_video_attendance',[encrypt($record->id),encrypt($attendance->id)]) }}",
            success: function (response) {
                window.location.href = "{{ route('public_user_dashboard') }}"
            }
        })
    });   
    request_param = false;
</script>
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
