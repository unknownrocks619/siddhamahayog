@extends('frontend.theme.portal')

@push('page_title')
    - {{ $program->program_name }} - {{ $exam->title }}
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"> Programs / </span>
            <span class="text-muted fw-light">{{ $program->program_name }} /</span> Exam Center
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h3 class="card-header">{{ $exam->title }}</h3>
                    <div class="card-body">
                        {!! $exam->description !!}

                        <h5>
                            Questions Summary
                        </h5>
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <strong>
                                    Total Question:
                                </strong>
                                {{ $exam->questions->count() }}
                            </div>

                            @foreach ($overview as $questionType => $count)
                                <div class="col-md-12 col-12">
                                    <strong>
                                        {{ ucwords(strtolower($questionType)) }}
                                    </strong>
                                    :
                                    {{ $count }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end align-items-center">
                                @if ($memberAnswer && !empty($memberAnswer))
                                    <button type="submit" class="btn btn-danger ms-2">
                                        End
                                    </button>
                                @endif
                                <button type="submit" class="btn btn-primary ms-2">
                                    Start My Exam
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
