<div class="row">
    <div class="col-md-12 text-center pt-4 bg-dark d-flex justify-content-center align-items-center flex-column"
        style="min-height:400px    ">
        <h1 class="text-white" style="font-weight: bold;font-size:50px;">
            Play
        </h1>
        <br />
        <p class="text-white fs-4">
            Unable to Play video due to error on your account. If problem pre
            sist
            please create support ticket.
        </p>
        <div>
            <button class="btn btn-info btn-sm mt-1 @if (auth()->user()->role_id == 1) unlock-video-pricing @endif">
                <i class='bx bx-lock-open'></i>
                Unlock Video
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="row">
        <div class="modal-footer">
            <button class="btn btn-info mt-1  @if (auth()->user()->role_id == 1) unlock-video-pricing @endif">
                <i class='bx bx-lock-open'></i>
                Unlock Video
            </button>
        </div>
    </div>
</div>
