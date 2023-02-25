<table class="table table-hover">
    <thead>
        <tr>
            <th>
                Exam name
            </th>
            <th>
                Total Question
            </th>
            <th>
                Start Date
            </th>
            <th>
                End Date
            </th>
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        // get current user
        $enrolledPrograms = \App\Models\ProgramStudent::select(['program_id'])
            ->where('student_id', user()->getKey())
            ->where('active', true)
            ->get()
            ->groupBy('program_id')
            ->toArray();
        if ($enrolledPrograms) {
            // check for exams.
            $questionPaper = \App\Models\ProgramExam::whereIn('program_id', array_keys($enrolledPrograms))
                ->withCount('questions')
                ->where('active', true)
                ->get();
        }
        ?>

        @if (isset($questionPaper) && $questionPaper->count())
            @foreach ($questionPaper as $question)
                <tr>
                    <td>
                        {{ $question->title }}
                    </td>
                    <td>
                        {{ $question->questions_count }}
                    </td>
                    <td>
                        {{ $question->start_date }}
                    </td>
                    <td>
                        {{ $question->end_date }}
                    </td>
                    <td>
                        <button type="submit" class="btn btn-info btn-sm clickable"
                            data-href="{{ route('user.account.programs.exam.overview', [$question->program_id, $question->getKey()]) }}">Start
                            Exam
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
