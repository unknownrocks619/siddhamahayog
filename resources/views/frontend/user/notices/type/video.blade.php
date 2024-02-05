<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="card-title text-white">
                    {{ $notice->title }}
                </h4>
            </div>
            <div class="card-body text-center">
                <div class="fs-4 text-black">{!! $notice->notice !!}</div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center" style="position: relative;
  overflow: hidden;
  width: 100%;
  padding-top: 56.25%; /">

                        @if($notice->settings->source == "youtube")
                        <iframe style=" position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 100%;" src="https://www.youtube.com/embed/{{ $notice->settings->id }}" title="{{ $notice->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif($notice->settings->source == "vimeo")
                        <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/{{ $notice->settings->id }}?title=0&byline=0&portrait=0&badge=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>
                        <script src="https://player.vimeo.com/api/player.js"></script>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
