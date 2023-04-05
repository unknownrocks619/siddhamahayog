<div class="row">
    <div class="col-lg-12 mx-auto">
        <div class="career-search mb-60">
            <div class="filter-result">
                @foreach ($exams as $exam)
                    <div class="job-box d-md-flex align-items-center justify-content-between mb-30">
                        <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                            <div class="job-content">
                                <h5 class="text-md-left ps-4">
                                    {{ $exam->title }}
                                </h5>
                                @if ($exam->description)
                                    <div class="ps-4">
                                        {!! $exam->description !!}
                                    </div>
                                @endif
                                <ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">
                                    <li class="mr-md-4 text-warning">
                                        <i class="bx bx-file mr-2"></i> Total Question: {{ $exam->questions_count }}
                                    </li>
                                    @if ($exam->start_date)
                                        <li class="mr-md-4 mx-3 text-info">
                                            Start Date: {{ $exam->start_date }}
                                        </li>
                                    @endif
                                    @if ($exam->end_date)
                                        <li class="mr-md-4 text-danger">
                                            End Date: {{ $exam->end_date }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="job-right my-4 flex-shrink-0">
                            @if ($exam->attempts_count >= $exam->questions_count)
                                <button href="#"
                                    data-href="{{ route('user.account.programs.exam.start', [$exam->program_id, $exam->getKey()]) }}"
                                    class="btn  btn-info clickable">
                                    View Result
                                </button>
                            @endif
                            <?php
                            $text = 'Start Exam';
                            if ($exam->attempts_count >= $exam->questions_count) {
                                $text = 'View Answer';
                            }
                            ?>
                            <button href="#"
                                data-href="{{ route('user.account.programs.exam.start', [$exam->program_id, $exam->getKey()]) }}"
                                class="btn  btn-primary clickable">
                                {{ $text }}
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
