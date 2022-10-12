<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="card-title text-white">
                    {{ $notice->title }}
                </h4>
            </div>
            <div class="card-body">
                {!! $notice->notice !!}
                <div class="row mt-3">
                    <div class="col-md-12">
                        <img src="{{ asset($notice->settings->path) }}" alt="{{ $notice->title }}" srcset="{{ asset($notice->settings->path) }}">
                    </div>
                    <button data-href="{{ asset($notice->settings->path) }}" class="btn btn-outline-primary clikcable">
                        Download File
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>