<div class="row my-2">
    <div class="col-md-12">

        <div class="card bg-warning">
            <div class="card-header border-bottom pb-0 mb-1">
                <h4 class="card-title">
                    {{ $notice->title }}
                </h4>
            </div>
            <div class="card-body text-white pt-2">
                {!! $notice->notice !!}
            </div>
        </div>
    </div>
</div>