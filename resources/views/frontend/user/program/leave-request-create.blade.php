@extends("frontend.theme.portal")

@section("title")
{{ $program->program_name }} :: Holiday Requisition Form
@endsection

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('dashboard') }}">Dashboard</a> /</span>
        <span class="text-muted fw-light">
            <a href="{{ route('user.account.programs.program.index') }}">Program</a> /
        </span>
        <span class="text-muted fw-light">
            <a href="{{ route('user.account.programs.program.request.index',$program->id) }}">Holiday Request</a> /
        </span>
        Holiday Requisition Form
    </h4>

    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <form action="{{ route('user.account.programs.program.request.store',$program->id) }}" method="post">
                @csrf
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-header mb-0 p-0">
                            <h5 class="">{{ $program->program_name }} Holiday Requisition Form</h5>
                        </div>
                        <div class="dropdown">
                            <button data-href="{{ route('user.account.programs.program.request.index',$program->id) }}" class="clickable btn btn-danger">
                                <i class="bx bx-block"></i>
                                Close
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row mt-3 mb-2">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Holiday Start Date</label>
                                <input type="date" name="holiday_start_date" id="start_date" class="form-control @error('holiday_start_date') border border-danger @enderror" />
                                @error("holiday_start_date")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="priority" class="form-label">Holiday End Date</label>
                                <input type="date" name="holiday_end_date" id="end_date" class="form-control @error('holiday_end_date') border border-danger @enderror" />
                                @error("holiday_end_date")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="defaultFormControlInput" class="form-label mt-2">Why do you need a holiday? Explain in detail
                                <br /><small class="text-info">
                                    Unicode is not supported.
                                </small>
                            </label>
                            <textarea name="message" class="form-control @error('message') border border-danger @enderror" id="message" cols="30" rows="10">{{ old('message') }}</textarea>
                            <div id="messageResponse" class="form-text">
                                We typically reply within 24 hours
                            </div>
                            @error("message")
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Request holiday</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection


@push("custom_script")

@endpush