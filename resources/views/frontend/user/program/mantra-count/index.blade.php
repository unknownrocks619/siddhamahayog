@extends("frontend.theme.portal")

@section("content")
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Program /</span>
            <span class="text-muted fw-light"><a href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a> /</span>
            Mantra Count
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <!-- Account -->
                    <h5 class="card-header">Your Total Mantra Count</h5>
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4 justify-content-between">
                            <div class="button-wrapper">
                                <p class="text-muted mb-0">All Your mantra for {{$program->program_name}} will be available here.</p>
                            </div>
                            <div>
                                <button class="btn btn-primary"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#mantra_add_modal"
                                        >
                                    <i class="bx bx-plus"></i> Add Mantra Count
                                </button>
                                <button class="btn btn-danger clickable" data-href="{{ route('user.account.programs.program.index') }}" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-block"></i> Close
                                </button>
                            </div>
                        </div>
                        <table class="table table-border table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Count</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach ($jaaps?->dailyCounter as $jaap)
                                    <tr>
                                        <td>
                                            {{$jaap->count_date}}
                                        </td>
                                        <td>
                                            {{$jaap->total_count}}
                                            Mantra
                                        </td>
                                        <td>
                                            <a href="{{route('frontend.jaap.delete',['jap' => $jaap])}}" onclick="return confirm('You are about to delete your mantra count ?')" class="text-danger">
                                                <i class="bx bx-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-0" />
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resourceImage" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content" id="resourceContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ $program->program_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                Please wait while loading your content...
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    <x-modal modal="mantra_add_modal">
        <div class="modal-header border-bottom border-1">
            <h4>
                Your Daily Yagya Count
            </h4>
        </div>
        <form action="{{route('frontend.jaap.counter-daily')}}" method="post" class="jaap-counter-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div class="form-group">
                            <label for="jap_type">Select Date</label>
                            <input type="date" required value="{{date('Y-m-d')}}" name="date" id="date" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6 mt-2">
                        <label for="total_count">
                            Total Mantra Chat Today
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="number" required name="total_count" id="total_count" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between">
                        <a href="" data-bs-dismiss="modal" class="text-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save My Jaap</button>
                    </div>
                </div>
            </div>
        </form>
    </x-modal>
@endsection

@push("custom_script")
    <script type="text/javascript">
        $("#resourceImage").on("shown.bs.modal", function(event) {
            $.ajax({
                method: "get",
                url: event.relatedTarget.dataset.href,
                success: function(response) {
                    $("#resourceContent").html(response);
                }
            })
        });
    </script>
@endpush
